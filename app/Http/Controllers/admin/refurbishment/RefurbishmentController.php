<?php

namespace App\Http\Controllers\admin\refurbishment;

use App\Exports\RefurbishmentExport;
use App\Http\Controllers\Controller;
use App\Models\MstExecutive;
use App\Models\MstModel;
use App\Models\MstParty;
use App\Models\MstSupplier;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Models\Refurbishment;
use App\Models\RefurbnishmentOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class RefurbishmentController extends Controller
{
    public function index_old(Request $request)
    {
        $refurbishments = Refurbishment::paginate($request->limit ? $request->limit : 10);
        $executives = MstExecutive::pluck('name', 'id');
        $models = MstModel::pluck('model', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        return view('admin.refurbishment.index', compact('refurbishments', 'executives', 'models', 'suppliers'));
    }

    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.refurbishment.index');
        }
        $refurbishments = RefurbnishmentOrder::with('purchase', 'party')
            ->with('party', 'purchase')
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
            ->ModeSearch($request)
            ->paginate($request->limit ? $request->limit : 10);
        $parties = MstParty::select('id', 'party_name')->get();
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        $totalAmount = RefurbnishmentOrder::with('refurbished')
            ->get()
            ->sum(function ($order) {
                return $order->refurbished->sum('amount');
            });

        $parties = MstParty::select('id','party_name')->get();

        return view('admin.refurbishment.index', compact('refurbishments', 'parties', 'vehicles', 'totalAmount','parties'));
    }

    public function create()
    {
        $executives = MstExecutive::pluck('name', 'id');
        $models = MstModel::pluck('model', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        $headOptions = Refurbishment::getHeadOption();
        $paymentmodes = Refurbishment::getPaymentOption();
        $parties = MstParty::select('id', 'party_name')->get();
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();

        return view('admin.refurbishment.create', compact('executives', 'models', 'suppliers', 'regNumbers', 'headOptions', 'paymentmodes', 'parties', 'vehicles'));
    }

    public function store_old(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mst_executive_id' => 'required',
            'mst_model_id' => 'required',
            'mst_supplier_id' => 'required',
            'payment_mode' => 'required',
            'head' => 'required',
            'amount' => 'integer'
        ]);
        $input = $request->all();

        $input['voucher_date'] = $this->datetoTimeConversion($request->voucher_date);

        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if ($request->id) {
                $refurbishment = Refurbishment::find($request->id);
                $refurbishment->update($input);
            } else {
                Refurbishment::create($input);
            }

            DB::commit();

            \toastr()->success(ucfirst('Refurbishment saved successfully'));
            return redirect()->route('admin.refurbishment.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving refurbishment');
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            if ($request->ref_id) {
                $refurbishment = RefurbnishmentOrder::find($request->ref_id);
                $refurbishment->update($request->all());
            } else {
                $refurbishment = RefurbnishmentOrder::create($request->all());
            }

            if ($request->has('sections')) {
                foreach ($request->sections as $section) {
                    if (isset($section['id'])) {
                        $disbursed = Refurbishment::find($section['id']);
                        $disbursed->update($section);
                    } else {
                        $disbursed = new Refurbishment($section);
                        $refurbishment->refurbished()->save($disbursed);
                    }
                }
            }

            DB::commit();

            \toastr()->success(ucfirst('Refurbishment saved successfully'));
            return redirect()->route('admin.refurbishment.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving refurbishment');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $refurbishment = RefurbnishmentOrder::with('purchase')->find($id);
        $executives = MstExecutive::pluck('name', 'id');
        $models = MstModel::pluck('model', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        $regNumbers = Purchase::pluck('reg_number', 'id');
        $headOptions = Refurbishment::getHeadOption();
        $paymentmodes = Refurbishment::getPaymentOption();
        $parties = MstParty::select('id', 'party_name')->get();
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        $refurbishedDetails = $refurbishment->refurbished()->get();

        return view('admin.refurbishment.create', compact('refurbishment', 'executives', 'models', 'suppliers', 'regNumbers', 'headOptions', 'paymentmodes', 'parties', 'vehicles', 'refurbishedDetails'));
    }


    public function delete($id)
    {
        $color = Refurbishment::find($id);
        $color->delete();

        \toastr()->success(ucfirst('Refurbishment deleted successfully'));
        return redirect()->back();
    }

    public function datetoTimeConversion($date)
    {
        $dateTime = Carbon::createFromFormat('Y-m-d', $date)
            ->now();
        return $dateTime;
    }


    public function view($id)
    {
        $refurbishment = RefurbnishmentOrder::with('purchase', 'party')->find($id);
        $executives = MstExecutive::pluck('name', 'id');
        $models = MstModel::pluck('model', 'id');
        $suppliers = MstSupplier::pluck('supplier', 'id');
        $regNumbers = Purchase::pluck('reg_number', 'id');
        $headOptions = Refurbishment::getHeadOption();
        $paymentmodes = Refurbishment::getPaymentOption();
        $refurbishedDetails = $refurbishment->refurbished()->get();
        $parties = MstParty::select('id', 'party_name')->get();
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        return view('admin.refurbishment.view', compact('refurbishment', 'executives', 'models', 'suppliers', 'regNumbers', 'headOptions', 'paymentmodes', 'refurbishedDetails', 'parties', 'vehicles'));
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
        $filename = 'refurbishment-' . date('d-m-Y') . '.' . $extension;
        return Excel::download(new RefurbishmentExport, $filename, $exportFormat);
    }
}
