<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\Controller;
use App\Models\InsuranceCovered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CoveredInsurance extends Controller
{
    public function index(Request $request){
        $insurance = InsuranceCovered::paginate($request->limit ? $request->limit : 10);
        return view('admin.master.coveredinsruance.index')->with([
            'insurance' => $insurance
        ]);
    }

    public function create(){
        return view('admin.master.coveredinsruance.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);
        if($validator->fails()){
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if($request->id){
                $type = InsuranceCovered::find($request->id);
                $type->update($request->except('_token'));
            } else {
                InsuranceCovered::create($request->except('_token'));
            }

            DB::commit();

            \toastr()->success(ucfirst('successfully saved'));
            return redirect()->route('admin.master.coveredinsurance.index');
        }
         catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving dealer');
            return redirect()->back();
        }
    }

    public function show($id){
        $insurance = InsuranceCovered::find($id);
        return view('admin.master.coveredinsruance.create', compact('insurance'));
    }

    public function delete($id){
        $insurance = InsuranceCovered::find($id);
        $insurance->delete();

        \toastr()->success(ucfirst('successfully deleted'));
        return redirect()->back();
    }
}
