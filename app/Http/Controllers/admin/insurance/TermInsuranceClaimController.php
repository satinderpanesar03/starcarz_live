<?php

namespace App\Http\Controllers\admin\insurance;

use App\Http\Controllers\Controller;
use App\Models\MstExecutive;
use App\Models\MstInsurance;
use App\Models\MstInsuranceType;
use App\Models\MstParty;
use App\Models\TermInsurance;
use App\Models\TermInsuranceClaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TermInsuranceClaimController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.claim.term-insurance.index');
        } else {
            $insurances = TermInsuranceClaim::with('party:id,party_name')
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
        return view('admin.term-insurance-claim.index', compact('insurances','parties'));
    }

    public function create()
    {
        $executives = MstExecutive::pluck('name', 'id');
        $parties = MstParty::select('id', 'party_name')->get();
        $insurance_company = MstInsurance::pluck('name', 'id');
        $case = 'add';
        $insurance_types = MstInsuranceType::pluck('name', 'id');
        $policyNumbers = TermInsurance::pluck('policy_number', 'id');
        $status = TermInsuranceClaim::getStatus();

        return view('admin.term-insurance-claim.create', compact('executives', 'parties', 'insurance_company', 'case', 'insurance_types', 'policyNumbers', 'status'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'policy_number_id' => 'required',
        ], [
            'policy_number_id' => 'Please select policy number'
        ]);
        $input = $request->all();
        $input['mst_party_id'] = $request->party_id;


        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if ($request->id) {
                $refurbishment = TermInsuranceClaim::find($request->id);
                $refurbishment->update($input);
            } else {
                TermInsuranceClaim::create($input);
            }

            DB::commit();

            \toastr()->success(ucfirst('Term insurance claim saved successfully'));
            return redirect()->route('admin.claim.term-insurance.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving term insurance claim');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $insurance = TermInsuranceClaim::find($id);
        $executives = MstExecutive::pluck('name', 'id');
        $parties = MstParty::select('id', 'party_name')->get();
        $insurance_company = MstInsurance::pluck('name', 'id');
        $insurance_types = MstInsuranceType::pluck('name', 'id');
        $case = 'edit';
        $policyNumbers = TermInsurance::pluck('policy_number', 'id');
        $status = TermInsuranceClaim::getStatus();

        return view('admin.term-insurance-claim.create', compact('insurance', 'executives', 'parties',  'insurance_company', 'case', 'insurance_types', 'policyNumbers', 'status'));
    }

    public function view($id)
    {
        $insurance = TermInsuranceClaim::find($id);
        $executives = MstExecutive::pluck('name', 'id');
        $parties = MstParty::select('id', 'party_name')->get();
        $insurance_company = MstInsurance::pluck('name', 'id');
        $case = 'edit';
        $insurance_types = MstInsuranceType::pluck('name', 'id');
        $policyNumbers = TermInsurance::pluck('policy_number', 'id');
        $status = TermInsuranceClaim::getStatus();

        return view('admin.term-insurance-claim.view', compact('insurance', 'executives', 'parties', 'insurance_company', 'case', 'insurance_types', 'policyNumbers', 'status'));
    }

    public function getPolicyData(Request $request)
    {
        $policy = $request->input('policy');

        $policyData = TermInsurance::with('party', 'executive', 'insurance', 'partyContact', 'partyCity')->where('id', $policy)->first();
       
        $firstPartyCity = $policyData->partyCity->first();
        $partyContacts = $policyData->partyContact;
        $partyContact = $partyContacts->first(function ($partyContact) {
            return $partyContact->type == 2;
        });
        if ($policyData) {
            return [
                'purchase_id' => $policyData->id,
                'party_id' => $policyData->mst_party_id,
                'insurance_company' => $policyData->insurance_company,
                'policy_number' => $policyData->policy_number,
                'insurance_done_by' => $policyData->insurance_done_by,
                'insurance_done_date' => $policyData->insurance_done_date,
                'insurance_from_date' => $policyData->insurance_from_date,
                'insurance_to_date' => $policyData->insurance_to_date,
                'premium' => $policyData->premium,
                'gst' => $policyData->gst,
                'sum_insured' => $policyData->sum_insured,
                'total' => $policyData->total,
                'mst_party_id' => $policyData->party->party_name,
                'registered_owner' => $policyData->party->party_name,
                'email' => $policyData->party->email,
                'office_city' => ($policyData->party->office_city) ? $policyData->party->office_city : (($firstPartyCity->city) ? $firstPartyCity->city : ''),
                'office_number' => ($policyData->party->office_number) ? $policyData->party->office_number : (($partyContact->number) ? $partyContact->number : ''),
                'office_address' => $policyData->party->office_address,
                'executive' => $policyData->executive->name,
                'insurance_company' => $policyData->insurance->name,
                'insured_by' => TermInsurance::getInsuredByName($policyData->insurance_done_by),
                'coverage_detail' => $policyData->coverage_detail,
                'coverage_upto' => $policyData->coverage_upto,
                'premium_payment_period' => $policyData->premium_payment_period,
                'insurance_type' => TermInsurance::getInsuredTypeName($policyData->insurance_type),
            ];
        } else {
            return response()->json([
                'error' => 'No policydData found for the given status',
            ], 404);
        }
    }
    
}
