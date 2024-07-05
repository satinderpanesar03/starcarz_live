<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\Controller;
use App\Models\MstBroker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BrokerController extends Controller
{
    public function index(Request $request){
        $brokers = MstBroker::paginate($request->limit ? $request->limit : 10);
        return view('admin.master.broker.index')->with([
            'brokers' => $brokers
        ]);
    }

    public function create(){
        return view('admin.master.broker.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                Rule::unique('mst_brokers')->ignore($request->id),
            ],
        ]);
        if($validator->fails()){
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if($request->id){
                $type = MstBroker::find($request->id);
                $type->update(['name' => $request->name]);
            } else {
                MstBroker::create($request->except('_token'));
            }

            DB::commit();

            \toastr()->success(ucfirst('broker successfully saved'));
            return redirect()->route('admin.master.broker.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving broker');
            return redirect()->back();
        }

    }

    public function show($id){
        $broker = MstBroker::find($id);
        return view('admin.master.broker.create', compact('broker'));
    }

    public function delete($id){
        $broker = MstBroker::find($id);
        $broker->delete();

        \toastr()->success(ucfirst('broker successfully deleted'));
        return redirect()->back();
    }
}
