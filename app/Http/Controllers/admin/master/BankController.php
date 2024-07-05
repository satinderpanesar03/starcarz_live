<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\Controller;
use App\Models\MstBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BankController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.master.bank.index');
        }
        $query = MstBank::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('address')) {
            $query->where('address', 'like', '%' . $request->input('address') . '%');
        }

        if ($request->has('city')) {
            $query->where('city', 'like', '%' . $request->input('city') . '%');
        }
        $query->orderBy('id', 'desc');

        $banks = $query->paginate($request->limit ? $request->limit : 10);

        return view('admin.master.bank.index')->with([
            'banks' => $banks
        ]);
    }

    public function create()
    {
        return view('admin.master.bank.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
        ]);
        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if ($request->id) {
                $color = MstBank::find($request->id);
                $color->update($request->except('_token'));
            } else {
                MstBank::create($request->except('_token'));
            }

            DB::commit();

            \toastr()->success(ucfirst('bank successfully saved'));
            return redirect()->route('admin.master.bank.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving bank');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $bank = MstBank::find($id);
        return view('admin.master.bank.create', compact('bank'));
    }


    public function delete($id)
    {
        $color = MstBank::find($id);
        $color->delete();

        \toastr()->success(ucfirst('bank successfully deleted'));
        return redirect()->back();
    }

    public function view($id)
    {
        $bank = MstBank::find($id);
        return view('admin.master.bank.view', compact('bank'));
    }
}
