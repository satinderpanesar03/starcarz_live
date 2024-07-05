<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\Controller;
use App\Models\MstBrandType;
use App\Models\MstColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BrandTypeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.master.brand-type.index');
        }

        $query = MstBrandType::query();
        if ($request->has('type')) {
            $query->where('type', 'like', '%' . $request->input('type') . '%');
        }
        $query->orderBy('id', 'desc');
        $types =  $query->paginate($request->limit ? $request->limit : 10);
        return view('admin.master.brand.type.index')->with([
            'types' => $types
        ]);
    }

    public function create()
    {
        return view('admin.master.brand.type.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => [
                'required',
                'string',
                Rule::unique('mst_brand_types')->ignore($request->id),
            ],
        ]);
        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if ($request->id) {
                $type = MstBrandType::find($request->id);
                $type->update(['type' => $request->type]);
            } else {
                MstBrandType::create($request->except('_token'));
            }

            DB::commit();

            \toastr()->success(ucfirst('Type successfully saved'));
            return redirect()->route('admin.master.brand-type.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving color');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $type = MstBrandType::find($id);
        return view('admin.master.brand.type.create', compact('type'));
    }

    public function delete($id)
    {
        $color = MstBrandType::find($id);
        $color->delete();

        \toastr()->success(ucfirst('type successfully deleted'));
        return redirect()->back();
    }

    public function view($id)
    {
        $type = MstBrandType::find($id);
        return view('admin.master.brand.type.view', compact('type'));
    }
}
