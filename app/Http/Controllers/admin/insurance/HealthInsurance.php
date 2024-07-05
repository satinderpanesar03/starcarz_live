<?php

namespace App\Http\Controllers\admin\insurance;

use App\Http\Controllers\Controller;
use App\Models\EndorsementInsuranceDetail;
use App\Models\HealthInsurance as ModelsHealthInsurance;
use App\Models\InsuranceRenewalDetail;
use App\Models\MstExecutive;
use App\Models\MstModel;
use App\Models\MstParty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class HealthInsurance extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.health.index');
        } else {
            $insurances = ModelsHealthInsurance::with('party:id,party_name')
                ->when($request->filled('party_name'), function ($query) use ($request) {
                    $query->whereHas('party', function ($subquery) use ($request) {
                        $subquery->where('party_name', 'like', '%' . $request->party_name . '%');
                    });
                })
                ->PolicyNumber($request)
                ->orderBy('id', 'desc')
                ->paginate($request->limit ? $request->limit : 10);
                $parties = MstParty::select('id','party_name')->get();

            return view('admin.health.index', compact('insurances','parties'));
        }
    }

    public function create()
    {
        $executives = MstExecutive::pluck('name', 'id');
        $parties = MstParty::select('id', 'party_name')->get();

        return view('admin.health.create', compact('executives', 'parties'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'party_id' => 'required',
            // 'member_name' => 'required',
            'sum_assured' => 'required',
            'end_date' => 'required',
            'policy_number' => [
                'required',
                Rule::unique('health_insurances')->ignore($request->id),
            ],
        ], [
            'party_id' => 'Please select party'
        ]);
        $input = $request->all();


        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if ($request->hasFile('policy_image')) {
            if ($request->id) {
                $oldPurchase = ModelsHealthInsurance::find($request->id);
                Storage::delete('public/images/' . $oldPurchase->policy_image);
            }
            $uploadedFile = $request->file('policy_image');

            $filename = time() . '_health_insurance_' . $uploadedFile->getClientOriginalName();
            $uploadedFile->storeAs('public/images', $filename);
            $input['policy_image'] = 'images/' . $filename;
        }
        try {
            DB::beginTransaction();
            $renewal = $request->input('renewal', 'false');

            if ($request->id) {
                $health = ModelsHealthInsurance::find($request->id);
                $health->update($input);
                $health->memberName()->delete();
                if ($renewal === 'true') {
                    $data = [
                        'insurance_id' => $request->id,
                        'insurance_from_date' => $request->start_date,
                        'insurance_to_date' => $request->end_date,
                        'premium' => $request->premium,
                        'gst' => $request->gst,
                        'sum_insured' => $request->sum_assured,
                        'type' => 1,
                    ];
                    InsuranceRenewalDetail::create($data);
                }
            } else {
                $health = ModelsHealthInsurance::create($input);
                $data = [
                    'insurance_id' => $request->id,
                    'insurance_from_date' => $request->start_date,
                    'insurance_to_date' => $request->end_date,
                    'premium' => $request->premium,
                    'gst' => $request->gst,
                    'sum_insured' => $request->sum_assured,
                    'type' => 1,
                ];
                InsuranceRenewalDetail::create($data);
            }

            if ($request->has('member_names')) {
                foreach ($request->member_names as $memberName) {
                    $health->memberName()->create([
                        'member_name' => $memberName,
                    ]);
                }
            }

            DB::commit();

            \toastr()->success(ucfirst('health insurance saved successfully'));
            return redirect()->route('admin.health.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving health insurance');
            return redirect()->back();
        }
    }

    public function show(Request $request, $id)
    {
        $renewal = $request->query('renewal', 'false');
        $parties = MstParty::select('id', 'party_name')->get();
        $insurance = ModelsHealthInsurance::find($id);
        $endorsement = EndorsementInsuranceDetail::where('insurance_type', 1)
            ->where('policy_number', $insurance->policy_number)
            ->first();
        return view('admin.health.edit', compact('parties', 'insurance', 'renewal', 'endorsement'));
    }

    public function view($id)
    {
        $parties = MstParty::select('id', 'party_name')->get();
        $insurance = ModelsHealthInsurance::find($id);
        $endorsement = EndorsementInsuranceDetail::where('insurance_type', 1)
            ->where('policy_number', $insurance->policy_number)
            ->first();
        return view('admin.health.view', compact('parties', 'insurance', 'endorsement'));
    }

    public function renewalIndex()
    {
        $oneMonthLater = Carbon::now()->addDays(31)->toDateString();
        $today = Carbon::now()->toDateString();

        $healthInsurances = ModelsHealthInsurance::whereBetween('end_date', [$today, $oneMonthLater])
            ->orderBy('id', 'desc')
            ->get();
        $parties = MstParty::select('id','party_name')->get();

        return view('admin.health.renewal-index', compact('healthInsurances','parties'));
    }

    public function endorsementIndex(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.endorsement.health.insurance.index');
        } else {
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');

            $query = EndorsementInsuranceDetail::query()->where('insurance_type', 1);
            $query->when($request->filled('policy_number'), function ($query) use ($request) {
                $query->where('policy_number', $request->policy_number);
            });
            if ($fromDate) {
                $query->whereDate('date', '>=', $fromDate);
            }
            if ($toDate) {
                $query->whereDate('date', '<=', $toDate);
            }

            $insurances = $query->orderBy('id', 'desc')->paginate($request->limit ? $request->limit : 10);
        }
        return view('admin.health.endorsement-index', compact('insurances'));
    }
    public function endorsementCreate()
    {
        $policyNumbers = ModelsHealthInsurance::pluck('policy_number', 'id');
        return view('admin.health.endorsement-create', compact('policyNumbers'));
    }

    public function endorsementStore(Request $request)
    {
        try {
            DB::beginTransaction();

            $data = [
                'insurance_id' => $request->insurance_id,
                'policy_id' => $request->policy_id,
                'policy_number' => $request->policy_number,
                'insurance_type' => 1,
                'date' => $request->date,
                'sum_assured' => $request->sum_assured,
                'premium' => $request->premium,
                'endorsement_details' => $request->endorsement_details,
            ];

            if ($request->id) {
                EndorsementInsuranceDetail::where('id', $request->id)->update($data);
            } else {
                EndorsementInsuranceDetail::create($data);
            }

            DB::commit();

            \toastr()->success(ucfirst('Endorsement Insurance details saved successfully'));
            return redirect()->route('admin.endorsement.health.insurance.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving endorsement insurance details');
            return redirect()->back();
        }
    }

    public function endorsementShow($id)
    {
        $endorsement = EndorsementInsuranceDetail::find($id);
        $policyNumbers = ModelsHealthInsurance::pluck('policy_number', 'id');
        return view('admin.health.endorsement-create', compact('endorsement', 'policyNumbers'));
    }

    public function endorsementView($id)
    {
        $endorsement = EndorsementInsuranceDetail::find($id);
        $policyNumbers = ModelsHealthInsurance::pluck('policy_number', 'id');
        return view('admin.health.endorsement-view', compact('endorsement', 'policyNumbers'));
    }
}
