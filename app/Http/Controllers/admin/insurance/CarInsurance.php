<?php

namespace App\Http\Controllers\admin\insurance;

use App\Exports\CarInsuranceExport;
use App\Http\Controllers\Controller;
use App\Models\CarInsurance as ModelsCarInsurance;
use App\Models\EndorsementInsuranceDetail;
use App\Models\InsuranceRenewalDetail;
use App\Models\MstBrandType;
use App\Models\MstExecutive;
use App\Models\MstInsurance;
use App\Models\MstModel;
use App\Models\MstParty;
use App\Models\MstSupplier;
use App\Models\Purchase;
use App\Models\Refurbishment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Colors\Rgb\Channels\Red;
use Maatwebsite\Excel\Facades\Excel;

class CarInsurance extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.car.insurance.index');
        } else {
            $insurances = ModelsCarInsurance::with('party:id,party_name','party.partyWhatsapp','company:id,name')
                ->when($request->filled('party_name'), function ($query) use ($request) {
                    $query->whereHas('party', function ($subquery) use ($request) {
                        $subquery->where('party_name', 'like', '%' . $request->party_name . '%');
                    });
                })
                ->when($request->filled('executive'), function ($query) use ($request) {
                    $query->where('mst_executive_id', $request->executive);
                })
                ->when($request->filled('insurance_company'), function ($query) use ($request) {
                    $query->where('insurance_company', $request->insurance_company);
                })
                ->when($request->filled('fromDate'), function ($query) use ($request) {
                    $query->whereDate('created_at', '>=', $request->fromDate);
                })
                ->when($request->filled('toDate'), function ($query) use ($request) {
                    $query->whereDate('created_at', '<=', $request->toDate);
                })
                // ->PolicyNumber($request)
                // ->CarNumber($request)
                ->orderBy('insurance_done_date', 'desc')
                ->paginate($request->limit ? $request->limit : 10);
        }
        // dd($insurances);
        $insurance_company = MstInsurance::pluck('name', 'id');
        $executives = MstExecutive::pluck('name', 'id');
        $parties = MstParty::select('id','party_name')->get();

        return view('admin.car_insurance.index', compact('insurances', 'insurance_company', 'executives','parties'));
    }


    public function create()
    {
        $executives = MstExecutive::pluck('name', 'id');
        $models = MstModel::pluck('model', 'id');
        $brands = MstBrandType::pluck('type', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        $headOptions = Refurbishment::getHeadOption();
        $paymentmodes = Refurbishment::getPaymentOption();
        $parties = MstParty::with('partyContact')->get()->map(function ($party) {
            $contactNumbers = $party->partyContact->pluck('number')->implode(', ');
            return [
                'id' => $party->id,
                'name' => $party->party_name,
                'contacts' => $contactNumbers,
                'father_name' => $party->father_name
            ];
        });
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        $insurance_company = MstInsurance::pluck('name', 'id');
        $case = 'add';

        return view('admin.car_insurance.create', compact('executives', 'models', 'suppliers', 'regNumbers', 'headOptions', 'paymentmodes', 'parties', 'vehicles', 'insurance_company', 'case', 'brands'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'party_id' => 'required',
            'insurance_done_date' => 'required',
            'insurance_from_date' => 'required',
            'insurance_to_date' => 'required',
            'insurance_company' => 'required',
            'premium' => 'integer',
            'gst' => 'integer',
            'policy_number' => [
                'required',
                Rule::unique('car_insurances')->ignore($request->id),
            ],
        ], [
            'party_id' => 'Please select party'
        ]);
        $input = $request->all();


        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();
            $renewal = $request->input('renewal', 'false');
            $input['insurance_documents'] = $request->insurance_documents_edit;
            if ($request->hasFile('insurance_documents')) {
                $file = $request->file('insurance_documents');
                $originalFileName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileName = pathinfo($originalFileName, PATHINFO_FILENAME);
                $uniqueFileName = $fileName . '_' . time() . '.' . $extension;
                $file->storeAs('documents', $uniqueFileName);
                $input['insurance_documents'] = $uniqueFileName;
            }

            if ($request->id) {
                $refurbishment = ModelsCarInsurance::find($request->id);
                $refurbishment->update($input);
                if ($renewal === 'true') {
                    $data = [
                        'insurance_id' => $request->id,
                        'insurance_from_date' => $request->start_date,
                        'insurance_to_date' => $request->end_date,
                        'premium' => $request->premium,
                        'gst' => $request->gst,
                        'sum_insured' => $request->sum_assured,
                        'type' => 4,
                    ];
                    InsuranceRenewalDetail::create($data);
                }
            } else {
                ModelsCarInsurance::create($input);
                $data = [
                    'insurance_id' => $request->id,
                    'insurance_from_date' => $request->start_date,
                    'insurance_to_date' => $request->end_date,
                    'premium' => $request->premium,
                    'gst' => $request->gst,
                    'sum_insured' => $request->sum_assured,
                    'type' => 4,
                ];
                InsuranceRenewalDetail::create($data);
            }

            DB::commit();

            \toastr()->success(ucfirst('insurance saved successfully'));
            return redirect()->route('admin.car.insurance.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving car insurance');
            return redirect()->back();
        }
    }

    public function show(Request $request, $id)
    {
        $renewal = $request->query('renewal', 'false');
        $insurance = ModelsCarInsurance::find($id);
        $endorsement = EndorsementInsuranceDetail::where('insurance_type', 4)
            ->where('policy_number', $insurance->policy_number)
            ->first();
        $executives = MstExecutive::pluck('name', 'id');
        $models = MstModel::pluck('model', 'id');
        $brands = MstBrandType::pluck('type', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        $headOptions = Refurbishment::getHeadOption();
        $paymentmodes = Refurbishment::getPaymentOption();
        $parties = MstParty::with('partyContact')->get()->map(function ($party) {
            $contactNumbers = $party->partyContact->pluck('number')->implode(', ');
            return [
                'id' => $party->id,
                'name' => $party->party_name,
                'contacts' => $contactNumbers
            ];
        });
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        $insurance_company = MstInsurance::pluck('name', 'id');
        $case = 'edit';
// dd($insurance);

        return view('admin.car_insurance.create', compact('insurance', 'executives', 'models', 'suppliers', 'regNumbers', 'headOptions', 'paymentmodes', 'parties', 'vehicles', 'insurance_company', 'case', 'renewal', 'endorsement', 'brands'));
    }

    public function view($id)
    {
        $insurance = ModelsCarInsurance::find($id);
        $endorsement = EndorsementInsuranceDetail::where('insurance_type', 4)
            ->where('policy_number', $insurance->policy_number)
            ->first();
        $executives = MstExecutive::pluck('name', 'id');
        $models = MstModel::pluck('model', 'id');
        $brands = MstBrandType::pluck('type', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        $headOptions = Refurbishment::getHeadOption();
        $paymentmodes = Refurbishment::getPaymentOption();
        $parties = MstParty::select('id', 'party_name')->get();
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        $insurance_company = MstInsurance::pluck('name', 'id');
        $case = 'edit';

        return view('admin.car_insurance.view', compact('insurance', 'executives', 'models', 'suppliers', 'regNumbers', 'headOptions', 'paymentmodes', 'parties', 'vehicles', 'insurance_company', 'case', 'endorsement', 'brands'));
    }

    public function export($extension = null)
    {
        if ($extension == 'xlsx') {
            $extension = "xlsx";
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        } elseif ($extension == 'csv') {
            $extension = "csv";
            $exportFormat = \Maatwebsite\Excel\Excel::CSV;
        } else {
            $extension = "xlsx";
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        }
        $filename = 'car_insurance-' . date('d-m-Y') . '.' . $extension;
        return Excel::download(new CarInsuranceExport, $filename, $exportFormat);
    }

    public function renewalIndex(Request $request)
    {
        $oneMonthLater = Carbon::now()->addDays(31)->toDateString();
        $today = Carbon::now()->toDateString();

        if ($request->has('clear_search')) {
            return redirect()->route('admin.car.insurance.index');
        } else {
            $carInsurances = ModelsCarInsurance::with('party:id,party_name')
                ->whereBetween('insurance_to_date', [$today, $oneMonthLater])
                ->when($request->filled('party_name'), function ($query) use ($request) {
                    $query->whereHas('party', function ($subquery) use ($request) {
                        $subquery->where('party_name', 'like', '%' . $request->party_name . '%');
                    });
                })
                ->when($request->filled('executive'), function ($query) use ($request) {
                    $query->where('mst_executive_id', $request->executive);
                })
                ->when($request->filled('insurance_company'), function ($query) use ($request) {
                    $query->where('insurance_company', $request->insurance_company);
                })
                ->when($request->filled('fromDate'), function ($query) use ($request) {
                    $query->whereDate('created_at', '>=', $request->fromDate);
                })
                ->when($request->filled('toDate'), function ($query) use ($request) {
                    $query->whereDate('created_at', '<=', $request->toDate);
                })
                ->orderBy('id', 'desc')
                ->paginate($request->limit ? $request->limit : 10);
        }

        $insurance_company = MstInsurance::pluck('name', 'id');
        $executives = MstExecutive::pluck('name', 'id');
        $parties = MstParty::select('id','party_name')->get();

        return view('admin.car_insurance.renewal-index', compact('carInsurances', 'insurance_company', 'executives','parties'));
    }

    public function getInsuranceData(Request $request)
    {
        $policy = $request->input('policy');

        $policyData = ModelsCarInsurance::with('insurance')->where('id', $policy)->first();
        if ($policyData) {
            return [
                'insurance_company' => $policyData->insurance_company,
                'policy_number' => $policyData->policy_number,
                'insurance_done_date' => $policyData->insurance_done_date,
                'insurance_from_date' => $policyData->insurance_from_date,
                'insurance_to_date' => $policyData->insurance_to_date,
            ];
        } else {
            return response()->json([
                'error' => 'No policydData found for the given status',
            ], 404);
        }
    }

    public function endorsementIndex(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.endorsement.insurance.index');
        } else {
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');

            $query = EndorsementInsuranceDetail::query()->where('insurance_type', 4);
            $query->when($request->filled('policy_number'), function ($query) use ($request) {
                $query->where('policy_number', $request->policy_number);
            });
            if ($fromDate) {
                $query->whereDate('date', '>=', $fromDate);
            }
            if ($toDate) {
                $query->whereDate('date', '<=', $toDate);
            }

            $insurances = $query->orderBy('id', 'desc')->paginate($request->limit ? $request->limit : 10);
        }
        return view('admin.car_insurance.endorsement-index', compact('insurances'));
    }
    public function endorsementCreate()
    {
        $policyNumbers = ModelsCarInsurance::pluck('policy_number', 'id');
        return view('admin.car_insurance.endorsement-create', compact('policyNumbers'));
    }

    public function endorsementStore(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = [
                'insurance_id' => $request->insurance_id,
                'policy_id' => $request->policy_id,
                'policy_number' => $request->policy_number,
                'insurance_type' => 4,
                'date' => $request->date,
                'sum_assured' => $request->sum_assured,
                'premium' => $request->premium,
                'endorsement_details' => $request->endorsement_details,
            ];

            if ($request->id) {
                EndorsementInsuranceDetail::where('id', $request->id)->update($data);
            } else {
                EndorsementInsuranceDetail::create($data);
            }

            DB::commit();

            \toastr()->success(ucfirst('Endorsement Insurance details saved successfully'));
            return redirect()->route('admin.endorsement.insurance.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving endorsement insurance details');
            return redirect()->back();
        }
    }

    public function endorsementShow($id)
    {
        $endorsement = EndorsementInsuranceDetail::find($id);
        $policyNumbers = ModelsCarInsurance::pluck('policy_number', 'id');
        return view('admin.car_insurance.endorsement-create', compact('endorsement', 'policyNumbers'));
    }

    public function endorsementView($id)
    {
        $endorsement = EndorsementInsuranceDetail::find($id);
        $policyNumbers = ModelsCarInsurance::pluck('policy_number', 'id');
        return view('admin.car_insurance.endorsement-view', compact('endorsement', 'policyNumbers'));
    }

    public function getCars(Request $request)
    {
        $brandId = $request->input('brand_type');
        $modelId = $request->input('model_type');

        // Assuming you have a relationship between Purchase and Color models
        $vehicles = Purchase::where('mst_model_id', $modelId)
            ->where('mst_brand_type_id', $brandId)
            ->whereIn('status', [6, 7])
            ->select('id', 'reg_number')
            ->get();

        $html = '<option value="">Choose...</option>';
        foreach ($vehicles as $vehicle) {
            $selected = $vehicle->id == $request->input('selected_subtype') ? 'selected' : '';
            $html .= '<option value="' . $vehicle->id . '" ' . $selected . '>' . $vehicle->reg_number . '</option>';
        }
        echo $html;
    }

    public function getVehicleNumbers($number){
        $vehicleNumbers =  Purchase::select('id', 'reg_number')->where('mst_model_id',$number)->whereIn('status', [6, 7])->pluck('number', 'id');
        return response()->json(['vehicle_numbers' => $vehicleNumbers]);
    }
}
