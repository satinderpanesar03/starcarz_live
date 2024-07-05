<?php

namespace App\Http\Controllers\admin\insurance;

use App\Http\Controllers\Controller;
use App\Models\CarInsurance;
use App\Models\GeneralInsurance;
use App\Models\GeneralInsuranceClaim;
use App\Models\MstExecutive;
use App\Models\MstInsurance;
use App\Models\MstInsuranceType;
use App\Models\MstParty;
use App\Models\MstSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GeneralInsuranceClaimController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.claim.general-insurance.index');
        } else {
            $insurances = GeneralInsuranceClaim::with('party:id,party_name')
                ->when($request->filled('party_name'), function ($query) use ($request) {
                    $query->whereHas('party', function ($subquery) use ($request) {
                        $subquery->where('party_name', 'like', '%' . $request->party_name . '%');
                    });
                })
                ->PolicyNumber($request)
                ->orderBy('id', 'desc')
                ->paginate($request->limit ? $request->limit : 10);
        }
        return view('admin.general-insurance-claim.index', compact('insurances'));
    }

    public function create()
    {
        $executives = MstExecutive::pluck('name', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        $parties = MstParty::select('id', 'party_name')->get();
        $insurance_company = MstInsurance::pluck('name', 'id');
        $case = 'add';
        $insurance_types = MstInsuranceType::pluck('name', 'id');
        $policyNumbers = GeneralInsurance::pluck('policy_number', 'id');
        $status = GeneralInsuranceClaim::getStatus();

        return view('admin.general-insurance-claim.create', compact('executives', 'parties', 'insurance_company', 'case', 'insurance_types', 'policyNumbers', 'status'));
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
                $refurbishment = GeneralInsuranceClaim::find($request->id);
                $refurbishment->update($input);
            } else {
                GeneralInsuranceClaim::create($input);
            }

            DB::commit();

            \toastr()->success(ucfirst('General insurance claim saved successfully'));
            return redirect()->route('admin.claim.general-insurance.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving general insurance claim');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $insurance = GeneralInsuranceClaim::find($id);
        $executives = MstExecutive::pluck('name', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        $parties = MstParty::select('id', 'party_name')->get();
        $insurance_company = MstInsurance::pluck('name', 'id');
        $insurance_types = MstInsuranceType::pluck('name', 'id');
        $case = 'edit';
        $policyNumbers = GeneralInsurance::pluck('policy_number', 'id');
        $status = GeneralInsuranceClaim::getStatus();

        return view('admin.general-insurance-claim.create', compact('insurance', 'executives', 'parties',  'insurance_company', 'case', 'insurance_types', 'policyNumbers', 'status'));
    }

    public function view($id)
    {
        $insurance = GeneralInsuranceClaim::find($id);
        $executives = MstExecutive::pluck('name', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        $parties = MstParty::select('id', 'party_name')->get();
        $insurance_company = MstInsurance::pluck('name', 'id');
        $case = 'edit';
        $insurance_types = MstInsuranceType::pluck('name', 'id');
        $policyNumbers = GeneralInsurance::pluck('policy_number', 'id');
        $status = GeneralInsuranceClaim::getStatus();

        return view('admin.general-insurance-claim.view', compact('insurance', 'executives', 'parties', 'insurance_company', 'case', 'insurance_types', 'policyNumbers', 'status'));
    }

    public function getPolicyData(Request $request)
    {
        $policy = $request->input('policy');

        $policyData = GeneralInsurance::with('party', 'executive', 'insurance', 'insuranceType', 'partyContact', 'partyCity')->where('id', $policy)->first();
       
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
                'vehicle_number' => $policyData->vehicle_number,
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
                'insured_by' => GeneralInsurance::getInsuredByName(1),
                'coverage_detail' => $policyData->coverage_detail,
                'building' => $policyData->building,
                'plant_machinery' => $policyData->plant_machinery,
                'stock' => $policyData->stock,
                'electical' => $policyData->electical,
                'furniture' => $policyData->furniture,
                'other' => $policyData->other,
                'total_sum' => $policyData->total_sum,
                'insurance_type' => $policyData->insuranceType->name,
            ];
        } else {
            return response()->json([
                'error' => 'No policydData found for the given status',
            ], 404);
        }
    }
}
