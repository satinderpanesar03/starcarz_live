<?php

namespace App\Http\Controllers\admin\loans;

use App\Http\Controllers\Controller;
use App\Models\AggregatorLoan;
use App\Models\MstBank;
use App\Models\MstExecutive;
use App\Models\MstInsurance;
use App\Models\RcTransfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AggregatorLoanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.loan.aggregrator-loan.index');
        }
        $executiveFilter = $request->input('executiveFilter');
        $query = AggregatorLoan::query();
        $query->when($request->filled('firm_name'), function ($query) use ($request) {
            $query->where('firm_name', $request->firm_name);
        });
        $query->when($request->filled('fromDate'), function ($query) use ($request) {
            $query->whereDate('created_at', '>=', $request->fromDate);
        });
        $query->when($request->filled('toDate'), function ($query) use ($request) {
            $query->whereDate('created_at', '<=', $request->toDate);
        });
        if ($executiveFilter) {
            $query->where('executive', $executiveFilter);
        }

        $aggregratorLoans = $query->orderBy('id', 'desc')
            ->paginate($request->limit ? $request->limit : 10);

        $executives = MstExecutive::pluck('name', 'id');
        return view('admin.loans.aggregrator-loan.index', compact('aggregratorLoans', 'executives'));
    }

    public function create()
    {
        $type = true;
        $executives = MstExecutive::pluck('name', 'id');
        $insurance = MstInsurance::pluck('name', 'id');
        $banks = MstBank::pluck('name', 'id');

        return view('admin.loans.aggregrator-loan.create', compact('executives', 'insurance', 'banks'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'policy_number' => [
                'required',
                Rule::unique('aggregator_loans')->ignore($request->id),
            ],
        ]);
        $input = $request->all();
        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();
            $rc_transfer = $request->input('rc_transfer', 'false');
            if (!$request->id) {
                $input['status'] = 1;
            }
            if ($request->id) {
                $aggregratorLoan = AggregatorLoan::find($request->id);
                $aggregratorLoan->update($input);
                if ($rc_transfer === 'true') {
                    if ($request->rc_id) {
                        $rcTransfer = RcTransfer::find($request->rc_id);
                        $rcTransfer->update([
                            'agent_id' => $request->agent_id,
                            'transfer_date' => $request->transfer_date,
                            'date' => $request->disburshment_date,
                            'amount_paid' => $request->amount_paid,
                            'status' => $request->status,
                            'aggregator_loan_id' => $aggregratorLoan->id,
                        ]);
                    } else {
                        RcTransfer::create([
                            'agent_id' => $request->agent_id,
                            'transfer_date' => $request->transfer_date,
                            'date' => $request->disburshment_date,
                            'amount_paid' => $request->amount_paid,
                            'status' => $request->status,
                            'aggregator_loan_id' => $aggregratorLoan->id,
                        ]);
                    }
                }
            } else {
                AggregatorLoan::create($input);
            }

            DB::commit();
            if ($rc_transfer === 'true') {
                \toastr()->success(ucfirst('RC Transfer successfully saved'));
                return redirect()->route('admin.rc-transfer.index');
            } else {
                \toastr()->success(ucfirst('Aggregator Loan Loan successfully saved'));
                return redirect()->route('admin.loan.aggregrator-loan.index');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving Aggregator loan' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $type = false;
        $aggregratorLoan = AggregatorLoan::find($id);
        $executives = MstExecutive::pluck('name', 'id');
        $insurance = MstInsurance::pluck('name', 'id');
        $banks = MstBank::pluck('name', 'id');

        return view('admin.loans.aggregrator-loan.create', compact('aggregratorLoan', 'executives', 'insurance', 'banks'));
    }

    public function view($id)
    {
        $type = false;
        $aggregratorLoan = AggregatorLoan::find($id);
        $executives = MstExecutive::pluck('name', 'id');
        $insurance = MstInsurance::pluck('name', 'id');
        $banks = MstBank::pluck('name', 'id');

        return view('admin.loans.aggregrator-loan.view', compact('aggregratorLoan', 'executives', 'insurance', 'banks'));
    }

    public function statusChange($id, $state_id)
    {
        $loan = AggregatorLoan::find($id);
        $updateStatus = ($state_id == 1) ? 0 : 1;
        $message = ($state_id == 0) ? 'Aggregator Loan activated successfully' : 'Aggregator Loan deactivated successfully';

        $loan->update(['state_id' => $updateStatus]);

        \toastr()->success(ucfirst($message));
        return redirect()->back();
    }
}
