<?php

namespace App\Http\Controllers\admin\insurance;

use App\Http\Controllers\Controller;
use App\Models\EndorsementInsuranceDetail;
use App\Models\InsuranceRenewalDetail;
use App\Models\MstExecutive;
use App\Models\MstInsurance;
use App\Models\MstParty;
use App\Models\MstSupplier;
use App\Models\TermInsurance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TermInsuranceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.term.insurance.index');
        } else {
            $insurances = TermInsurance::with('party:id,party_name')
                ->when($request->filled('party_name'), function ($query) use ($request) {
                    $query->whereHas('party', function ($subquery) use ($request) {
                        $subquery->where('party_name', 'like', '%' . $request->party_name . '%');
                    });
                })
                ->PolicyNumber($request)
                ->orderBy('id', 'desc')
                ->paginate($request->limit ? $request->limit : 10);
        }
        $parties = MstParty::select('id','party_name')->get();
        return view('admin.term-insurance.index', compact('insurances','parties'));
    }


    public function create()
    {
        $executives = MstExecutive::pluck('name', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        $parties = MstParty::select('id', 'party_name')->get();
        $insurance_company = MstInsurance::pluck('name', 'id');
        $case = 'add';

        return view('admin.term-insurance.create', compact('executives', 'parties', 'insurance_company', 'case'));
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
                Rule::unique('term_insurances')->ignore($request->id),
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
        try {
            DB::beginTransaction();
            $renewal = $request->input('renewal', 'false');
            if ($request->id) {
                $refurbishment = TermInsurance::find($request->id);
                $refurbishment->update($input);
                if ($renewal === 'true') {
                    $data = [
                        'insurance_id' => $request->id,
                        'insurance_from_date' => $request->start_date,
                        'insurance_to_date' => $request->end_date,
                        'premium' => $request->premium,
                        'gst' => $request->gst,
                        'sum_insured' => $request->sum_assured,
                        'type' => 2,
                    ];
                    InsuranceRenewalDetail::create($data);
                }
            } else {
                TermInsurance::create($input);
                $data = [
                    'insurance_id' => $request->id,
                    'insurance_from_date' => $request->start_date,
                    'insurance_to_date' => $request->end_date,
                    'premium' => $request->premium,
                    'gst' => $request->gst,
                    'sum_insured' => $request->sum_assured,
                    'type' => 2,
                ];
                InsuranceRenewalDetail::create($data);
            }

            DB::commit();

            \toastr()->success(ucfirst('insurance saved successfully'));
            return redirect()->route('admin.term.insurance.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving car insurance');
            return redirect()->back();
        }
    }

    public function show(Request $request, $id)
    {
        $renewal = $request->query('renewal', 'false');
        $insurance = TermInsurance::find($id);
        $endorsement = EndorsementInsuranceDetail::where('insurance_type', 2)
            ->where('policy_number', $insurance->policy_number)
            ->first();
        $executives = MstExecutive::pluck('name', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        $parties = MstParty::select('id', 'party_name')->get();
        $insurance_company = MstInsurance::pluck('name', 'id');
        $case = 'edit';


        return view('admin.term-insurance.create', compact('insurance', 'executives', 'parties',  'insurance_company', 'case', 'renewal', 'endorsement'));
    }

    public function view($id)
    {
        $insurance = TermInsurance::find($id);
        $endorsement = EndorsementInsuranceDetail::where('insurance_type', 3)
            ->where('policy_number', $insurance->policy_number)
            ->first();
        $executives = MstExecutive::pluck('name', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        $parties = MstParty::select('id', 'party_name')->get();
        $insurance_company = MstInsurance::pluck('name', 'id');
        $case = 'edit';

        return view('admin.term-insurance.view', compact('insurance', 'executives', 'parties', 'insurance_company', 'case', 'endorsement'));
    }

    public function renewalIndex()
    {
        $oneMonthLater = Carbon::now()->addDays(31)->toDateString();
        $today = Carbon::now()->toDateString();

        $termInsurances = TermInsurance::whereBetween('insurance_to_date', [$today, $oneMonthLater])
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.term-insurance.renewal-index', compact('termInsurances'));
    }

    public function endorsementIndex(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.endorsement.term.insurance.index');
        } else {
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');

            $query = EndorsementInsuranceDetail::query()->where('insurance_type', 2);
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
        return view('admin.term-insurance.endorsement-index', compact('insurances'));
    }
    public function endorsementCreate()
    {
        $policyNumbers = TermInsurance::pluck('policy_number', 'id');
        return view('admin.term-insurance.endorsement-create', compact('policyNumbers'));
    }

    public function endorsementStore(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = [
                'insurance_id' => $request->insurance_id,
                'policy_id' => $request->policy_id,
                'policy_number' => $request->policy_number,
                'insurance_type' => 2,
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
            return redirect()->route('admin.endorsement.term.insurance.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving endorsement insurance details');
            return redirect()->back();
        }
    }

    public function endorsementShow($id)
    {
        $endorsement = EndorsementInsuranceDetail::find($id);
        $policyNumbers = TermInsurance::pluck('policy_number', 'id');
        return view('admin.term-insurance.endorsement-create', compact('endorsement', 'policyNumbers'));
    }

    public function endorsementView($id)
    {
        $endorsement = EndorsementInsuranceDetail::find($id);
        $policyNumbers = TermInsurance::pluck('policy_number', 'id');
        return view('admin.term-insurance.endorsement-view', compact('endorsement', 'policyNumbers'));
    }
}
