<?php

namespace App\Http\Controllers\admin\saleandpurchase;

use App\Http\Controllers\Controller;
use App\Models\MstParty;
use App\Models\Purchase;
use App\Models\TestDrive;
use Illuminate\Http\Request;

class TestDriveController extends Controller
{
    public function index(Request $request)
    {
        $type = true;
        $query = TestDrive::with('saleEnquiry', 'party');

        if ($request->has('clear_search')) {
            return redirect()->route('admin.test-drive.index');
        }

        $query->when($request->filled('partyFilter'), function ($query) use ($request) {
            $query->where('mst_party_id', $request->partyFilter);
        });

        $query->when($request->filled('car_number'), function ($query) use ($request) {
            $query->whereHas('saleEnquiry.purchase', function ($subquery) use ($request) {
                $subquery->where('reg_number', 'like', '%' . $request->car_number . '%');
            });
        });

        $testDrives = $query->orderByDesc('id')->paginate($request->limit ? $request->limit : 10);
        $parties = MstParty::pluck('party_name', 'id');
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();

        return view('admin.sale-purchase.test-drive.index', compact('testDrives', 'parties', 'vehicles', 'type'));
    }

    public function view($id)
    {
        $testDrive = TestDrive::with('saleEnquiry', 'party')->find($id);
        $parties = MstParty::select('id', 'party_name')->get();
        $vehicle_id = $testDrive->saleEnquiry->vehicle_id;
        $vehicle = Purchase::find($vehicle_id);
        $car_number = $vehicle->reg_number;
        return view('admin.sale-purchase.test-drive.view', compact('testDrive', 'parties', 'car_number'));
    }
}
