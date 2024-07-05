<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\Controller;
use App\Models\MstInsuranceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InsuranceTypeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.master.insurance-type.index');
        }

        $query = MstInsuranceType::query();
        if ($request->has('insurance_id')) {
            $query->where('insurance_id', $request->input('insurance_id'));
        }
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        $query->orderBy('id', 'desc');
        $insurances_type = $query->paginate($request->limit ? $request->limit : 10);
        $dropdownOptions = MstInsuranceType::getInsurance();
        return view('admin.master.insurance-type.index')->with([
            'insurances_type' => $insurances_type,
            'dropdownOptions' => $dropdownOptions
        ]);
    }

    public function create()
    {
        $dropdownOptions = MstInsuranceType::getInsurance();

        return view('admin.master.insurance-type.create', [
            'dropdownOptions' => $dropdownOptions
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'unique:mst_insurance_types,name,' . $request->id
            ],
            'insurance_id' => 'required'
        ]);
        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if ($request->id) {
                $insurance = MstInsuranceType::find($request->id);
                $insurance->update($request->except('_token'));
            } else {
                MstInsuranceType::create($request->except('_token'));
            }

            DB::commit();

            \toastr()->success(ucfirst('insurance successfully saved'));
            return redirect()->route('admin.master.insurance-type.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving insurance');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $insurance = MstInsuranceType::find($id);
        $dropdownOptions = MstInsuranceType::getInsurance();
        return view('admin.master.insurance-type.create', ['dropdownOptions' => $dropdownOptions], compact('insurance'));
    }

    public function delete($id)
    {
        $color = MstInsuranceType::find($id);
        $color->delete();

        \toastr()->success(ucfirst('insurance successfully deleted'));
        return redirect()->back();
    }

    public function statusChange($id, $status)
    {
        $insuranceType = MstInsuranceType::find($id);
        $updateStatus = ($status == 1) ? 0 : 1;
        $message = ($status == 0) ? 'Insurance Type activated successfully' : 'Insurance Type deactivated successfully';

        $insuranceType->update(['status' => $updateStatus]);

        \toastr()->success(ucfirst($message));
        return redirect()->back();
    }

    public function view($id)
    {
        $insurance = MstInsuranceType::find($id);
        $dropdownOptions = MstInsuranceType::getInsurance();
        return view('admin.master.insurance-type.view', ['dropdownOptions' => $dropdownOptions], compact('insurance'));
    }
}
