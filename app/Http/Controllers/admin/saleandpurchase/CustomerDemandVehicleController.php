<?php

namespace App\Http\Controllers\admin\saleandpurchase;

use App\Http\Controllers\Controller;
use App\Models\CustomerDemandVehcile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CustomerDemandVehicleController extends Controller
{

    public function index(Request $request) {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.demand.vehicle.index');
        }else{
            $vehicles = CustomerDemandVehcile::with('party')
            ->when($request->filled('party_name'), function ($query) use ($request) {
                $query->whereHas('party', function ($subquery) use ($request) {
                    $subquery->where('party_name', 'like', '%' . $request->party_name . '%');
                });
            })
            ->paginate($request->limit ?: 10);
        }
        
        return view('admin.sale-purchase.sale.demand_vehicle', compact('vehicles'));
    }

    public function store(Request $request){
        
        $validator = Validator::make($request->all(), [
            'vehicle' => 'required|array',
            'budget' => 'required',
            'fuel_type' => 'required',
            'party_id' => 'required',
        ],[
            'party_id' => 'Please select party from the dropdown'
        ]);
        if($validator->fails()){
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if($request->id){
                // 
            } else {
                CustomerDemandVehcile::create([
                    'vehicle' => implode(',',$request->vehicle),
                    'budget' => $request->budget,
                    'fuel_type' => $request->fuel_type,
                    'party_id' => $request->party_id,
                ]);
            }

            DB::commit();

            \toastr()->success(ucfirst('Vehicle Demand successfully saved'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving color');
            return redirect()->back();
        }
    }

    public function edit($id){
        $vehicle = CustomerDemandVehcile::with('party')->find($id);
        return view('admin.sale-purchase.sale.edit_demand_vehicle', compact('vehicle'));
    }

    public function view($id){
        $vehicle = CustomerDemandVehcile::with('party')->find($id);
        return view('admin.sale-purchase.sale.view_demand_vehicle', compact('vehicle'));
    }

    public function update(Request $request){
        $customer = CustomerDemandVehcile::find($request->id);
        $customer->update([
            'vehicle' => implode(',',$request->vehicle),
            'budget' => $request->budget,
            'fuel_type' => $request->fuel_type,
        ]);

        \toastr()->success(ucfirst('Vehicle Demand successfully updated'));
        return redirect()->route('admin.demand.vehicle.index');

    }
}
