<?php

namespace App\Http\Controllers\admin\master;

use App\Http\Controllers\Controller;
use App\Models\MstBrandType;
use App\Models\MstParty;
use App\Models\PartyCity;
use App\Models\PartyContact;
use App\Models\PartyFirm;
use App\View\Components\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Rules\UniquePartyAndFatherNames;

class PartyController extends Controller
{

    public static function partyValidation($newFirmNames, $newEmail, $newWhatsAppNumbers, $newOfficeNumbers, $newOfficeCities)
    {
        $existingFirmNames = MstParty::pluck('name')->toArray();
        $existingEmail = MstParty::pluck('email')->toArray();
        $existingWhatsAppNumbers = PartyContact::where('type', 1)->pluck('number')->toArray();
        $existingOfficeNumbers = PartyContact::where('type', 2)->pluck('number')->toArray();
        $existingOfficeCities = PartyCity::pluck('city')->toArray();

        // $allValues = array_merge(
        //     $newEmail,
        // );
        $allValues = array();
        foreach ($newFirmNames as $i) {
            array_push($allValues, $i);
        }
        foreach ($newWhatsAppNumbers as $i) {
            array_push($allValues, $i);
        }
        foreach ($newOfficeNumbers as $i) {
            array_push($allValues, $i);
        }
        foreach ($newOfficeCities as $i) {
            array_push($allValues, $i);
        }
        array_push($allValues, $newEmail);
        foreach ($allValues as $value) {
            $found1 = false;
            $found2 = false;
            $found3 = false;
            $found4 = false;
            foreach ($existingFirmNames as $firm) {
                if ($value === $firm) {
                    $found1 = true;
                    break;
                }
            }


            foreach ($existingOfficeNumbers as $firm) {
                if ($value === $firm) {
                    $found2 = true;
                    break;
                }
            }

            foreach ($existingOfficeCities as $firm) {
                if ($value === $firm) {
                    $found3 = true;
                    break;
                }
            }

            foreach ($newWhatsAppNumbers as $firm) {
                if ($value === $firm) {
                    $found4 = true;
                    break;
                }
            }

            if (!$found1 || !$found2 || !$found3 || !$found4) {
                \toastr()->error('At least one of the fields must be different.');
                return redirect()->back();
            }
        }
    }

    public function index(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.master.party.index');
        } else {
            $parties = MstParty::with('partyFirm', 'partyContact')
                ->when($request->filled('firm_name'), function ($query) use ($request) {
                    $query->whereHas('partyFirm', function ($subquery) use ($request) {
                        $subquery->where('firm', 'like', '%' . $request->firm_name . '%');
                    });
                })
                ->PartySearch($request)
                ->EmailSearch($request)
                ->CitySearch($request)
                ->PhoneSearch($request)
                ->orderBy('id', 'desc')
                ->paginate($request->limit ?: 10);
        }

        return view('admin.master.party.index')->with([
            'parties' => $parties
        ]);
    }

    public function create()
    {
        $party = array();
        return view('admin.master.party.create', compact('party'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'office_address' => 'required',
            'name' => 'required',
            // 'office_city' => 'required',
            'residence_address' => 'required',
            // 'pan_number' => 'required',
            'email' => 'nullable|email',
            'residence_city' => 'required',
            'party_name' => [
                'required',
                // Rule::unique('mst_parties')->ignore($request->id),
                // new UniquePartyAndFatherNames
            ],
            'father_name' => ['nullable'],
            'whatsapp_number' => [
                'required',
                // 'distinct',
                // Rule::unique('party_contacts', 'number')->where(function ($query) use ($request) {
                //     return $query->where('type', 1)->whereNot('mst_party_id', $request->id);
                // }),
            ],
            'office_number' => [
                // 'required',
                // 'distinct',
                // Rule::unique('party_contacts', 'number')->where(function ($query) use ($request) {
                //     return $query->where('type', 2)->whereNot('mst_party_id', $request->id);
                // }),
            ],
            // 'residence_city' => [
            //     'required',
            //     Rule::unique('mst_parties')->ignore($request->input('residence_city')),
            // ],
        ]);
        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // return $this->partyValidation($request->input('name'), $request->input('email'), $request->input('whatsapp_number'), $request->input('office_number'), $request->input('office_city'));

        try {
            DB::beginTransaction();

            if ($request->id) {
                $party = MstParty::find($request->id);
                $party->update([
                    'party_name' => $request->party_name,
                    'father_name' => $request->father_name,
                    'office_address' => $request->office_address,
                    'residence_city' => $request->residence_city,
                    'designation' => $request->designation,
                    'residence_address' => $request->residence_address,
                    'pan_number' => $request->pan_number,
                    'email' => $request->email,
                ]);
                $party->partyFirm()->delete();
                foreach ($request->name as $n) {
                    $party->partyFirm()->create([
                        'firm' => $n
                    ]);
                }
                $party->partyContact()->delete();
                foreach ($request->whatsapp_number as $w) {
                    $party->partyContact()->create([
                        'type' =>  1,
                        'number' => $w
                    ]);
                }
                foreach ($request->office_number as $o) {
                    $party->partyContact()->create([
                        'type' =>  2,
                        'number' => $o
                    ]);
                }
                $party->partyCity()->delete();
                foreach ($request->office_city as $city) {
                    $party->partyCity()->create([
                        'city' => $city,
                    ]);
                }
            } else {
                $party_name = $request->party_name;
                $whatsapp_numbers = $request->whatsapp_number ?? [];
                $contact_numbers = $request->contact_number ?? [];

                $errorMessage = '';

                foreach (array_merge($whatsapp_numbers, $contact_numbers) as $number) {
                    $checkUnique = MstParty::where('party_name', $party_name)
                        ->whereHas('partyContact', function ($query) use ($number) {
                            $query->where('number', $number);
                        })
                        ->exists();

                    if ($checkUnique) {
                        $errorMessage .= 'A party with contact number(' . $number . ') already exists.<br>';
                    }
                }

                if (!empty($errorMessage)) {
                    \toastr()->error($errorMessage);
                    return redirect()->back();
                }

                $party = MstParty::create([
                    'party_name' => $request->party_name,
                    'father_name' => $request->father_name,
                    'office_address' => $request->office_address,
                    'residence_city' => $request->residence_city,
                    'designation' => $request->designation,
                    'residence_address' => $request->residence_address,
                    'pan_number' => $request->pan_number,
                    'email' => $request->email,
                ]);
                foreach ($request->name as $n) {
                    $party->partyFirm()->create([
                        'firm' => $n
                    ]);
                }
                foreach ($request->whatsapp_number as $w) {
                    $party->partyContact()->create([
                        'type' =>  1,
                        'number' => $w
                    ]);
                }
                foreach ($request->office_number as $o) {
                    $party->partyContact()->create([
                        'type' =>  2,
                        'number' => $o
                    ]);
                }
                foreach ($request->office_city as $city) {
                    $party->partyCity()->create([
                        'city' => $city,
                    ]);
                }
            }

            DB::commit();

            \toastr()->success(ucfirst('party successfully saved'));
            return redirect()->route('admin.master.party.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return $e;
            \toastr()->error('Error occurred while saving party');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $party = MstParty::with('partyFirm', 'partyContact')->find($id);
        return view('admin.master.party.edit', compact('party'));
    }

    public function delete($id)
    {
        $color = MstParty::find($id);
        $color->delete();

        \toastr()->success(ucfirst('party successfully deleted'));
        return redirect()->back();
    }

    public function statusChange($id, $status)
    {
        $party = MstParty::find($id);
        $updateStatus = ($status == 1) ? 0 : 1;
        $message = ($status == 0) ? 'Party activated successfully' : 'Party deactivated successfully';

        $party->update(['status' => $updateStatus]);

        \toastr()->success(ucfirst($message));
        return redirect()->back();
    }

    public function view($id)
    {
        $party = MstParty::with('partyFirm', 'partyContact', 'partyCity')->find($id);
        return view('admin.master.party.show', compact('party'));
    }
}
