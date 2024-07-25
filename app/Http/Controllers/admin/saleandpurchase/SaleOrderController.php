<?php

namespace App\Http\Controllers\admin\saleandpurchase;

use App\Http\Controllers\Controller;
use App\Models\CarInsurance;
use App\Models\MstBrandType;
use App\Models\MstInsurance;
use App\Models\MstModel;
use App\Models\MstParty;
use App\Models\Purchase;
use App\Models\RcTransfer;
use App\Models\SaleOrder;
use App\Models\SaleDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class SaleOrderController extends Controller
{
    public function index(Request $request)
    {
        $type = true;
        if ($request->has('clear_search')) {
            return redirect()->route('admin.sale.sale.order-index');
        }
        $saleOrders = SaleOrder::with('purchase', 'party','executive')
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
        // $status = SaleDetail::getStatus();
        // dd($saleOrders);
        return view('admin.sale-purchase.sale-order.index', compact('saleOrders', 'parties', 'vehicles', 'type'));
    }

    public function create(Request $request)
    {
        $saleOrderId = Crypt::decrypt($request->query('s'));
        $executiveId = Crypt::decrypt($request->query('e'));
        $executive = DB::table('mst_executives')->select('id','name')->where('id', $executiveId)->first();
        $mstparty = MstParty::find(Crypt::decrypt($request->query('p')));
        $type = true;
        $rcType = Purchase::getRcType();
        $hypothecationType = Purchase::getHypothecationType();
        $parties = MstParty::with('partyContact')->get()->map(function ($party) {
            $contactNumbers = $party->partyContact->pluck('number')->implode(', ');
            return [
                'id' => $party->id,
                'name' => $party->party_name,
                'contacts' => $contactNumbers
            ];
        });
        $company = MstInsurance::pluck('name', 'id');
        $vehicles = Purchase::select('id', 'reg_number')
            ->whereIn('status', [6, 7])
            ->whereNotIn('id', function ($query) {
                $query->select('purchase_id')
                    ->from('sale_orders');
            })
            ->get();
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        $models = MstModel::pluck('model', 'id');
        $brands = MstBrandType::pluck('type', 'id');
        $policyNumbers = CarInsurance::pluck('policy_number', 'id');

        return view('admin.sale-purchase.sale-order.create', compact('parties', 'vehicles', 'regNumbers', 'company', 'rcType', 'type', 'hypothecationType', 'models', 'brands', 'policyNumbers','mstparty','saleOrderId','executive'));
    }

    public function store(Request $request)
    {
        $input = $request->all();
        if ($request->hasFile('buyer_id_image')) {
            if ($request->id) {
                $oldPurchase = SaleOrder::find($request->id);
                Storage::delete('public/images/' . $oldPurchase->buyer_id_image);
            }

            $uploadedFile = $request->file('buyer_id_image');

            $filename = time() . '_' . $uploadedFile->getClientOriginalName();
            $uploadedFile->storeAs('public/images', $filename);
            $input['buyer_id_image'] = 'images/' . $filename;
        }
        if ($request->hasFile('pancard_image')) {
            if ($request->id) {
                $oldPurchase = SaleOrder::find($request->id);
                Storage::delete('public/images/' . $oldPurchase->pancard_image);
            }
            $uploadedFile = $request->file('pancard_image');

            $filename = time() . '_' . $uploadedFile->getClientOriginalName();
            $uploadedFile->storeAs('public/images', $filename);
            $input['pancard_image'] = 'images/' . $filename;
        }
        try {
            DB::beginTransaction();
            $rc_transfer = $request->input('rc_transfer', 'false');
            if ($request->id) {
                $saleOrder = SaleOrder::find($request->id);
                $input['reg_date'] = $request->reg_date;
                $input['insurance_due_date'] = $request->insurance_due_date;
                $input['status'] = $request->mode;
                $input['mst_party_id'] = $request->mst_party_id;
                $input['mst_purchase_id'] = empty($request->purchase_id) ? $saleOrder->purchase_id : $request->purchase_id;
                $input['pancard_number'] = $request->pancard_number;
                $input['aadharcard_number'] = $request->aadharcard_number;
                $input['mst_executive_id'] = $request->executive_id;
                $input['date_of_sale'] = $request->date_of_sale;
                $saleOrder->update($input);
                if ($rc_transfer === 'true') {
                    if ($request->rc_id) {
                        $rcTransfer = RcTransfer::find($request->rc_id);
                        $rcTransfer->update([
                            'agent_id' => $request->agent_id,
                            'transfer_date' => $request->transfer_date,
                            'date' => $request->date,
                            'amount_paid' => $request->amount_paid,
                            'status' => $request->status,
                            'mst_party_id' => $saleOrder->mst_party_id,
                            'sale_order_id' => $saleOrder->id,
                        ]);
                    } else {
                        RcTransfer::create([
                            'agent_id' => $request->agent_id,
                            'transfer_date' => $request->transfer_date,
                            'date' => $request->date,
                            'amount_paid' => $request->amount_paid,
                            'status' => $request->status,
                            'mst_party_id' => $saleOrder->mst_party_id,
                            'sale_order_id' => $saleOrder->id,
                        ]);
                    }
                }

                SaleDetail::find($request->sale_order_id)->update(['status' => 5]);
                Purchase::find($request->purchase_id)->update(['is_sold' => 1]);
            } else {
                $input['reg_date'] = $request->reg_date;
                $input['insurance_due_date'] = $request->insurance_due_date;
                $input['status'] = $request->mode;
                $input['mst_party_id'] = $request->mst_party_id;
                $input['mst_purchase_id'] = $request->purchase_id;
                $input['pancard_number'] = $request->pancard_number;
                $input['aadharcard_number'] = $request->aadharcard_number;
                $input['mst_executive_id'] = $request->executive_id;
                $input['date_of_sale'] = $request->date_of_sale;
                $saleOrder = SaleOrder::create($input);

                SaleDetail::find($request->sale_order_id)->update(['status' => 5]);
                Purchase::find($request->purchase_id)->update(['is_sold' => 1]);
            }

            DB::commit();
            if ($rc_transfer === 'true') {
                \toastr()->success(ucfirst('RC Transfer successfully saved'));
                return redirect()->route('admin.rc-transfer.index');
            } else {
                \toastr()->success(ucfirst('Sale Order successfully saved'));
                return redirect()->route('admin.sale.sale.order-index');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving sale order' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $saleOrder = SaleOrder::with('purchase')->find($id);
        $type = true;
        $rcType = Purchase::getRcType();
        $hypothecationType = Purchase::getHypothecationType();
        $parties = MstParty::with('partyContact')->get()->map(function ($party) {
            $contactNumbers = $party->partyContact->pluck('number')->implode(', ');
            return [
                'id' => $party->id,
                'name' => $party->party_name,
                'contacts' => $contactNumbers
            ];
        });
        $company = MstInsurance::pluck('name', 'id');
        $vehicles = Purchase::select('id', 'reg_number')
            ->whereIn('status', [6, 7])
            ->whereNotIn('id', function ($query) {
                $query->select('purchase_id')
                    ->from('purchase_orders');
            });

        // If it's an update case, exclude the saved value from the dropdown
        if (isset($saleOrder->id)) {
            $vehicles = $vehicles->orWhere('id', $saleOrder->purchase_id);
        }

        $vehicles = $vehicles->get();
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        $models = MstModel::pluck('model', 'id');
        $brands = MstBrandType::pluck('type', 'id');
        $policyNumbers = CarInsurance::pluck('policy_number', 'id');

        return view('admin.sale-purchase.sale-order.create', compact('saleOrder', 'parties', 'vehicles', 'regNumbers', 'company', 'rcType', 'type', 'models', 'brands', 'policyNumbers'));
    }

    public function view($id)
    {
        $saleOrder = SaleOrder::with('purchase', 'party')->find($id);
        $parties = MstParty::with('partyContact')->get()->map(function ($party) {
            $contactNumbers = $party->partyContact->pluck('number')->implode(', ');
            return [
                'id' => $party->id,
                'name' => $party->party_name,
                'contacts' => $contactNumbers
            ];
        });
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        $company = MstInsurance::pluck('name', 'id');
        $rcType = Purchase::getRcType();
        $hypothecationType = Purchase::getHypothecationType();
        $models = MstModel::pluck('model', 'id');
        $brands = MstBrandType::pluck('type', 'id');
        $policyNumbers = CarInsurance::pluck('policy_number', 'id');

        return view('admin.sale-purchase.sale-order.show', compact('saleOrder', 'parties', 'vehicles', 'company', 'rcType', 'hypothecationType', 'models', 'brands', 'policyNumbers'));
    }

    public function delete($id)
    {
        $saleOrder = SaleOrder::find($id);
        $saleOrder->delete();

        \toastr()->success(ucfirst('Sale Order deleted successfully'));
        return redirect()->back();
    }

    public function statusChange($id, $state_id)
    {
        $sale = SaleOrder::find($id);
        $updateStatus = ($state_id == 1) ? 0 : 1;
        $message = ($state_id == 0) ? 'Sale Order activated successfully' : 'Sale Order deactivated successfully';

        $sale->update(['state_id' => $updateStatus]);

        \toastr()->success(ucfirst($message));
        return redirect()->back();
    }
}
