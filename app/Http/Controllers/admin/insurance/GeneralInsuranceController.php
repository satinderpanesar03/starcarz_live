<?php

namespace App\Http\Controllers\admin\insurance;

use App\Exports\GeneralInsuranceExport;
use App\Http\Controllers\Controller;
use App\Models\EndorsementInsuranceDetail;
use App\Models\GeneralInsurance;
use App\Models\InsuranceRenewalDetail;
use App\Models\MstExecutive;
use App\Models\MstInsurance;
use App\Models\MstInsuranceType;
use App\Models\MstParty;
use App\Models\MstSupplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class GeneralInsuranceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.general.insurance.index');
        } else {
            $insurances = GeneralInsurance::with('party:id,party_name')
                ->when($request->filled('party_name'), function ($query) use ($request) {
                    $query->whereHas('party', function ($subquery) use ($request) {
                        $subquery->where('party_name', 'like', '%' . $request->party_name . '%');
                    });
                })
                ->PolicyNumber($request)
                ->orderBy('id', 'desc')
                ->paginate($request->limit ? $request->limit : 10);
        }
        return view('admin.general-insurance.index', compact('insurances'));
    }

    public function renewalIndex()
    {
        $oneMonthLater = Carbon::now()->addDays(31)->toDateString();
        $today = Carbon::now()->toDateString();

        $generalInsurances = GeneralInsurance::whereBetween('insurance_to_date', [$today, $oneMonthLater])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.general-insurance.renewal-index', compact('generalInsurances'));
    }


    public function create()
    {
        $executives = MstExecutive::pluck('name', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        $parties = MstParty::with('partyContact')->get()->map(function ($party) {
            $contactNumbers = $party->partyContact->pluck('number')->implode(', ');
            return [
                'id' => $party->id,
                'name' => $party->party_name,
                'contacts' => $contactNumbers
            ];
        });
        $insurance_company = MstInsurance::pluck('name', 'id');
        $case = 'add';
        $insurance_types = MstInsuranceType::pluck('name', 'id');

        return view('admin.general-insurance.create', compact('executives', 'parties', 'insurance_company', 'case', 'insurance_types'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mst_party_id' => 'required',
            'insurance_done_date' => 'required',
            'insurance_from_date' => 'required',
            'insurance_to_date' => 'required',
            'insurance_company' => 'required',
            'premium' => 'integer',
            'gst' => 'integer',
            'policy_number' => [
                'required',
                Rule::unique('general_insurances')->ignore($request->id),
            ],
            'sum_insured' => 'integer',
            'total' => 'integer'
        ], [
            'mst_party_id' => 'Please select party'
        ]);
        $input = $request->all();

        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->hasFile('policy_image')) {
            if ($request->id) {
                $oldPurchase = GeneralInsurance::find($request->id);
                Storage::delete('public/images/' . $oldPurchase->policy_image);
            }
            $uploadedFile = $request->file('policy_image');

            $filename = time() . '_general_insurance_' . $uploadedFile->getClientOriginalName();
            $uploadedFile->storeAs('public/images', $filename);
            $input['policy_image'] = 'images/' . $filename;
        }
        try {
            DB::beginTransaction();
            $renewal = $request->input('renewal', 'false');
            if ($request->id) {
                $refurbishment = GeneralInsurance::find($request->id);
                $refurbishment->update($input);
                if ($renewal === 'true') {
                    $data = [
                        'insurance_id' => $request->id,
                        'insurance_from_date' => $request->start_date,
                        'insurance_to_date' => $request->end_date,
                        'premium' => $request->premium,
                        'gst' => $request->gst,
                        'sum_insured' => $request->sum_assured,
                        'type' => 3,
                    ];
                    InsuranceRenewalDetail::create($data);
                }
            } else {
                GeneralInsurance::create($input);
                $data = [
                    'insurance_id' => $request->id,
                    'insurance_from_date' => $request->start_date,
                    'insurance_to_date' => $request->end_date,
                    'premium' => $request->premium,
                    'gst' => $request->gst,
                    'sum_insured' => $request->sum_assured,
                    'type' => 3,
                ];
            }

            DB::commit();

            \toastr()->success(ucfirst('gereral insurance saved successfully'));
            return redirect()->route('admin.general.insurance.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving general insurance');
            return redirect()->back();
        }
    }

    public function show(Request $request, $id)
    {
        $renewal = $request->query('renewal', 'false');
        $insurance = GeneralInsurance::find($id);
        $endorsement = EndorsementInsuranceDetail::where('insurance_type', 3)
            ->where('policy_number', $insurance->policy_number)
            ->first();
        $executives = MstExecutive::pluck('name', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        $parties = MstParty::select('id', 'party_name')->get();
        $insurance_company = MstInsurance::pluck('name', 'id');
        $insurance_types = MstInsuranceType::pluck('name', 'id');
        $case = 'edit';

        return view('admin.general-insurance.create', compact('insurance', 'executives', 'parties',  'insurance_company', 'case', 'insurance_types', 'renewal', 'endorsement'));
    }

    public function view($id)
    {
        $insurance = GeneralInsurance::find($id);
        $endorsement = EndorsementInsuranceDetail::where('insurance_type', 3)
            ->where('policy_number', $insurance->policy_number)
            ->first();
        $executives = MstExecutive::pluck('name', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        $parties = MstParty::select('id', 'party_name')->get();
        $insurance_company = MstInsurance::pluck('name', 'id');
        $case = 'edit';
        $insurance_types = MstInsuranceType::pluck('name', 'id');

        return view('admin.general-insurance.view', compact('insurance', 'executives', 'parties', 'insurance_company', 'case', 'insurance_types', 'endorsement'));
    }

    public function getInsuranceTypeStatus(Request $request)
    {
        $id = $request->query('id');
        $insuranceType = MstInsuranceType::find($id);
        if ($insuranceType) {
            return response()->json([
                'name' => $insuranceType->name,
            ]);
        }
        return response()->json([
            'error' => 'Insurance type not found',
        ], 404);
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
        $filename = 'general-insurance-' . date('d-m-Y') . '.' . $extension;
        return Excel::download(new GeneralInsuranceExport, $filename, $exportFormat);
    }

    public function printData()
    {
        // Retrieve all insurance records
        $insurances = GeneralInsurance::with('party', 'insurance')->get();

        // Pass the insurance records to the print-all view
        return view('admin.general-insurance.print-data', compact('insurances'));
    }

    public function endorsementIndex(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.endorsement.general.insurance.index');
        } else {
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');

            $query = EndorsementInsuranceDetail::query()->where('insurance_type', 3);
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

        return view('admin.general-insurance.endorsement-index', compact('insurances'));
    }
    public function endorsementCreate()
    {
        $policyNumbers = GeneralInsurance::pluck('policy_number', 'id');
        return view('admin.general-insurance.endorsement-create', compact('policyNumbers'));
    }

    public function endorsementStore(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = [
                'insurance_id' => $request->insurance_id,
                'policy_id' => $request->policy_id,
                'policy_number' => $request->policy_number,
                'insurance_type' => 3,
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
            return redirect()->route('admin.endorsement.general.insurance.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving endorsement insurance details');
            return redirect()->back();
        }
    }

    public function endorsementShow($id)
    {
        $endorsement = EndorsementInsuranceDetail::find($id);
        $policyNumbers = GeneralInsurance::pluck('policy_number', 'id');
        return view('admin.general-insurance.endorsement-create', compact('endorsement', 'policyNumbers'));
    }

    public function endorsementView($id)
    {
        $endorsement = EndorsementInsuranceDetail::find($id);
        $policyNumbers = GeneralInsurance::pluck('policy_number', 'id');
        return view('admin.general-insurance.endorsement-view', compact('endorsement', 'policyNumbers'));
    }
}
