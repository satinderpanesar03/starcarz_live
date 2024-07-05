<?php

namespace App\Http\Controllers\admin\insurance;

use App\Http\Controllers\Controller;
use App\Models\CarInsurance;
use App\Models\MotorInsuranceClaim;
use App\Models\MstExecutive;
use App\Models\MstInsurance;
use App\Models\MstModel;
use App\Models\MstParty;
use App\Models\MstSupplier;
use App\Models\Purchase;
use App\Models\Refurbishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MotorInsuranceClaimController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.claim.insurance.index');
        } else {
            $insurances = MotorInsuranceClaim::with('party:id,party_name')
                ->when($request->filled('party_name'), function ($query) use ($request) {
                    $query->whereHas('party', function ($subquery) use ($request) {
                        $subquery->where('party_name', 'like', '%' . $request->party_name . '%');
                    });
                })
                ->PolicyNumber($request)
                ->CarNumber($request)
                ->orderBy('id', 'desc')
                ->paginate($request->limit ? $request->limit : 10);
        }
        return view('admin.motor-insurance-claim.index', compact('insurances'));
    }


    public function create()
    {
        $executives = MstExecutive::pluck('name', 'id');
        $models = MstModel::pluck('model', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        $headOptions = Refurbishment::getHeadOption();
        $paymentmodes = Refurbishment::getPaymentOption();
        $parties = MstParty::select('id', 'party_name')->get();
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        $insurance_company = MstInsurance::pluck('name', 'id');
        $case = 'add';
        $status = MotorInsuranceClaim::getStatus();
        $policyNumbers = CarInsurance::pluck('policy_number', 'id');

        return view('admin.motor-insurance-claim.create', compact('executives', 'models', 'suppliers', 'regNumbers', 'headOptions', 'paymentmodes', 'parties', 'vehicles', 'insurance_company', 'case', 'status', 'policyNumbers'));
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
                $refurbishment = MotorInsuranceClaim::find($request->id);
                $refurbishment->update($input);
            } else {
                MotorInsuranceClaim::create($input);
            }

            DB::commit();

            \toastr()->success(ucfirst('Motor insurance claim saved successfully'));
            return redirect()->route('admin.claim.insurance.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving motor insurance claim');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $insurance = MotorInsuranceClaim::find($id);
        $executives = MstExecutive::pluck('name', 'id');
        $models = MstModel::pluck('model', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        $headOptions = Refurbishment::getHeadOption();
        $paymentmodes = Refurbishment::getPaymentOption();
        $parties = MstParty::select('id', 'party_name')->get();
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        $insurance_company = MstInsurance::pluck('name', 'id');
        $case = 'edit';
        $status = MotorInsuranceClaim::getStatus();
        $policyNumbers = CarInsurance::pluck('policy_number', 'id');

        return view('admin.motor-insurance-claim.create', compact('insurance', 'executives', 'models', 'suppliers', 'regNumbers', 'headOptions', 'paymentmodes', 'parties', 'vehicles', 'insurance_company', 'case', 'status','policyNumbers'));
    }

    public function view($id)
    {
        $insurance = MotorInsuranceClaim::find($id);
        $executives = MstExecutive::pluck('name', 'id');
        $models = MstModel::pluck('model', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        $headOptions = Refurbishment::getHeadOption();
        $paymentmodes = Refurbishment::getPaymentOption();
        $parties = MstParty::select('id', 'party_name')->get();
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        $insurance_company = MstInsurance::pluck('name', 'id');
        $case = 'edit';
        $status = MotorInsuranceClaim::getStatus();
        $policyNumbers = CarInsurance::pluck('policy_number', 'id');

        return view('admin.motor-insurance-claim.view', compact('insurance', 'executives', 'models', 'suppliers', 'regNumbers', 'headOptions', 'paymentmodes', 'parties', 'vehicles', 'insurance_company', 'case', 'status','policyNumbers'));
    }

    public function statusChange($id, $state_id)
    {
        $insurance = MotorInsuranceClaim::find($id);
        $updateStatus = ($state_id == 1) ? 0 : 1;
        $message = ($state_id == 0) ? 'Insurance Claim activated successfully' : 'Insurance Claim deactivated successfully';

        $insurance->update(['state_id' => $updateStatus]);

        \toastr()->success(ucfirst($message));
        return redirect()->back();
    }

    public function getPolicyData(Request $request)
    {
        $policy = $request->input('policy');

        $policyData = CarInsurance::with('party','executive','insurance')->where('id', $policy)->first();
        if ($policyData) {
            return [
                'purchase_id' => $policyData->id,
                'party_id' => $policyData->party_id,
                'brand' => $policyData->brand ?? '',
                'model' => $policyData->color ?? '',
                // 'color' => $policyData->color ?? '',
                'manufacturing_year' => $policyData->manufacturing_year,
                'registration_year' => $policyData->manufacturing_year,
                'kilometer' => $policyData->kilometer,
                'expectation' => $policyData->expectation,
                'owners' => $policyData->owners,
                'fuel_type' => ($policyData->fuel_type == 1) ? 'Petrol' : 'Diesel',
                'shape_type' => ($policyData->shape_type == 1) ? 'New' : 'Old',
                'engine_number' => $policyData->engine_number,
                'chassis_number' => $policyData->chassis_number,
                'service_booklet' => $policyData->service_booklet,
                'date_of_purchase' => $policyData->date_of_purchase,
                'reg_date' => $policyData->reg_date,
                'insurance_company' => $policyData->insurance_company,
                'policy_number' => $policyData->policy_number,
                'vehicle_number' => $policyData->vehicle_number,
                'insurance_done_date' => $policyData->insurance_done_date,
                'insurance_from_date' => $policyData->insurance_from_date,
                'insurance_to_date' => $policyData->insurance_to_date,
                'vehicle_type' => $policyData->vehicle_type,
                'od_type_insurance' => $policyData->od_type_insurance,
                'premium' => $policyData->premium,
                'gst' => $policyData->gst,
                'sum_insured' => $policyData->sum_insured,
                'coverage_detail' => $policyData->coverage_detail,
                'vehicle_number_input' => $policyData->vehicle_number_input,
                'mst_party_id' => $policyData->party->party_name,
                'registered_owner' => $policyData->party->party_name,
                'email' => $policyData->party->email,
                'office_city' => $policyData->party->office_city,
                'office_number' => $policyData->party->office_number,
                'office_address' => $policyData->party->office_address,
                'executive' => ($policyData->executive) ? $policyData->executive->name :'',
                'insurance_company' => $policyData->insurance->name,
                'insured_by' => CarInsurance::getInsuredByName($policyData->vehicle_number),
                'vehicle_type' => CarInsurance::getVehicleType($policyData->vehicle_type),
                'od_type' => CarInsurance::getOdType($policyData->od_type_insurance),
            ];
        } else {
            return response()->json([
                'error' => 'No policydData found for the given status',
            ], 404);
        }
    }
}
