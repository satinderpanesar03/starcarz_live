<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\Controller;
use App\Models\MstInsurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class InsuranceController extends Controller
{
    public function index(Request $request){
        $insurances = MstInsurance::paginate($request->limit ? $request->limit : 10);
        return view('admin.master.insurance.index')->with([
            'insurances' => $insurances
        ]);
    }

    public function create(){
        return view('admin.master.insurance.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
        ]);
        if($validator->fails()){
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if($request->id){
                $insurance = MstInsurance::find($request->id);
                $insurance->update($request->except('_token'));
            } else {
                MstInsurance::create($request->except('_token'));
            }

            DB::commit();

            \toastr()->success(ucfirst('insurance successfully saved'));
            return redirect()->route('admin.master.insurance.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving insurance');
            return redirect()->back();
        }

    }

    public function show($id){
        $insurance = MstInsurance::find($id);
        return view('admin.master.insurance.create', compact('insurance'));
    }

    public function delete($id){
        $color = MstInsurance::find($id);
        $color->delete();

        \toastr()->success(ucfirst('insurance successfully deleted'));
        return redirect()->back();
    }
}
