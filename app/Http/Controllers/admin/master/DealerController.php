<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\Controller;
use App\Models\MstDealer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DealerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.master.dealer.index');
        }
        $query = MstDealer::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('phone')) {
            $query->where('phone', 'like', '%' . $request->input('phone') . '%');
        }

        if ($request->has('city')) {
            $query->where('city', 'like', '%' . $request->input('city') . '%');
        }
        $query->orderBy('id', 'desc');
        $dealers = $query->paginate($request->limit ? $request->limit : 10);
        return view('admin.master.dealer.index')->with([
            'dealers' => $dealers
        ]);
    }

    public function create()
    {
        return view('admin.master.dealer.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'phone' => 'required|integer',
        ]);


        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if ($request->id) {
                $type = MstDealer::find($request->id);
                $type->update($request->except('_token'));
            } else {
                $requestData = $request->except('_token');
                $requestData['status'] = 1;
                MstDealer::create($requestData);
            }

            DB::commit();

            \toastr()->success(ucfirst('dealer successfully saved'));
            return redirect()->route('admin.master.dealer.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving dealer');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $dealer = MstDealer::find($id);
        return view('admin.master.dealer.create', compact('dealer'));
    }

    public function view($id)
    {
        $dealer = MstDealer::find($id);
        return view('admin.master.dealer.view', compact('dealer'));
    }

    public function delete($id)
    {
        $dealer = MstDealer::find($id);
        $dealer->delete();

        \toastr()->success(ucfirst('Dealer successfully deleted'));
        return redirect()->back();
    }

    public function statusChange($id, $status)
    {
        $dealer = MstDealer::find($id);
        $updateStatus = ($status == 1) ? 0 : 1;
        $message = ($status == 0) ? 'Dealer activated successfully' : 'Dealer deactivated successfully';

        $dealer->update(['status' => $updateStatus]);

        \toastr()->success(ucfirst($message));
        return redirect()->back();
    }
}
