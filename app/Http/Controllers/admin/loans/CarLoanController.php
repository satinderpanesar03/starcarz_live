<?php

namespace App\Http\Controllers\admin\loans;

use App\Http\Controllers\Controller;
use App\Models\CarInsurance;
use App\Models\CarLoan;
use App\Models\MstBank;
use App\Models\MstBroker;
use App\Models\MstDealer;
use App\Models\MstExecutive;
use App\Models\MstInsurance;
use App\Models\MstModel;
use App\Models\MstParty;
use App\Models\RcTransfer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CarLoanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.loan.car-loan.index');
        }

        $query = CarLoan::with('party:id,party_name');
        $query->when($request->filled('party_name'), function ($query) use ($request) {
            $query->whereHas('party', function ($subquery) use ($request) {
                $subquery->where('party_name', 'like', '%' . $request->party_name . '%');
            });
        });
        $query->when($request->filled('status'), function ($query) use ($request) {
            $query->where('status', $request->status);
        });
        $query->when($request->filled('bank'), function ($query) use ($request) {
            $query->where('bank_id', $request->bank);
        });
        $query->when($request->filled('executive'), function ($query) use ($request) {
            $query->where('executive', $request->executive);
        });
        $query->when($request->filled('loan_type'), function ($query) use ($request) {
            $query->where('loan_type', $request->loan_type);
        });
        $query->when($request->filled('car_type'), function ($query) use ($request) {
            $query->where('car_type', $request->car_type);
        });
        $query->when($request->filled('fromDate'), function ($query) use ($request) {
            $query->whereDate('created_at', '>=', $request->fromDate);
        });
        $query->when($request->filled('toDate'), function ($query) use ($request) {
            $query->whereDate('created_at', '<=', $request->toDate);
        });
        $carLoans = $query->orderBy('id', 'desc')
            ->paginate($request->limit ? $request->limit : 10);
// dd($carLoans);
        $models = MstModel::pluck('model', 'id');
        $dealers = MstDealer::pluck('name', 'id');
        $status = CarLoan::getStatus();
        $banks = MstBank::pluck('name', 'id');
        $executives = MstExecutive::pluck('name', 'id');
        $loanType = CarLoan::getLoanType();
        $carType = CarLoan::getCarType();
        $roleNames = explode(',',Auth::guard('admin')->user()->roles);

        return view('admin.loans.car-loan.index', compact('carLoans', 'models', 'dealers', 'status', 'banks', 'executives', 'loanType', 'carType','roleNames'));
    }

    public function create()
    {
        $type = true;
        $executives = MstExecutive::pluck('name', 'id');
        $parties = MstParty::with('partyContact')->get()->map(function ($party) {
            $contactNumbers = $party->partyContact->pluck('number')->implode(', ');
            return [
                'id' => $party->id,
                'name' => $party->party_name,
                'contacts' => $contactNumbers,
                'father_name' => $party->father_name
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

        return view('admin.loans.car-loan.create', compact('executives', 'parties', 'models', 'banks', 'insurance', 'status', 'insuredBy', 'broker', 'dealers', 'type', 'tenures', 'policyNumbers'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'mst_dealer_id' => 'required',
            // 'mst_model_id' => 'required',
            // 'insurance_from_date' => 'required',
            // 'insurance_to_date' => 'required',
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
                $carLoan = CarLoan::find($request->id);
                $carLoan->update($input);
                if ($rc_transfer === 'true') {
                    if ($request->rc_id) {
                        $rcTransfer = RcTransfer::find($request->rc_id);
                        $rcTransfer->update([
                            'agent_id' => $request->agent_id,
                            'transfer_date' => $request->transfer_date,
                            'date' => $request->date,
                            'amount_paid' => $request->amount_paid,
                            'status' => $request->status,
                            'mst_party_id' => $carLoan->mst_party_id,
                            'car_loan_id' => $carLoan->id,
                        ]);
                    } else {
                        RcTransfer::create([
                            'agent_id' => $request->agent_id,
                            'transfer_date' => $request->transfer_date,
                            'date' => $request->date,
                            'amount_paid' => $request->amount_paid,
                            'status' => $request->status,
                            'mst_party_id' => $carLoan->mst_party_id,
                            'car_loan_id' => $carLoan->id,
                        ]);
                    }
                }
            } else {
                CarLoan::create($input);
            }

            DB::commit();
            if ($rc_transfer === 'true') {
                \toastr()->success(ucfirst('RC Transfer successfully saved'));
                return redirect()->route('admin.rc-transfer.index');
            } else {
                \toastr()->success(ucfirst('Car Loan successfully saved'));
                return redirect()->route('admin.loan.car-loan.index');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving car loan' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $type = false;
        $carLoan = CarLoan::find($id);
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

        return view('admin.loans.car-loan.create', compact('carLoan', 'executives', 'parties', 'models', 'banks', 'insurance', 'status', 'insuredBy', 'broker', 'dealers', 'type', 'tenures', 'policyNumbers'));
    }

    public function delete($id)
    {
        $color = CarLoan::find($id);
        $color->delete();

        \toastr()->success(ucfirst('Car Loan successfully deleted'));
        return redirect()->back();
    }

    // public function getPartyData(Request $request)
    // {
    //     $partyId = $request->input('party_id');

    //     $party = MstParty::find($partyId);

    //     if ($party) {
    //         return response()->json([
    //             'party_name' => $party->party_name,
    //             'whatsapp_number' => $party->whatsapp_number,
    //             'residence_number' => $party->residence_number,
    //             'residence_city' => $party->residence_city,
    //             'designation' => $party->designation,
    //             'name' => $party->name,
    //             'office_number' => $party->office_number,
    //             'office_city' => $party->office_city,
    //             'residence_address' => $party->residence_address,
    //             'pan_number' => $party->pan_number,
    //             'office_address' => $party->office_address,
    //             'email' => $party->email,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'error' => 'Party not found',
    //         ], 404);
    //     }
    // }

    public function view($id)
    {
        $carLoan = CarLoan::find($id);
        $executives = MstExecutive::pluck('name', 'id');
        $parties = MstParty::select('id', 'party_name')->get();
        $models = MstModel::pluck('model', 'id');
        $banks = MstBank::pluck('name', 'id');
        $insurance = MstInsurance::pluck('name', 'id');
        $status = CarLoan::getStatus();
        $insuredBy = CarLoan::getInsuredBy();
        $broker = MstBroker::pluck('name', 'id');
        $dealers = MstDealer::pluck('name', 'id');
        $tenures = CarLoan::getTenure();
        $policyNumbers = CarInsurance::pluck('policy_number', 'id');

        return view('admin.loans.car-loan.view', compact('carLoan', 'executives', 'parties', 'models', 'insurance', 'status', 'insuredBy', 'broker', 'dealers', 'banks', 'tenures', 'policyNumbers'));
    }

    public function statusChange($id, $state_id)
    {
        $loan = CarLoan::find($id);
        $updateStatus = ($state_id == 1) ? 0 : 1;
        $message = ($state_id == 0) ? 'Car Loan activated successfully' : 'Car Loan deactivated successfully';

        $loan->update(['state_id' => $updateStatus]);

        \toastr()->success(ucfirst($message));
        return redirect()->back();
    }

    public function chartIndex($id)
    {
        $carLoan = CarLoan::find($id);

        $loanAmount = $carLoan->loan_amount;
        $roi = (float) str_replace('%', '', $carLoan->roi);
        $interestRate = $roi / 100;
        $emiAmount = $carLoan->emi_amount;
        $emiStartDate = Carbon::parse($carLoan->emi_start_date);
        $currentDate = $emiStartDate->copy();
        $outstanding = $loanAmount;
        $emiEndDate = null;

        while ($outstanding > 0 && ($emiEndDate === null || $currentDate->lte($emiEndDate))) {
            $interest = $outstanding * $interestRate / 12;
            $repayment = $emiAmount - $interest;
            $openBalance = max(0, $outstanding - $repayment);
            $outstanding = max(0, $outstanding - $repayment);

            if ($outstanding == 0 && $emiEndDate === null) {
                $emiEndDate = $currentDate->copy();
            }
            $currentDate->addMonth();
        }

        return view('admin.loans.car-loan.chart-index', compact('carLoan', 'emiEndDate'));
    }
}
