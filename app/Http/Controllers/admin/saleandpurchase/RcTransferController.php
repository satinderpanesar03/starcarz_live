<?php

namespace App\Http\Controllers\admin\saleandpurchase;

use App\Http\Controllers\Controller;
use App\Models\AggregatorLoan;
use App\Models\CarInsurance;
use App\Models\CarLoan;
use App\Models\MstBank;
use App\Models\MstBroker;
use App\Models\MstDealer;
use App\Models\MstExecutive;
use App\Models\MstInsurance;
use App\Models\MstModel;
use App\Models\MstParty;
use App\Models\MstRtoAgent;
use App\Models\Purchase;
use App\Models\RcTransfer;
use App\Models\SaleOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RcTransferController extends Controller
{
    public function index(Request $request)
    {
        $type = true;
        $carLoans = collect();
        $aggregateLoans = collect();
        $saleOrders = collect();
        if ($request->has('clear_search')) {
            return redirect()->route('admin.rc-transfer.index');
        } else {

            if ($request->filled('source')) {
                $source = $request->source;
                switch ($source) {
                    case 'Car Loan':
                        $carLoans = CarLoan::where('car_type', '1')->get();
                        break;
                    case 'Aggregator Loan':
                        $aggregateLoans = AggregatorLoan::get();
                        break;
                    case 'Sale Order':
                        $saleOrders = SaleOrder::get();
                        break;
                }
            } else {
                $carLoans = CarLoan::with('party:id,party_name','carModel:id,mst_brand_type_id,model','rc_transfer')->where('car_type', '1')->get();
                $aggregateLoans = AggregatorLoan::with('rc_transfer')->get();
                $saleOrders = SaleOrder::with('party:id,party_name','carModel:id,mst_brand_type_id,model','purchase','rc_transfer')->get();
            }


            $combinedData = collect();

            $combinedData = $combinedData->concat($carLoans);
            $combinedData = $combinedData->concat($aggregateLoans);
            $combinedData = $combinedData->concat($saleOrders);
            if ($request->filled('partyFilter')) {
                $partyId = $request->input('partyFilter');
                $otherIds = array_merge(
                    RcTransfer::where('mst_party_id', $partyId)->pluck('sale_order_id')->toArray(),
                    RcTransfer::where('mst_party_id', $partyId)->pluck('aggregator_loan_id')->toArray(),
                    RcTransfer::where('mst_party_id', $partyId)->pluck('car_loan_id')->toArray()
                );
                $combinedData = $combinedData->filter(function ($item) use ($otherIds) {
                    return in_array($item->id, $otherIds);
                });
            }
            if ($request->filled('fromDate') && $request->filled('toDate')) {
                $fromDate = $request->input('fromDate');
                $toDate = $request->input('toDate');

                $combinedData = $combinedData->filter(function ($item) use ($fromDate, $toDate) {
                    return $item->created_at >= $fromDate && $item->created_at <= $toDate;
                });
            }
            if ($request->filled('agent')) {
                $agentId = $request->input('agent');
                $otherIds = array_merge(
                    RcTransfer::where('agent_id', $agentId)->pluck('sale_order_id')->toArray(),
                    RcTransfer::where('agent_id', $agentId)->pluck('aggregator_loan_id')->toArray(),
                    RcTransfer::where('agent_id', $agentId)->pluck('car_loan_id')->toArray()
                );
                $combinedData = $combinedData->filter(function ($item) use ($otherIds) {
                    return in_array($item->id, $otherIds);
                });
            }
            if ($request->filled('status')) {
                $status = $request->input('status');
                $otherIds = array_merge(
                    RcTransfer::where('status', $status)->pluck('sale_order_id')->toArray(),
                    RcTransfer::where('status', $status)->pluck('aggregator_loan_id')->toArray(),
                    RcTransfer::where('status', $status)->pluck('car_loan_id')->toArray()
                );
                $combinedData = $combinedData->filter(function ($item) use ($otherIds) {
                    return in_array($item->id, $otherIds);
                });
            }
            $parties = MstParty::pluck('party_name', 'id');
            $agents = MstRtoAgent::pluck('agent', 'id');
            $statusType = RcTransfer::getStatusType();
            $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        }
// dd($combinedData);
        return view('admin.sale-purchase.rc-transfer.index', compact('combinedData', 'parties', 'vehicles', 'type', 'agents', 'statusType'));
    }

    public function create()
    {
        $type = true;
        $agents = MstRtoAgent::pluck('agent', 'id');
        $parties = MstParty::select('id', 'party_name')->get();
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        $vehicles = Purchase::select('id', 'reg_number')
            ->whereIn('status', [6, 7])
            ->whereNotIn('id', function ($query) {
                $query->select('purchase_id')
                    ->from('purchase_orders');
            })
            ->get();
        $statusType = RcTransfer::getStatusType();
        return view('admin.sale-purchase.rc-transfer.create', compact('parties', 'vehicles', 'regNumbers', 'type', 'agents', 'statusType'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            if ($request->id) {
                $rcTransfer = RcTransfer::find($request->id);
                $rcTransfer->update([
                    'mst_party_id' => $request->party_id,
                    'vehicle_id' => $request->mst_purchase_id,
                    'transfer_date' => $request->transfer_date,
                    'agent_id' => $request->agent_id,
                    'date' => $request->date,
                    'amount_paid' => $request->amount_paid,
                ]);
            } else {
                RcTransfer::create([
                    'mst_party_id' => $request->party_id,
                    'vehicle_id' => $request->mst_purchase_id,
                    'transfer_date' => $request->transfer_date,
                    'agent_id' => $request->agent_id,
                    'date' => $request->date,
                    'amount_paid' => $request->amount_paid,
                ]);
            }

            DB::commit();

            \toastr()->success(ucfirst('RC Transfer successfully saved'));
            return redirect()->route('admin.rc-transfer.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving RC transfer' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $type = false;
        $agents = MstRtoAgent::pluck('agent', 'id');
        $rcTransfer = RcTransfer::find($id);
        $parties = MstParty::select('id', 'party_name')->get();
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        $vehicles = Purchase::select('id', 'reg_number')
            ->whereIn('status', [6, 7])
            ->whereNotIn('id', function ($query) {
                $query->select('purchase_id')
                    ->from('purchase_orders');
            });

        // If it's an update case, exclude the saved value from the dropdown
        if (isset($rcTransfer->id)) {
            $vehicles = $vehicles->orWhere('id', $rcTransfer->vehicle_id);
        }

        $vehicles = $vehicles->get();
        return view('admin.sale-purchase.rc-transfer.create', compact('rcTransfer', 'parties', 'vehicles', 'regNumbers', 'type', 'agents'));
    }

    public function delete($id)
    {
        $rcTransfer = RcTransfer::find($id);
        $rcTransfer->delete();

        \toastr()->success(ucfirst('RC Transfer successfully deleted'));
        return redirect()->back();
    }

    public function view($id)
    {
        $type = false;
        $rcTransfer = RcTransfer::find($id);
        $agents = MstRtoAgent::pluck('agent', 'id');
        $parties = MstParty::select('id', 'party_name')->get();
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        return view('admin.sale-purchase.rc-transfer.show', compact('rcTransfer', 'parties', 'vehicles', 'regNumbers', 'type', 'agents'));
    }

    public function statusChange($id, $status)
    {
        $rcTransfer = RcTransfer::find($id);
        $updateStatus = ($status == 1) ? 0 : 1;
        $message = ($status == 0) ? 'RcTransfer activated successfully' : 'RcTransfer deactivated successfully';

        $rcTransfer->update(['status' => $updateStatus]);

        \toastr()->success(ucfirst($message));
        return redirect()->back();
    }

    public function aggregratorShow($id)
    {
        $type = false;
        $aggregratorLoan = AggregatorLoan::find($id);
        $rcTransfer = RcTransfer::where('aggregator_loan_id', $id)->first();
        $executives = MstExecutive::pluck('name', 'id');
        $insurance = MstInsurance::pluck('name', 'id');
        $banks = MstBank::pluck('name', 'id');
        $agents = MstRtoAgent::pluck('agent', 'id');
        $statusType = RcTransfer::getStatusType();

        return view('admin.sale-purchase.rc-transfer.aggregrator-loan-create', compact('aggregratorLoan', 'executives', 'insurance', 'banks', 'agents', 'rcTransfer', 'statusType'));
    }

    public function carLoanShow($id)
    {
        $type = false;
        $carLoan = CarLoan::find($id);
        $rcTransfer = RcTransfer::where('car_loan_id', $id)->first();
        $executives = MstExecutive::pluck('name', 'id');
        $parties = MstParty::with('partyContact')->get()->map(function ($party) {
            $contactNumbers = $party->partyContact->pluck('number')->implode(', ');
            return [
                'id' => $party->id,
                'name' => $party->party_name,
                'contacts' => $contactNumbers
            ];
        });
        $models = MstModel::pluck('model', 'id');
        $banks = MstBank::pluck('name', 'id');
        $insurance = MstInsurance::pluck('name', 'id');
        $status = CarLoan::getStatus();
        $insuredBy = CarLoan::getInsuredBy();
        $broker = MstBroker::pluck('name', 'id');
        $dealers = MstDealer::pluck('name', 'id');
        $tenures = CarLoan::getTenure();
        $policyNumbers = CarInsurance::pluck('policy_number', 'id');
        $agents = MstRtoAgent::pluck('agent', 'id');
        $statusType = RcTransfer::getStatusType();

        return view('admin.sale-purchase.rc-transfer.car-loan-create', compact('carLoan', 'executives', 'parties', 'models', 'banks', 'insurance', 'status', 'insuredBy', 'broker', 'dealers', 'type', 'tenures', 'policyNumbers', 'agents', 'rcTransfer', 'statusType'));
    }

    public function saleShow($id)
    {
        $saleOrder = SaleOrder::with('purchase')->find($id);
        $rcTransfer = RcTransfer::where('sale_order_id', $id)->first();
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

        if (isset($saleOrder->id)) {
            $vehicles = $vehicles->orWhere('id', $saleOrder->purchase_id);
        }

        $vehicles = $vehicles->get();
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        $agents = MstRtoAgent::pluck('agent', 'id');
        $statusType = RcTransfer::getStatusType();

        return view('admin.sale-purchase.rc-transfer.sale-create', compact('saleOrder', 'parties', 'vehicles', 'regNumbers', 'company', 'rcType', 'type', 'agents', 'rcTransfer', 'statusType'));
    }

    public function aggregratorView($id)
    {
        $type = false;
        $aggregratorLoan = AggregatorLoan::find($id);
        $rcTransfer = RcTransfer::where('aggregator_loan_id', $id)->first();
        $executives = MstExecutive::pluck('name', 'id');
        $insurance = MstInsurance::pluck('name', 'id');
        $banks = MstBank::pluck('name', 'id');
        $agents = MstRtoAgent::pluck('agent', 'id');
        $statusType = RcTransfer::getStatusType();

        return view('admin.sale-purchase.rc-transfer.aggregrator-loan-view', compact('aggregratorLoan', 'executives', 'insurance', 'banks', 'agents', 'rcTransfer', 'statusType'));
    }

    public function carLoanView($id)
    {
        $type = false;
        $carLoan = CarLoan::find($id);
        $rcTransfer = RcTransfer::where('car_loan_id', $id)->first();
        $executives = MstExecutive::pluck('name', 'id');
        $parties = MstParty::with('partyContact')->get()->map(function ($party) {
            $contactNumbers = $party->partyContact->pluck('number')->implode(', ');
            return [
                'id' => $party->id,
                'name' => $party->party_name,
                'contacts' => $contactNumbers
            ];
        });
        $models = MstModel::pluck('model', 'id');
        $banks = MstBank::pluck('name', 'id');
        $insurance = MstInsurance::pluck('name', 'id');
        $status = CarLoan::getStatus();
        $insuredBy = CarLoan::getInsuredBy();
        $broker = MstBroker::pluck('name', 'id');
        $dealers = MstDealer::pluck('name', 'id');
        $tenures = CarLoan::getTenure();
        $policyNumbers = CarInsurance::pluck('policy_number', 'id');
        $agents = MstRtoAgent::pluck('agent', 'id');
        $statusType = RcTransfer::getStatusType();

        return view('admin.sale-purchase.rc-transfer.car-loan-view', compact('carLoan', 'executives', 'parties', 'models', 'banks', 'insurance', 'status', 'insuredBy', 'broker', 'dealers', 'type', 'tenures', 'policyNumbers', 'agents', 'rcTransfer', 'statusType'));
    }

    public function saleView($id)
    {
        $saleOrder = SaleOrder::with('purchase')->find($id);
        $rcTransfer = RcTransfer::where('sale_order_id', $id)->first();
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

        if (isset($saleOrder->id)) {
            $vehicles = $vehicles->orWhere('id', $saleOrder->purchase_id);
        }

        $vehicles = $vehicles->get();
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        $agents = MstRtoAgent::pluck('agent', 'id');
        $statusType = RcTransfer::getStatusType();

        return view('admin.sale-purchase.rc-transfer.sale-view', compact('saleOrder', 'parties', 'vehicles', 'regNumbers', 'company', 'rcType', 'type', 'agents', 'rcTransfer', 'statusType'));
    }
}
