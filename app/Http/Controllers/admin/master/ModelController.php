<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\Controller;
use App\Models\MstBrandType;
use App\Models\MstModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ModelController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.master.model.index');
        }

        $query = MstModel::with('brand:id,type');
        if ($request->has('brandFilter')) {
            $query->where('mst_brand_type_id', $request->input('brandFilter'));
        }
        if ($request->has('model')) {
            $query->where('model', 'like', '%' . $request->input('model') . '%');
        }
        $query->orderBy('id', 'desc');
        $models = $query->paginate($request->limit ? $request->limit : 10);
        $brands = MstBrandType::pluck('type', 'id');
        return view('admin.master.model.index')->with([
            'models' => $models,
            'brands' => $brands
        ]);
    }

    public function create()
    {
        $brands = MstBrandType::get();
        return view('admin.master.model.create')->with([
            'brands' => $brands
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'model' => [
                'required',
                'string',
                Rule::unique('mst_models')->ignore($request->id),
            ],
            'mst_brand_type_id' => [
                'required'
            ]
        ]);
        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if ($request->id) {
                $type = MstModel::find($request->id);
                $type->update([
                    'model' => $request->model,
                    'luxury' => $request->luxury,
                    'mst_brand_type_id' => $request->mst_brand_type_id
                ]);
            } else {
                MstModel::create($request->except('_token'));
            }

            DB::commit();

            \toastr()->success(ucfirst('model successfully saved'));
            return redirect()->route('admin.master.model.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving color');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $model = MstModel::find($id);
        $brands = MstBrandType::get();
        return view('admin.master.model.create', compact('model', 'brands'));
    }

    public function delete($id)
    {
        $color = MstModel::find($id);
        $color->delete();

        \toastr()->success(ucfirst('executive successfully deleted'));
        return redirect()->back();
    }

    public function view($id)
    {
        $model = MstModel::find($id);
        $brands = MstBrandType::get();
        return view('admin.master.model.view', compact('model', 'brands'));
    }

    public function getModels(Request $request)
    {
        $i_id = $request->input('brand_type');

        $subtypes = DB::table('mst_models')->where('mst_brand_type_id', $i_id)->get();
        $html = '<option value="">Choose...</option>';
        foreach ($subtypes as $list) {
            $selected = $list->id == $request->input('selected_subtype') ? 'selected' : '';
            $html .= '<option value="' . $list->id . '" ' . $selected . '>' . $list->model . '</option>';
        }
        echo $html;
    }
}
