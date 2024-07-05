<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\Controller;
use App\Models\MstExecutive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ExecutiveController extends Controller
{

    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.master.executive.index');
        }
        $query = DB::table('mst_executives');

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        $query->orderBy('id', 'desc');
        $executives = $query->paginate($request->limit ? $request->limit : 10);
        return view('admin.master.executive.index')->with([
            'executives' => $executives
        ]);
    }

    public function create()
    {
        return view('admin.master.executive.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                Rule::unique('mst_executives')->ignore($request->id),
            ],
        ]);
        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if ($request->id) {
                DB::table('mst_executives')
                    ->where('id', $request->id)
                    ->update(['name' => $request->name]);
            } else {
                DB::table('mst_executives')->insert($request->except('_token'));
            }

            DB::commit();

            \toastr()->success(ucfirst('executive successfully saved'));
            return redirect()->route('admin.master.executive.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving executive');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $executive = DB::table('mst_executives')->find($id);
        return view('admin.master.executive.create', compact('executive'));
    }

    public function delete($id)
    {
        DB::table('mst_executives')->where('id', $id)->delete();


        \toastr()->success(ucfirst('executive successfully deleted'));
        return redirect()->back();
    }

    public function view($id)
    {
        $executive = DB::table('mst_executives')->find($id);
        return view('admin.master.executive.view', compact('executive'));
    }

    public function statusChange($id, $status)
    {
        DB::table('mst_executives')
            ->where('id', $id)
            ->update(['status' => $status ? 0 : 1]);

        \toastr()->success(ucfirst('executive status successfully changed'));
        return redirect()->back();
    }
}
