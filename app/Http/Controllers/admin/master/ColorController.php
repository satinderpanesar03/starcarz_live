<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\Controller;
use App\Models\MstColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ColorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.master.color.index');
        }
        $query = MstColor::query();

        if ($request->has('name')) {
            $query->where('color', 'like', '%' . $request->input('name') . '%');
        }

        $query->orderBy('id', 'desc');
        $colors = $query->paginate($request->limit ? $request->limit : 10);
        return view('admin.master.color.index')->with([
            'colors' => $colors
        ]);
    }

    public function create()
    {
        return view('admin.master.color.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'color' => [
                'required',
                'string',
                Rule::unique('mst_colors')->ignore($request->id),
            ],
        ]);
        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if ($request->id) {
                $color = MstColor::find($request->id);
                $color->update(['color' => $request->color]);
            } else {
                MstColor::create($request->except('_token'));
            }

            DB::commit();

            \toastr()->success(ucfirst('Color successfully saved'));
            return redirect()->route('admin.master.color.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving color');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $color = MstColor::find($id);
        return view('admin.master.color.create', compact('color'));
    }


    public function delete($id)
    {
        $color = MstColor::find($id);
        $color->delete();

        \toastr()->success(ucfirst('color successfully deleted'));
        return redirect()->back();
    }

    public function view($id)
    {
        $color = MstColor::find($id);
        return view('admin.master.color.view', compact('color'));
    }
}
