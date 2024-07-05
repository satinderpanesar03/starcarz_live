<?php

namespace App\Http\Controllers\admin\loans;

use App\Http\Controllers\Controller;
use App\Models\MortageDisbursedDetails;
use App\Models\MortageLoan;
use App\Models\MstBank;
use App\Models\MstExecutive;
use App\Models\MstInsuranceType;
use App\Models\MstParty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;

class MortageLoanController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.loan.mortage-loan.index');
        }

        $query = MortageLoan::with('party:id,party_name');
        $query->when($request->filled('party_name'), function ($query) use ($request) {
            $query->whereHas('party', function ($subquery) use ($request) {
                $subquery->where('party_name', 'like', '%' . $request->party_name . '%');
            });
        });
        $query->when($request->filled('status'), function ($query) use ($request) {
            $query->where('status', $request->status);
        });
        $query->when($request->filled('loan_type'), function ($query) use ($request) {
            $query->where('loan_type', $request->loan_type);
        });
        $query->when($request->filled('fromDate'), function ($query) use ($request) {
            $query->whereDate('created_at', '>=', $request->fromDate);
        });
        $query->when($request->filled('toDate'), function ($query) use ($request) {
            $query->whereDate('created_at', '<=', $request->toDate);
        });
        $query->when($request->filled('bank'), function ($query) use ($request) {
            $query->where('bank_id', $request->bank);
        });
        $query->when($request->filled('executive'), function ($query) use ($request) {
            $query->where('executive', $request->executive);
        });

        $mortageLoans = $query->withSum('disbursed', 'disbursed_amount')->orderBy('id', 'desc')
            ->paginate($request->limit ? $request->limit : 10);
        $status = MortageLoan::getStatus();
        $loanType = MortageLoan::getLoanType();
        $banks = MstBank::pluck('name', 'id');
        $executives = MstExecutive::pluck('name', 'id');
        return view('admin.loans.mortage-loan.index', compact('mortageLoans', 'status', 'loanType', 'banks', 'executives'));
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
                'contacts' => $contactNumbers
            ];
        });
        $banks = MstBank::pluck('name', 'id');
        $status = MortageLoan::getStatus();
        $insurance_types = MstInsuranceType::pluck('name', 'id');
        $loanType = MortageLoan::getLoanType();
        $tenures = MortageLoan::getTenure();
        return view('admin.loans.mortage-loan.create', compact('executives', 'parties', 'banks', 'status', 'insurance_types', 'loanType', 'type', 'tenures'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'effective_rate' => 'nullable',
            'margin' => 'nullable',
            'mclr' => 'nullable',
        ]);

        $input = $request->all();

        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();
            if ($request->hasFile('sanction_letter')) {
                $file = $request->file('sanction_letter');
                $storagePath = 'public/sanction/';

                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs($storagePath, $filename);

                $input['sanction_letter'] = 'sanction/' . $filename;
            }
            if (!$request->id) {
                $input['status'] = 1;
            }
            if ($request->id) {
                $mortageLoan = MortageLoan::find($request->id);
                $mortageLoan->update($input);
            } else {
                $mortageLoan = MortageLoan::create($input);
            }
            if ($request->has('disbursed')) {
                foreach ($request->disbursed as $disbursedData) {
                    if (isset($disbursedData['id'])) {
                        $disbursed = MortageDisbursedDetails::find($disbursedData['id']);
                        $disbursed->update($disbursedData);
                    } else {
                        $disbursed = new MortageDisbursedDetails($disbursedData);
                        $mortageLoan->disbursed()->save($disbursed);
                    }
                }
            }

            DB::commit();

            \toastr()->success(ucfirst('Mortage Loan successfully saved'));
            return redirect()->route('admin.loan.mortage-loan.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving mortage loan' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $type = false;
        $mortageLoan = MortageLoan::find($id);
        $executives = MstExecutive::pluck('name', 'id');
        $parties = MstParty::with('partyContact')->get()->map(function ($party) {
            $contactNumbers = $party->partyContact->pluck('number')->implode(', ');
            return [
                'id' => $party->id,
                'name' => $party->party_name,
                'contacts' => $contactNumbers
            ];
        });
        $banks = MstBank::pluck('name', 'id');
        $status = MortageLoan::getStatus();
        $insurance_types = MstInsuranceType::pluck('name', 'id');
        $loanType = MortageLoan::getLoanType();
        $tenures = MortageLoan::getTenure();
        $disbursedDetails = $mortageLoan->disbursed()->get();

        return view('admin.loans.mortage-loan.edit', compact('mortageLoan', 'executives', 'parties', 'banks', 'status', 'insurance_types', 'loanType', 'type', 'tenures', 'disbursedDetails'));
    }

    public function delete($id)
    {
        $color = MortageLoan::find($id);
        $color->delete();

        \toastr()->success(ucfirst('Mortage Loan successfully deleted'));
        return redirect()->back();
    }

    public function getPartyData(Request $request)
    {
        $partyId = $request->input('party_id');

        $party = MstParty::find($partyId);

        if ($party) {
            return response()->json([
                'party_name' => $party->party_name,
                'whatsapp_number' => $party->whatsapp_number,
                'residence_number' => $party->residence_number,
                'residence_city' => $party->residence_city,
                'designation' => $party->designation,
                'name' => $party->name,
                'office_number' => $party->office_number,
                'office_city' => $party->office_city,
                'residence_address' => $party->residence_address,
                'pan_number' => $party->pan_number,
                'office_address' => $party->office_address,
                'email' => $party->email,
            ]);
        } else {
            return response()->json([
                'error' => 'Party not found',
            ], 404);
        }
    }

    public function view($id)
    {
        $mortageLoan = MortageLoan::find($id);
        $executives = MstExecutive::pluck('name', 'id');
        $parties = MstParty::select('id', 'party_name')->get();
        $banks = MstBank::pluck('name', 'id');
        $status = MortageLoan::getStatus();
        $insurance_types = MstInsuranceType::pluck('name', 'id');
        $loanType = MortageLoan::getLoanType();
        $disbursedDetails = $mortageLoan->disbursed()->get();
        $tenures = MortageLoan::getTenure();

        return view('admin.loans.mortage-loan.view', compact('mortageLoan', 'executives', 'parties', 'banks', 'status', 'insurance_types', 'loanType', 'disbursedDetails', 'tenures'));
    }

    public function statusChange($id, $state_id)
    {
        $loan = MortageLoan::find($id);
        $updateStatus = ($state_id == 1) ? 0 : 1;
        $message = ($state_id == 0) ? 'Mortage Loan activated successfully' : 'Mortage Loan deactivated successfully';

        $loan->update(['state_id' => $updateStatus]);

        \toastr()->success(ucfirst($message));
        return redirect()->back();
    }

    public function getSubTypes(Request $request)
    {
        $i_id = $request->input('loan_type');

        $subtypes = DB::table('mst_insurance_types')->where('insurance_id', $i_id)->get();
        $html = '<option value="">Choose...</option>';
        foreach ($subtypes as $list) {
            $selected = $list->id == $request->input('selected_subtype') ? 'selected' : '';
            $html .= '<option value="' . $list->id . '" ' . $selected . '>' . $list->name . '</option>';
        }
        echo $html;
    }
}
