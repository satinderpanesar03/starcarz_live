<?php

namespace App\Http\Controllers\admin\insurance;

use App\Http\Controllers\Controller;
use App\Models\HealthInsurance;
use App\Models\HealthInsuranceClaim;
use App\Models\MstParty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HealthInsuranceClaimController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.claim.health-insurance.index');
        } else {
            $insurances = HealthInsuranceClaim::with('party:id,party_name')
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
        return view('admin.health-insurance-claim.index', compact('insurances','parties'));
    }

    public function create()
    {
        $parties = MstParty::select('id', 'party_name')->get();
        $policyNumbers = HealthInsurance::pluck('policy_number', 'id');
        $status = HealthInsuranceClaim::getStatus();

        return view('admin.health-insurance-claim.create', compact('parties', 'policyNumbers', 'status'));
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
                $refurbishment = HealthInsuranceClaim::find($request->id);
                $refurbishment->update($input);
            } else {
                HealthInsuranceClaim::create($input);
            }

            DB::commit();

            \toastr()->success(ucfirst('Health insurance claim saved successfully'));
            return redirect()->route('admin.claim.health-insurance.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving health insurance claim');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $insurance = HealthInsuranceClaim::find($id);
        $parties = MstParty::select('id', 'party_name')->get();
        $policyNumbers = HealthInsurance::pluck('policy_number', 'id');
        $status = HealthInsuranceClaim::getStatus();

        return view('admin.health-insurance-claim.create', compact('insurance', 'parties', 'policyNumbers', 'status'));
    }

    public function view($id)
    {
        $insurance = HealthInsuranceClaim::find($id);
        $parties = MstParty::select('id', 'party_name')->get();
        $policyNumbers = HealthInsurance::pluck('policy_number', 'id');
        $status = HealthInsuranceClaim::getStatus();

        return view('admin.health-insurance-claim.view', compact('insurance', 'parties', 'policyNumbers', 'status'));
    }

    public function getPolicyData(Request $request)
    {
        $policy = $request->input('policy');

        $policyData = HealthInsurance::with('party', 'partyContact', 'partyCity')->where('id', $policy)->first();

        $firstPartyCity = $policyData->partyCity->first();
        $partyContacts = $policyData->partyContact;
        $partyContact = $partyContacts->first(function ($partyContact) {
            return $partyContact->type == 2;
        });
        if ($policyData) {
            return [
                'purchase_id' => $policyData->id,
                'party_id' => $policyData->party_id,
                'policy_number' => $policyData->policy_number,
                'mst_party_id' => $policyData->party->party_name,
                'registered_owner' => $policyData->party->party_name,
                'email' => $policyData->party->email,
                'office_city' => ($policyData->party->office_city) ? $policyData->party->office_city : (($firstPartyCity->city) ? $firstPartyCity->city : ''),
                'office_number' => ($policyData->party->office_number) ? $policyData->party->office_number : (($partyContact->number) ? $partyContact->number : ''),
                'office_address' => $policyData->party->office_address,
                'sum_assured' => $policyData->sum_assured,
                'member_names' => $policyData->memberName()->pluck('member_name')->toArray(),
                'end_date' => $policyData->end_date,
                'hospital_name' => $policyData->hospital_name,
                'claim_amount' => $policyData->claim_amount,
                'start_date' => $policyData->start_date,
                'premium' => $policyData->premium,
                'gst' => $policyData->gst,
                'gross_premium' => $policyData->gross_premium,
                'status' => HealthInsurance::getStatusName($policyData->status),
            ];
        } else {
            return response()->json([
                'error' => 'No policydData found for the given status',
            ], 404);
        }
    }
}
