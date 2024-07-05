<?php

namespace App\Http\Controllers\insurance;

use App\Http\Controllers\Controller;
use App\Models\Insurance;
use App\Models\InsuranceCovered;
use App\Models\MstBroker;
use App\Models\MstExecutive;
use App\Models\MstInsurance;
use App\Models\MstInsuranceType;
use App\Models\MstParty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InsuranceController extends Controller
{
    public function index(Request $request, $type = false)
    {
        $executives = MstExecutive::pluck('name', 'id');
        $insurances = $type ? Insurance::where('insurance_id', 3)->paginate($request->limit ? $request->limit : 10) : Insurance::whereNotIn('insurance_id', [3])->paginate($request->limit ? $request->limit : 10);
        return view('admin.insurance.index')->with([
            'insurances' => $insurances,
            'type' => $type,
            'executives' => $executives,
        ]);
    }

    public function create($type = false)
    {
        $insuranceTypes = MstInsuranceType::pluck('name', 'id');
        $company = MstInsurance::pluck('name', 'id');
        $excutives = MstExecutive::pluck('name', 'id');
        $broker = MstBroker::pluck('name', 'id');
        $dropdownOptions = Insurance::getInsuranceTypes($type);
        $insureddropdownOptions = Insurance::getInsuredBy();
        return view('admin.insurance.create', [
            'dropdownOptions' => $dropdownOptions,
            'insureddropdownOptions' => $insureddropdownOptions,
            'insuranceTypes' => $insuranceTypes,
            'excutives' => $excutives,
            'company' => $company,
            'broker' => $broker,
            'type' => $type
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firm_name' => 'required',
            'person_name' => 'required',
            'pan_number' => 'required',
            'whatsapp_number' => 'required|min:10',
            'office_address' => 'required',
            'office_city' => 'required',
            'office_number' => 'required|min:10',
            'residence_address' => 'required',
            'residence_city' => 'required',
            'residence_number' => 'required|min:10',
            'email' => 'required|email',
            'designation' => 'required',
            'pan_number' => 'required',
            'executive_id' => 'required',
            'insurance_id' => 'required',
            'insurance_type_id' => 'required',
            'insurance_date' => 'required',
            'insurance_from_date' => 'required',
            'insurance_to_date' => 'required',
            'company_id' => 'required',
            'premium' => 'required',
            'gst' => 'required',
            'total' => 'required',
            'sum_assured' => 'required',
            'insured_by' => 'required',
            'policy_number' => 'required',
            'broker_id' => 'required',
            'coverge_detail' => 'required'
        ]);
        $input = $request->all();

        $input['insurance_date'] = $this->datetoTimeConversion($request->insurance_date);
        $input['insurance_from_date '] = $this->datetoTimeConversion($request->insurance_from_date);
        $input['insurance_to_date'] = $this->datetoTimeConversion($request->insurance_to_date);
        $input['covered_insurance'] = implode(',', $request->covered_insurance);

        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if ($request->id) {
                $insurance = Insurance::find($request->id);
                $insurance->update($input);
            } else {
                Insurance::create($input);
            }

            DB::commit();

            \toastr()->success(ucfirst('insurance successfully saved'));
            if ($request->insurance_id == 3) {
                return redirect()->route('admin.insurance.general.index', true);
            } else {
                return redirect()->route('admin.insurance.index');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving insurance' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function datetoTimeConversion($date)
    {
        $dateTime = Carbon::createFromFormat('Y-m-d', $date)
            ->now();
        return $dateTime;
    }

    public function show(Request $request, $id)
    {
        $insurance = Insurance::find($id);
        $type = $request->query('type');
        $selectedExecutiveId = $insurance->executive_id;
        $insuranceTypeId = $insurance->insurance_type_id;
        $insuranceTypes = MstInsuranceType::pluck('name', 'id');
        $company = MstInsurance::pluck('name', 'id');
        $excutives = MstExecutive::pluck('name', 'id');
        $broker = MstBroker::pluck('name', 'id');
        $dropdownOptions = ($insurance->insurance_id == 3) ? Insurance::getInsuranceTypes(true) : Insurance::getInsuranceTypes(false);
        $insureddropdownOptions = Insurance::getInsuredBy();
        $coveredInsurance = InsuranceCovered::select('id', 'title')->get();
        return view('admin.insurance.create', [
            'dropdownOptions' => $dropdownOptions,
            'insureddropdownOptions' => $insureddropdownOptions,
            'insuranceTypes' => $insuranceTypes,
            'excutives' => $excutives,
            'company' => $company,
            'broker' => $broker,
            'type' => $type,
            'coveredInsurance' => $coveredInsurance
        ], compact('insurance', 'selectedExecutiveId', 'insuranceTypeId'));
    }

    public function delete($id)
    {
        $color = Insurance::find($id);
        $color->delete();

        \toastr()->success(ucfirst('insurance successfully deleted'));
        return redirect()->back();
    }

    public function getInsuranceSubTypes(Request $request)
    {
        $i_id = $request->input('insurance_type');

        $subtypes = DB::table('mst_insurance_types')->where('insurance_id', $i_id)->get();
        $html = '<option value="">Select Insurance Type</option>';
        foreach ($subtypes as $list) {
            $html .= '<option value="' . $list->id . '">' . $list->name . '</option>';
        }
        echo $html;
    }

    public function generalInsurance(Request $request, $type = True)
    {
        $executives = MstExecutive::pluck('name', 'id');
        $insurances = $type ? Insurance::where('insurance_id', 3)->paginate($request->limit ? $request->limit : 10) : Insurance::whereNotIn('insurance_id', [3])->paginate($request->limit ? $request->limit : 10);
        $parties = MstParty::select('id','party_name')->get();
        return view('admin.insurance.index')->with([
            'insurances' => $insurances,
            'type' => $type,
            'executives' => $executives,
            'parties' => $parties
        ]);
    }

    public function generalInsuranceCreate($type = True)
    {
        $insuranceTypes = MstInsuranceType::pluck('name', 'id');
        $company = MstInsurance::pluck('name', 'id');
        $excutives = MstExecutive::pluck('name', 'id');
        $broker = MstBroker::pluck('name', 'id');
        $dropdownOptions = Insurance::getInsuranceTypes($type);
        $insureddropdownOptions = Insurance::getInsuredBy();
        $coveredInsurance = InsuranceCovered::select('id', 'title')->get();
        return view('admin.insurance.create', [
            'dropdownOptions' => $dropdownOptions,
            'insureddropdownOptions' => $insureddropdownOptions,
            'insuranceTypes' => $insuranceTypes,
            'excutives' => $excutives,
            'company' => $company,
            'broker' => $broker,
            'type' => $type,
            'coveredInsurance' => $coveredInsurance
        ]);
    }
}
