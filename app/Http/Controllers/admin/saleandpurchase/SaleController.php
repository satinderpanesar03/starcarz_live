<?php

namespace App\Http\Controllers\admin\saleandpurchase;

use App\Exports\SaleEnquiryExport;
use App\Http\Controllers\Controller;
use App\Models\MstExecutive;
use App\Models\MstModel;
use App\Models\MstParty;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\MstColor;
use App\Models\SaleDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $type = true;
        if ($request->has('clear_search')) {
            return redirect()->route('admin.sale.sale.index');
        }
        $sales = SaleDetail::with('purchase', 'party','party.partyContact','executive')
            ->when($request->filled('party_id'), function ($query) use ($request) {
                $query->whereHas('party', function ($subquery) use ($request) {
                    $subquery->where('party_name', 'like', '%' . $request->party_id . '%');
                });
            })
            ->when($request->filled('car_number'), function ($query) use ($request) {
                $query->whereHas('purchase', function ($subquery) use ($request) {
                    $subquery->where('reg_number', 'like', '%' . $request->car_number . '%');
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->orderByDesc('id')
            ->paginate($request->limit ? $request->limit : 10);
        $parties = MstParty::select('id', 'party_name')->get();
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        $status = SaleDetail::getStatus();
// return $sales;
        return view('admin.sale-purchase.sale.index', compact('sales', 'parties', 'vehicles', 'status', 'type'));
    }

    public function followUp(Request $request)
    {
        $type = false;
        $sales = SaleDetail::with('purchase', 'party')
            ->whereIn('status', [3, 4, 5])
            ->when($request->filled('party_id'), function ($query) use ($request) {
                $query->whereHas('party', function ($subquery) use ($request) {
                    $subquery->where('party_name', 'like', '%' . $request->party_id . '%');
                });
            })
            ->when($request->filled('car_number'), function ($query) use ($request) {
                $query->whereHas('purchase', function ($subquery) use ($request) {
                    $subquery->where('reg_number', 'like', '%' . $request->car_number . '%');
                });
            })
            ->orderByDesc('id')
            ->paginate($request->limit ? $request->limit : 10);
        $parties = MstParty::select('id', 'party_name')->get();
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        $status = SaleDetail::getStatus();
        return view('admin.sale-purchase.sale.index', compact('sales', 'parties', 'vehicles', 'status', 'type'));
    }

    public function index_old(Request $request)
    {
        $sales = SaleDetail::paginate($request->limit ? $request->limit : 10);
        $executives = MstExecutive::pluck('name', 'id');
        $models = MstModel::pluck('model', 'id');
        return view('admin.sale-purchase.sale.index', compact('sales', 'executives', 'models'));
    }

    public function create()
    {
        $type = true;
        $parties = MstParty::select('id', 'party_name')->get();
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        // $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        $modelIds = Purchase::select('id', 'mst_model_id')
                    ->whereIn('status', [6, 7])
                    ->whereNotNull('mst_model_id')
                    ->pluck('mst_model_id')
                    ->toArray();
        $status = SaleDetail::getStatus();
        $carList = DB::table('car_lists')->select('model')->get();
        $executives = MstExecutive::pluck('name', 'id');
        $models = MstModel::pluck('model', 'id');
        $budget = Sale::getBudget();
        $fuelType = Sale::getFuelType();
        $finance = Sale::getFinanceType();
        $enquiryType = Sale::getEnquiryType();
        $colors = MstColor::pluck('id','color');
        $suggestedVehicle = MstModel::whereIn('id', $modelIds)->pluck('model', 'id');
        if ($suggestedVehicle->isEmpty()) {
            $suggestedVehicle = [];
        }
// dd($suggestedVehicle);
        return view('admin.sale-purchase.sale.create', compact('parties', 'regNumbers', 'status', 'type', 'carList', 'executives', 'models', 'budget', 'fuelType', 'finance', 'enquiryType','colors','suggestedVehicle'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'firm_name' => 'required',
            'contact_number' => 'required',
            'address' => 'required',
            'city' => 'required',
            'mst_executive_id' => 'required',
            'vehicle_id' => 'required',
            'color' => 'required',
            'fuel_type' => 'required',
            'budget_type' => 'required',
        ], [
            'vehicle_id' => 'Please select vehcile',
            'mst_executive_id' => 'PLease select executive',
            'budget_type' => 'Please select budget'
        ]);

        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            if ($request->id) {
                $sale = SaleDetail::find($request->id);
                $sale->update([
                    'mst_party_id' => $request->party_id,
                    'vehicle_id' => implode(',',$request->vehicle_id),
                    'suggestion_vehicle_id' => implode(',',$request->suggestion_vehicle_id),
                    'status' => $request->status,
                    'followup_date' => ($request->status == 2 || $request->status == 1) ? null : $request->followup_date,
                    'remarks' => $request->remarks,
                    'follow_remarks' => $request->follow_remarks,
                    'firm_name' => $request->firm_name,
                    'person_name' => $request->person_name,
                    'contact_number' => $request->contact_number,
                    'address' => $request->address,
                    'city' => $request->city,
                    'email' => $request->email,
                    'finance_requirement' => $request->finance_requirement,
                    'enquiry_type' => $request->enquiry_type,
                    'expected_price' => $request->expected_price ,
                    'mst_executive_id' => $request->mst_executive_id,
                    'budget_type' => $request->budget_type ?? '',
                    'brand' => $request->brand,
                    'color' => implode(',',$request->color),
                    'model' => $request->model,
                    'date_of_purchase' => $request->date_of_purchase,
                    'fuel_type' => implode(',',$request->fuel_type),
                ]);

                if ($sale->status == 5) {
                    return redirect()->route('admin.sale.sale.order-create', ["s" => Crypt::encrypt($sale->id), "p" => Crypt::encrypt($sale->mst_party_id), 'e' => Crypt::encrypt($sale->mst_executive_id)]);
                }
            } else {
                SaleDetail::create([
                    'mst_party_id' => $request->party_id,
                    'vehicle_id' => implode(',',$request->vehicle_id),
                    'suggestion_vehicle_id' => implode(',',$request->suggestion_vehicle_id),
                    'status' => $request->status,
                    'followup_date' => $request->status == 'Follow Up' ? $request->followup_date : null,
                    'remarks' => $request->remarks,
                    'follow_remarks' => $request->follow_remarks,
                    'firm_name' => $request->firm_name,
                    'person_name' => $request->person_name,
                    'contact_number' => $request->contact_number,
                    'address' => $request->address,
                    'city' => $request->city,
                    'email' => $request->email,
                    'finance_requirement' => $request->finance_requirement,
                    'enquiry_type' => $request->enquiry_type,
                    'status' => ($request->status) ? $request->status : 1,
                    'mst_executive_id' => $request->mst_executive_id,
                    'budget_type' => $request->budget_type ?? '',
                    'expected_price' => $request->expected_price ,
                    'brand' => $request->brand,
                    'color' => implode(',',$request->color),
                    'model' => $request->model,
                    'fuel_type' => implode(',',$request->fuel_type),
                ]);
            }

            DB::commit();

            \toastr()->success(ucfirst('Sale enquiry successfully saved'));
            return redirect()->route('admin.sale.sale.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving Sale' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function store_old(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'enquiry_date' => 'required',
            'firm_name' => 'required',
            'person_name' => 'required',
            'contact_number' => 'required',
            'email' => 'required|email',
            'mst_model_id' => 'required',
            'budget_type' => 'required',
            'address' => 'required',
            'city' => 'required',
            'fuel_type' => 'required',
            'finance_requirement' => 'required',
            'enquiry_type' => 'required',
            'remarks' => 'required',
            'followup_date' => 'required'
        ]);
        $input = $request->all();

        $input['enquiry_date'] = $this->datetoTimeConversion($request->enquiry_date);
        $input['followup_date '] = ($request->status == 2 || $request->status == 1) ? null : $request->followup_date;
        $input['next_follow_date '] = ($request->next_follow_date) ? $this->datetoTimeConversion($request->next_follow_date) : null;

        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if ($request->id) {
                $insurance = Sale::find($request->id);
                $insurance->update($input);
            } else {
                Sale::create($input);
            }

            DB::commit();

            \toastr()->success(ucfirst('Sale enquiry successfully saved'));
            return redirect()->route('admin.sale.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving Sale' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function datetoTimeConversion($date)
    {
        $dateTime = Carbon::createFromFormat('Y-m-d', $date)
            ->now();
        return $dateTime;
    }


    public function show($id)
    {
        $type = false;
        $sale = SaleDetail::find($id);
        $parties = MstParty::select('id', 'party_name')->get();
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        // $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        $modelIds = Purchase::select('id', 'mst_model_id')
                    ->whereIn('status', [6, 7])
                    ->whereNotNull('mst_model_id')
                    ->pluck('mst_model_id')
                    ->toArray();
        $status = SaleDetail::getStatus($sale->status);
        $carList = DB::table('car_lists')->select('model')->get();
        $budget = Sale::getBudget();
        $fuelType = Sale::getFuelType();
        $finance = Sale::getFinanceType();
        $enquiryType = Sale::getEnquiryType();
        $executives = MstExecutive::pluck('name', 'id');
        $models = MstModel::pluck('model', 'id');
        $colors = MstColor::pluck('id','color');
        $suggestedVehicle = MstModel::whereIn('id', $modelIds)->pluck('model', 'id');
        if ($suggestedVehicle->isEmpty()) {
            $suggestedVehicle = [];
        }

        return view('admin.sale-purchase.sale.create', compact('sale', 'parties', 'regNumbers', 'status', 'type', 'carList', 'budget', 'finance', 'enquiryType', 'executives', 'models','colors','suggestedVehicle'));
    }

    public function delete($id)
    {
        $color = SaleDetail::find($id);
        $color->delete();

        \toastr()->success(ucfirst('Sale enquiry successfully deleted'));
        return redirect()->back();
    }

    public function view($id)
    {
        $type = false;
        $sale = SaleDetail::find($id);
        $parties = MstParty::select('id', 'party_name')->get();
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        $status = SaleDetail::getStatus();
        $finance = Sale::getFinanceType();
        $enquiryType = Sale::getEnquiryType();
        $executives = MstExecutive::pluck('name', 'id');
        $models = MstModel::pluck('model', 'id');
        return view('admin.sale-purchase.sale.show', compact('sale', 'parties', 'vehicles', 'regNumbers', 'status', 'type', 'finance', 'enquiryType', 'executives', 'models'));
    }

    public function statusChange($id, $state_id)
    {
        $sale = SaleDetail::find($id);
        $updateStatus = ($state_id == 1) ? 0 : 1;
        $message = ($state_id == 0) ? 'Sale activated successfully' : 'Sale deactivated successfully';

        $sale->update(['state_id' => $updateStatus]);

        \toastr()->success(ucfirst($message));
        return redirect()->back();
    }

    public function export($extension = null)
    {
        if ($extension == 'xlsx') {
            $extension = "xlsx";
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        } elseif ($extension == 'csv') {
            $extension = "csv";
            $exportFormat = \Maatwebsite\Excel\Excel::CSV;
        } else {
            $extension = "xlsx";
            $exportFormat = \Maatwebsite\Excel\Excel::XLSX;
        }
        $filename = 'sale_enquiry-' . date('d-m-Y') . '.' . $extension;
        return Excel::download(new SaleEnquiryExport, $filename, $exportFormat);
    }
}
