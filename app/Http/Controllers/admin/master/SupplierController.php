<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\Controller;
use App\Models\MstSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    public function index(Request $request){
        $suppliers = MstSupplier::paginate($request->limit ? $request->limit : 10);
        return view('admin.master.supplier.index')->with([
            'suppliers' => $suppliers
        ]);
    }

    public function create(){
        return view('admin.master.supplier.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'supplier' => [
                'required',
                'string',
                Rule::unique('mst_suppliers')->ignore($request->id),
            ],
        ]);
        if($validator->fails()){
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if($request->id){
                $type = MstSupplier::find($request->id);
                $type->update(['supplier' => $request->supplier]);
            } else {
                MstSupplier::create($request->except('_token'));
            }

            DB::commit();

            \toastr()->success(ucfirst('supplier successfully saved'));
            return redirect()->route('admin.master.supplier.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving color');
            return redirect()->back();
        }

    }

    public function show($id){
        $supplier = MstSupplier::find($id);
        return view('admin.master.supplier.create', compact('supplier'));
    }

    public function view($id){
        $supplier = MstSupplier::find($id);
        return view('admin.master.supplier.view', compact('supplier'));
    }

    public function delete($id){
        $color = MstSupplier::find($id);
        $color->delete();

        \toastr()->success(ucfirst('supplier successfully deleted'));
        return redirect()->back();
    }
}
