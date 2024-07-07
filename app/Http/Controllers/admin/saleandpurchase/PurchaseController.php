<?php

namespace App\Http\Controllers\admin\saleandpurchase;

use App\Exports\PurchaseExport;
use App\Http\Controllers\Controller;
use App\Models\AdminLogin;
use App\Models\Image;
use App\Models\MstBrandType;
use App\Models\MstColor;
use App\Models\MstExecutive;
use App\Models\MstInsurance;
use App\Models\MstModel;
use App\Models\MstParty;
use App\Models\PartyCity;
use App\Models\PartyContact;
use App\Models\PendingDocument;
use App\Models\PendingDocumnet;
use App\Models\Purchase;
use App\Models\PurchaseOrder;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\WhatsappHelper;
use App\Models\PurchasedImage;
use Exception;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        $list = true;
        if ($request->has('clear_search')) {
            return redirect()->route('admin.purchase.purchase.index');
        } else {
            $executiveFilter = $request->input('executiveFilter');
            $modelFilter = $request->input('modelFilter');
            $partyFilter = $request->input('partyFilter');
            $statusFilter = $request->input('statusFilter');
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            // Start with the base query
            $query = Purchase::query();

            if ($executiveFilter) {
                $query->where('mst_executive_id', $executiveFilter);
            }
            if ($modelFilter) {
                $query->where('mst_model_id', $modelFilter);
            }
            if ($partyFilter) {
                $query->where('mst_party_id', $partyFilter);
            }
            if ($statusFilter) {
                $query->where('status', $statusFilter);
            }
            if ($fromDate) {
                $query->whereDate('evaluation_date', '>=', $fromDate);
            }
            if ($toDate) {
                $query->whereDate('evaluation_date', '<=', $toDate);
            }


            // Fetch filtered results
            if (Auth::guard('admin')->user()->role_id == AdminLogin::ADMIN) {
                $purchases = $query->with('executiveName:id,name,email')->orderBy('id', 'desc')->paginate($request->limit ?: 10);
            } else {
                // Add user_executive_id condition for non-admin users
                $purchases = $query->with('executiveName:id,name,email')->where('user_executive_id', Auth::guard('admin')->id())
                    ->orderBy('id', 'desc')
                    ->paginate($request->limit ?: 10);
            }

            // $role = Role::where('title', ucfirst('executive'))->first();
            // if ($role) {
            //     $executives = AdminLogin::where('role_id', $role->id)->pluck('name', 'id');
            // } else {
            //     $executives = collect();
            // }
            $executives = MstExecutive::pluck('name', 'id');
            $models = MstModel::pluck('model', 'id');
            $party = MstParty::pluck('party_name', 'id');
            $status = Purchase::getStatus();
        }

        return view('admin.sale-purchase.purchase.index', compact('purchases', 'executives', 'models', 'party', 'status', 'list'));
    }

    public function create()
    {
        $type = true;
        $parties = MstParty::with('partyContact')->get()->map(function ($party) {
            $contactNumbers = $party->partyContact->pluck('number')->implode(', ');
            return [
                'id' => $party->id,
                'name' => $party->party_name,
                'contacts' => $contactNumbers
            ];
        });
        $colors = MstColor::pluck('color', 'id');
        $brandTypes = MstBrandType::pluck('type', 'id');
        $model = MstModel::pluck('model', 'id');
        $fuelType = Purchase::getFuelType();
        $shapeType = Purchase::getShapeType();
        $serviceBooklet = Purchase::getServiceBooklet();
        $enquiryType = Purchase::getEnquiryType();
        $willingType = Purchase::getWillingType();
        $rcType = Purchase::getRcType();
        $hypothecationType = Purchase::getHypothecationType();
        $status = Purchase::getStatus();
        $company = MstInsurance::pluck('name', 'id');
        $role = Role::where('title', ucfirst('executive'))->first();
        $executives = MstExecutive::pluck('name', 'id');
        $adminCheck = (Auth::guard('admin')->user()->role_id == AdminLogin::ADMIN) ? true : false;

        return view('admin.sale-purchase.purchase.create', compact('executives', 'parties', 'colors', 'brandTypes', 'model', 'fuelType', 'shapeType', 'serviceBooklet', 'enquiryType', 'willingType', 'rcType', 'hypothecationType', 'status', 'type', 'adminCheck', 'company'));
    }

    public function createOrder(Request $request)
    {
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
            // ->whereNotIn('id', function ($query) {
            //     $query->select('purchase_id')
            //         ->from('purchase_orders');
            // })
            ->get();
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        $role = Role::where('title', ucfirst('executive'))->first();
        $executives = MstExecutive::pluck('name', 'id');
        $adminCheck = (Auth::guard('admin')->user()->role_id == AdminLogin::ADMIN) ? true : false;
        $status = session('status');

        return view('admin.sale-purchase.purchase.create-order', compact('executives', 'parties', 'vehicles', 'regNumbers', 'company', 'rcType', 'type', 'hypothecationType', 'adminCheck', 'status'));
    }

    public function storeOrder(Request $request)
    {
        $input = $request->all();

        if ($request->hasFile('seller_id')) {
            if ($request->id) {
                $oldPurchase = PurchaseOrder::find($request->id);
                Storage::delete('public/images/' . $oldPurchase->seller_id);
            }

            $uploadedFile = $request->file('seller_id');

            $filename = time() . '_' . $uploadedFile->getClientOriginalName();
            $uploadedFile->storeAs('public/images', $filename);
            $input['seller_id'] = 'images/' . $filename;
        }
        if ($request->hasFile('image')) {
            if ($request->id) {
                $oldPurchase = PurchaseOrder::find($request->id);
                Storage::delete('public/images/' . $oldPurchase->image);
            }
            $uploadedFile = $request->file('image');

            $filename = time() . '_' . $uploadedFile->getClientOriginalName();
            $uploadedFile->storeAs('public/images', $filename);
            $input['image'] = 'images/' . $filename;
        }
        if ($request->hasFile('pancard_image')) {
            if ($request->id) {
                $oldPurchase = PurchaseOrder::find($request->id);
                Storage::delete('public/images/' . $oldPurchase->pancard_image);
            }
            $uploadedFile = $request->file('pancard_image');

            $filename = time() . '_' . $uploadedFile->getClientOriginalName();
            $uploadedFile->storeAs('public/images', $filename);
            $input['pancard_image'] = 'images/' . $filename;
        }
        $rfs = $request->input('rfs', 'false');
        try {
            DB::beginTransaction();
            if ($request->id) {
                $purchase = PurchaseOrder::find($request->id);
                $input['reg_date'] = $request->reg_date;
                $input['insurance_due_date'] = $request->insurance_due_date;
                $input['status'] = $request->mode;
                $input['mst_party_id'] = $request->party_id;
                $input['mst_purchase_id'] = empty($request->purchase_id) ? $purchase->purchase_id : $request->purchase_id;
                $purchase->update($input);
            } else {
                $input['reg_date'] = $request->reg_date;
                $input['insurance_due_date'] = $request->insurance_due_date;
                $input['status'] = $request->mode;
                $input['mst_party_id'] = $request->party_id;
                $input['mst_purchase_id'] = $request->purchase_id;
                $purchase = PurchaseOrder::create($input);
            }

            DB::commit();
            if ($rfs) {
                \toastr()->success(ucfirst('Purchace updated successfully saved'));
                return back();
            } else {
                \toastr()->success(ucfirst('Purchace Order successfully saved'));
                return redirect()->route('admin.purchase.purchase.orders');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving purchase order' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'reg_number' => 'nullable',
            'mst_executive_id' => 'nullable',
            // 'evaluation_date' => 'required',
            'mst_party_id' => 'nullable',
            // 'contact_person_name' => 'required',
            // 'contact_number' => 'required',
            // 'address' => 'required',
            // 'city' => 'required',
            // 'email' => 'required|email',
            'registered_owner' => 'nullable',
            'mst_brand_type_id' => 'nullable',
            'mst_model_id' => 'nullable',
            'manufacturing_year' => 'required',
            'registration_year' => 'nullable',
            'kilometer' => 'nullable',
            'expectation' => 'nullable',
            'mst_color_id' => 'nullable',
            'owners' => 'nullable',
            'fuel_type' => 'nullable',
            'shape_type' => 'nullable',
            'engine_number' => 'nullable',
            'chasis_number' => 'nullable',
            'service_booklet' => 'nullable',
            'date_of_purchase' => 'nullable',
            'enquiry_type' => 'nullable',
            'willing_insurance' => 'nullable',
            'registration_cerificate' => 'nullable',
            'hypothecation' => 'nullable',
            'icompany_id' => 'nullable',
            'policy_number' => 'nullable',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $input = $request->all();

        // $input['evaluation_date'] = $this->datetoTimeConversion($request->evaluation_date);
        $input['evaluation_date'] = $request->evaluation_date;
        $input['date_of_purchase'] = $request->date_of_purchase;
        $input['mst_executive_id'] = $request->mst_executive_id;
        $input['reg_date'] = $request->reg_date;
        $input['policy_number'] = !empty($request->policy) ? $request->policy : $request->policy_number;
        $input['icompany_id'] = !empty($request->company_id) ? $request->company_id : $request->icompany_id;
        $input['insurance_due_date'] = $request->insurance_due_date;
        $input['followup_date'] = ($request->status == 3 || $request->status == 2 || $request->status == 1) ? null : $request->followup_date;
        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('image')) {
            if ($request->id) {
                $oldPurchase = Purchase::find($request->id);
                Storage::delete('public/images/' . $oldPurchase->image);
            }

            $manager = new ImageManager(new Driver());
            $uploadedFile = $request->file('image');
            $filename = time() . '_' . $uploadedFile->getClientOriginalName();
            $image = $manager->read($uploadedFile);
            $image = $image->resize(300, 200);
            $image->toJpeg()->save(storage_path('app/public/images/' . $filename));
            $input['image'] = 'images/' . $filename;
        }

        try {
            // DB::beginTransaction();

            if ($request->id) {
                $purchase = Purchase::find($request->id);
                $success = $purchase->update($input);
                if ($success && in_array($purchase->status, [6, 7])) {
                    return redirect()->route('admin.purchase.purchase.create-order')->with(['status' => $purchase->status]);
                }
            } else {
                $nextValue = $this->generateNextValue();
                $input['enquiry_id'] = $nextValue;
                $input['mst_color_id'] = 1;
                $purchase = Purchase::create($input);
            }

            try {
                $number = WhatsappHelper::checkWhatsappNumber($request->mst_party_id);
                // if ($number) {
                //     dd($number);
                // }
            } catch (Exception $e) {
                //
            }


            // if ($request->hasFile('images')) {
            //     foreach ($request->file('images') as $imageFile) {
            //         $filename = time() . '_' . $imageFile->getClientOriginalName();
            //         $image = $manager->read($imageFile);
            //         $image = $image->resize(300, 200);
            //         $image->toJpeg()->save(storage_path('app/public/images/' . $filename));
            //         $imagePath = 'images/' . $filename;
            //         $image = new Image([
            //             'filename' => $filename,
            //             'filepath' => $imagePath,
            //             'purchase_id' => $purchase->id
            //         ]);
            //         $image->save();
            //     }
            // }

            // DB::commit();

            \toastr()->success(ucfirst('Purchace Enquiry successfully saved'));
            return redirect()->route('admin.purchase.purchase.index');
        } catch (\Exception $e) {
            // DB::rollBack();
            \toastr()->error('Error occurred while saving purchase enquiry' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function datetoTimeConversion($date)
    {
        $dateTime = Carbon::createFromFormat('Y-m-d', $date)
            ->now();
        return $dateTime;
    }

    public function show(Request $request, $id)
    {
        $type = false;
        $purchase = Purchase::find($id);
        $parties = MstParty::with('partyContact')->get()->map(function ($party) {
            $contactNumbers = $party->partyContact->pluck('number')->implode(', ');
            return [
                'id' => $party->id,
                'name' => $party->party_name,
                'contacts' => $contactNumbers
            ];
        });
        $colors = MstColor::pluck('color', 'id');
        $brandTypes = MstBrandType::pluck('type', 'id');
        $model = MstModel::pluck('model', 'id');
        $fuelType = Purchase::getFuelType();
        $shapeType = Purchase::getShapeType();
        $serviceBooklet = Purchase::getServiceBooklet();
        $enquiryType = Purchase::getEnquiryType();
        $willingType = Purchase::getWillingType();
        $rcType = Purchase::getRcType();
        $hypothecationType = Purchase::getHypothecationType();
        $status = Purchase::getStatus($purchase->status);
        $company = MstInsurance::pluck('name', 'id');
        $role = Role::where('title', ucfirst('executive'))->first();
        $executives = MstExecutive::pluck('name', 'id');
        $adminCheck = (Auth::guard('admin')->user()->role_id == AdminLogin::ADMIN) ? true : false;

        return view('admin.sale-purchase.purchase.create', compact('purchase', 'executives', 'parties', 'colors', 'brandTypes', 'model', 'fuelType', 'shapeType', 'serviceBooklet', 'enquiryType', 'willingType', 'rcType', 'hypothecationType', 'status', 'type', 'adminCheck', 'company'));
    }

    public function delete($id)
    {
        $color = Purchase::find($id);
        $color->delete();

        \toastr()->success(ucfirst('Purchace Enquiry successfully deleted'));
        return redirect()->back();
    }

    public function updateData(Request $request)
    {
        $data = Purchase::findOrFail($request->id);
        $data->expected_price = ($request->expected_price) ? $request->expected_price : $data->expected_price;
        $data->valuation = ($request->valuation) ? $request->valuation : $data->valuation;
        $data->remarks = ($request->remarks) ? $request->remarks : $data->remarks;

        $data->save();

        return response()->json(['message' => 'Data updated successfully']);
    }

    public function view($id)
    {
        $type = false;
        $purchase = Purchase::findOrFail($id);
        $party = MstParty::pluck('party_name', 'id');
        $colors = MstColor::pluck('color', 'id');
        $brandTypes = MstBrandType::pluck('type', 'id');
        $model = MstModel::pluck('model', 'id');
        $fuelType = Purchase::getFuelType();
        $shapeType = Purchase::getShapeType();
        $serviceBooklet = Purchase::getServiceBooklet();
        $enquiryType = Purchase::getEnquiryType();
        $willingType = Purchase::getWillingType();
        $rcType = Purchase::getRcType();
        $hypothecationType = Purchase::getHypothecationType();
        $status = Purchase::getStatus();
        $executives = MstExecutive::pluck('name', 'id');
        $company = MstInsurance::pluck('name', 'id');

        return view('admin.sale-purchase.purchase.show', compact('purchase', 'fuelType', 'shapeType', 'serviceBooklet', 'enquiryType', 'willingType', 'rcType', 'hypothecationType', 'executives', 'status', 'party', 'colors', 'brandTypes', 'type', 'model', 'company'));
    }

    public function getPartyData(Request $request)
    {
        $partyId = $request->input('party_id');

        $party = MstParty::find($partyId);
        $contactNumber = PartyContact::where('mst_party_id', $partyId)->where('type', 2)->first();
        $city = PartyCity::where('mst_party_id', $partyId)->first();
        if ($party) {
            return response()->json([
                'party_name' => $party->party_name,
                'office_number' => !empty($phone[0]) ? $phone[0] : '',
                'office_city' => $party->residence_city,
                'office_address' => $party->office_address,
                'email' => $party->email,
                'residence_city' => ($city) ? $city->city : $party->residence_city,
                'contact_number' => $contactNumber->number ?? null,

            ]);
        } else {
            return response()->json([
                'error' => 'Party not found',
            ], 404);
        }
    }

    public function savePartyData(Request $request)
    {
        $rules = [
            'party_name' => [
                Rule::unique('mst_parties')->ignore($request->id),
            ],
            'whatsapp_number' => [
                'nullable',
                // 'distinct',
                // Rule::unique('party_contacts', 'number')->where(function ($query) use ($request) {
                //     return $query->where('type', 1)->where('mst_party_id', '!=', $request->id);
                // }),
            ],
            'email' => ['email', 'nullable'],
            'residence_city' => 'required',
            'office_number' => [
                'nullable',
                // 'distinct',
                // Rule::unique('party_contacts', 'number')->where(function ($query) use ($request) {
                //     return $query->where('type', 2)->where('mst_party_id', '!=', $request->id);
                // }),
            ],
            'residence_address' => 'required',
            'office_city' => 'nullable',
            'pan_number' => 'nullable',
            'firm_name' => 'nullable',
            'office_address' => 'nullable'
        ];

        $validatedData = $request->validate($rules);
        try {

            $party = new MstParty();
            $party->fill($validatedData);
            $party->save();

            $party->partyContact()->createMany([
                ['number' => $validatedData['whatsapp_number'], 'type' => 1],
                ['number' => $validatedData['office_number'], 'type' => 2]
            ]);

            $party->partyCity()->create([
                'city' => $validatedData['office_city'],
            ]);
            $party->partyFirm()->create([
                'firm' => $validatedData['firm_name'],
            ]);

            return response()->json(['message' => 'Party data saved successfully'], 200);
        } catch (\Exception $e) {
            dd($e);
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                $errors = $e->validator->errors()->all();

                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $errors
                ], 422);
            } else {
                $errorMessage = 'An error occurred while saving party data: ' . $e->getMessage();
                return response()->json(['error' => $errorMessage], 500);
            }
        }
    }

    public function followUp(Request $request)
    {
        $list = false;
        if ($request->has('clear_search')) {
            return redirect()->route('admin.purchase.purchase.index');
        } else {
            $executiveFilter = $request->input('executiveFilter');
            $modelFilter = $request->input('modelFilter');
            $partyFilter = $request->input('partyFilter');
            $statusFilter = $request->input('statusFilter');
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');
            // Start with the base query
            $query = Purchase::query();

            if ($executiveFilter) {
                $query->where('mst_executive_id', $executiveFilter);
            }
            if ($modelFilter) {
                $query->where('mst_model_id', $modelFilter);
            }
            if ($partyFilter) {
                $query->where('mst_party_id', $partyFilter);
            }
            if ($statusFilter) {
                $query->where('status', $statusFilter);
            }
            if ($fromDate) {
                $query->whereDate('evaluation_date', '>=', $fromDate);
            }
            if ($toDate) {
                $query->whereDate('evaluation_date', '<=', $toDate);
            }

            if (Auth::guard('admin')->user()->role_id == AdminLogin::ADMIN) {
                $purchases = $query->with('executiveName:id,name,email')->whereIn('status', [4, 5, 6, 7])->orderBy('id', 'desc')->paginate($request->limit ?: 10);
            } else {
                // Add user_executive_id condition for non-admin users
                $purchases = $query->with('executiveName:id,name,email')->where('user_executive_id', Auth::guard('admin')->id())
                    ->whereIn('status', [4, 5, 6, 7,])
                    ->orderBy('id', 'desc')
                    ->paginate($request->limit ?: 10);
            }

            // $role = Role::where('title', ucfirst('executive'))->first();
            // if ($role) {
            //     $executives = AdminLogin::where('role_id', $role->id)->pluck('name', 'id');
            // } else {
            //     $executives = collect();
            // }
            $executives = MstExecutive::pluck('name', 'id');
            $models = MstModel::pluck('model', 'id');
            $party = MstParty::pluck('party_name', 'id');
            $status = Purchase::getFollowStatus();
        }

        return view('admin.sale-purchase.purchase.followup-index', compact('purchases', 'executives', 'models', 'party', 'status', 'list'));
    }

    public function ordersList(Request $request)
    {
        if ($request->has('clear_search')) {
            return redirect()->route('admin.purchase.purchase.orders');
        } else {
            // Start with the base query
            $query = PurchaseOrder::with('purchase', 'party')
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
                ->ModeSearch($request);

            // Fetch filtered results
            if (Auth::guard('admin')->user()->role_id == AdminLogin::ADMIN) {
                $purchases = $query->orderBy('id', 'desc')->paginate($request->limit ?: 10);
            } else {
                // Add user_executive_id condition for non-admin users
                $purchases = $query->where('user_executive_id', Auth::guard('admin')->id())
                    // ->whereIn('status', [6, 7])
                    ->orderBy('id', 'desc')
                    ->paginate($request->limit ?: 10);
            }

            // $role = Role::where('title', ucfirst('executive'))->first();
            // if ($role) {
            //     $executives = AdminLogin::where('role_id', $role->id)->pluck('name', 'id');
            // } else {
            //     $executives = collect();
            // }
            $executives = MstExecutive::pluck('name', 'id');
            $models = MstModel::pluck('model', 'id');
            $party = MstParty::pluck('party_name', 'id');
            $status = Purchase::getStatus();
            $parties = MstParty::select('id','party_name')->get();
        }

        return view('admin.sale-purchase.purchase.order-index', compact('purchases', 'executives', 'models', 'party', 'status','parties'));
    }

    function generateNextValue()
    {
        // Get the latest record
        $latestRecord = Purchase::latest()->first();

        if ($latestRecord) {
            $numericPart = intval(substr($latestRecord->enquiry_id, 2)) + 1;
        } else {
            $numericPart = 1;
        }

        // Generate the new value
        $nextValue = 'SC' . str_pad($numericPart, 4, '0', STR_PAD_LEFT);

        return $nextValue;
    }

    public function getStatus(Request $request)
    {
        $status = $request->input('mode');

        $vehicles = Purchase::select('id', 'reg_number')->where('status', $status)->get();

        if ($vehicles->isNotEmpty()) {
            $data = [];
            foreach ($vehicles as $vehicle) {
                $data[$vehicle->id] = $vehicle->reg_number;
            }

            return response()->json($data);
        } else {
            return response()->json([
                'error' => 'No vehicles found for the given status',
            ], 404);
        }
    }

    public function getVehicles(Request $request)
    {
        $vehicle = $request->input('vehicle');

        $vehicles = Purchase::with('brand:id,type', 'color:id,color')->where('id', $vehicle)->first();
        if ($vehicles) {
            return [
                'purchase_id' => $vehicles->id,
                'brand' => $vehicles->brand->type ?? '',
                'brand_id' => $vehicles->brand->id ?? '',
                'model' => $vehicles->carModel->model ?? '',
                'color' => $vehicles->color->color ?? '',
                'manufacturing_year' => $vehicles->manufacturing_year,
                'registration_year' => $vehicles->manufacturing_year,
                'kilometer' => $vehicles->kilometer,
                'expectation' => $vehicles->expectation,
                'owners' => $vehicles->owners,
                'fuel_type' => ($vehicles->fuel_type == 1) ? 'Petrol' : 'Diesel',
                'shape_type' => ($vehicles->shape_type == 1) ? 'New' : 'Old',
                'engine_number' => $vehicles->engine_number,
                'chasis_number' => $vehicles->chasis_number,
                'service_booklet' => $vehicles->service_booklet,
                'date_of_purchase' => $vehicles->date_of_purchase,
                'reg_date' => $vehicles->reg_date,
                'insurance_due_date' => $vehicles->insurance_due_date,
                'icompany_id' => $vehicles->icompany_id,
                'policy_number' => $vehicles->policy_number,
                'vehicle_number' => $vehicles->reg_number
            ];
        } else {
            return response()->json([
                'error' => 'No vehicles found for the given status',
            ], 404);
        }
    }

    public function showOrder($id)
    {
        $purchase = PurchaseOrder::with('purchase')->find($id);
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
        if (isset($purchase->id)) {
            $vehicles = $vehicles->orWhere('id', $purchase->purchase_id);
        }

        $vehicles = $vehicles->get();
        $regNumbers = Purchase::whereIn('status', [6, 7])->pluck('enquiry_id', 'id');
        $role = Role::where('title', ucfirst('executive'))->first();
        if ($role) {
            $executives = AdminLogin::where('role_id', $role->id)->get();
        } else {
            $executives = collect();
        }
        $adminCheck = (Auth::guard('admin')->user()->role_id == AdminLogin::ADMIN) ? true : false;
        $status = $purchase->status;
        return view('admin.sale-purchase.purchase.create-order', compact('purchase', 'executives', 'parties', 'vehicles', 'regNumbers', 'company', 'rcType', 'type', 'hypothecationType', 'adminCheck', 'status'));
    }

    public function viewOrder($id)
    {
        $purchase = PurchaseOrder::with('purchase', 'party')->find($id);
        $parties = MstParty::select('id', 'party_name')->get();
        $vehicles = Purchase::select('id', 'reg_number')->whereIn('status', [6, 7])->get();
        $company = MstInsurance::pluck('name', 'id');
        $rcType = Purchase::getRcType();
        $hypothecationType = Purchase::getHypothecationType();
        return view('admin.sale-purchase.purchase.view-order', compact('purchase', 'parties', 'vehicles', 'company', 'rcType', 'hypothecationType'));
    }

    public function showDocument($id)
    {
        $purchase = PurchaseOrder::findOrFail($id);
        $pendingDocument = PendingDocument::where('purchase_order_id', $id)->first();
        return view('admin.sale-purchase.purchase.add-document', compact('pendingDocument', 'purchase'));
    }

    public function storePendingDocument(Request $request)
    {
        try {
            DB::beginTransaction();

            $order_id = $request->input('order_id');

            $pendingDocument = PendingDocument::where('purchase_order_id', $order_id)->first();

            if ($pendingDocument) {
                $pendingDocument->rc = $request->input('rc');
                $pendingDocument->insurance = $request->input('insurance');
                $pendingDocument->delivery_document = $request->input('delivery_document');
                $pendingDocument->key = $request->input('key');
                $pendingDocument->pancard = $request->input('pancard');
                $pendingDocument->aadharcard = $request->input('aadharcard');
                $pendingDocument->photograph = $request->input('photograph');
                $pendingDocument->transfer_set = $request->input('transfer_set');
                $pendingDocument->save();
                $message = 'Pending document updated successfully!';
            } else {
                $pendingDocument = new PendingDocument();
                $pendingDocument->purchase_order_id = $order_id;
                $pendingDocument->rc = $request->input('rc');
                $pendingDocument->insurance = $request->input('insurance');
                $pendingDocument->delivery_document = $request->input('delivery_document');
                $pendingDocument->key = $request->input('key');
                $pendingDocument->pancard = $request->input('pancard');
                $pendingDocument->aadharcard = $request->input('aadharcard');
                $pendingDocument->photograph = $request->input('photograph');
                $pendingDocument->transfer_set = $request->input('transfer_set');
                $pendingDocument->save();
                $message = 'Pending document stored successfully!';
            }

            DB::commit();

            // Flash a success message
            \toastr()->success(ucfirst($message));
            return redirect()->route('admin.purchase.purchase.orders');
        } catch (\Exception $e) {
            // Flash an error message
            \toastr()->error('Error occurred while saving Documents Data: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function viewFollowup($id)
    {
        $type = true;
        $purchase = Purchase::findOrFail($id);
        $party = MstParty::pluck('party_name', 'id');
        $colors = MstColor::pluck('color', 'id');
        $brandTypes = MstBrandType::pluck('type', 'id');
        $model = MstModel::pluck('model', 'id');
        $fuelType = Purchase::getFuelType();
        $shapeType = Purchase::getShapeType();
        $serviceBooklet = Purchase::getServiceBooklet();
        $enquiryType = Purchase::getEnquiryType();
        $willingType = Purchase::getWillingType();
        $rcType = Purchase::getRcType();
        $hypothecationType = Purchase::getHypothecationType();
        $status = Purchase::getStatus();
        $role = Role::where('title', ucfirst('executive'))->first();
        $executives = AdminLogin::where('role_id', $role->id)->get();
        $company = MstInsurance::pluck('name', 'id');

        return view('admin.sale-purchase.purchase.show', compact('purchase', 'fuelType', 'shapeType', 'serviceBooklet', 'enquiryType', 'willingType', 'rcType', 'hypothecationType', 'executives', 'status', 'party', 'colors', 'brandTypes', 'type', 'model', 'company'));
    }

    public function statusChange($id, $state_id)
    {
        $purchase = Purchase::find($id);
        $updateStatus = ($state_id == 1) ? 0 : 1;
        $message = ($state_id == 0) ? 'Purchase activated successfully' : 'Purchase deactivated successfully';

        $purchase->update(['state_id' => $updateStatus]);

        \toastr()->success(ucfirst($message));
        return redirect()->back();
    }

    public function statusChangeOrder($id, $state_id)
    {
        $purchase = PurchaseOrder::find($id);
        $updateStatus = ($state_id == 1) ? 0 : 1;
        $message = ($state_id == 0) ? 'Purchase Order activated successfully' : 'Purchase Order deactivated successfully';

        $purchase->update(['state_id' => $updateStatus]);

        \toastr()->success(ucfirst($message));
        return redirect()->back();
    }

    public function export($start_date = null, $end_date = null, $extension = null)
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
        $filename = 'purchase_enquiry-' . date('d-m-Y') . '.' . $extension;
        return Excel::download(new PurchaseExport($start_date, $end_date), $filename, $exportFormat);
    }

    public function whatapp()
    {
        // WhatsappHelper::sendMessage('hello_world','7888776725');
        $number = WhatsappHelper::checkWhatsappNumber(1);
        if ($number) {
            dd($number);
        }
    }

    public function readySaleIndexOld(Request $request)
    {
        $list = true;

        if ($request->has('clear_search')) {
            return redirect()->route('admin.purchase.purchase.ready-sale-index');
        }

        // Start with the base query
        $purchases = PurchaseOrder::query();

        if ($request->filled('brandFilter') || $request->filled('modelFilter') || $request->filled('vehicleFilter')) {
            $query = PurchaseOrder::query();
            // Apply filters based on form data
            if ($request->filled('brandFilter')) {
                $query->whereHas('purchase', function ($q) use ($request) {
                    $q->where('mst_brand_type_id', $request->brandFilter);
                });
            }

            if ($request->filled('modelFilter')) {
                $query->whereHas('purchase', function ($q) use ($request) {
                    $q->where('mst_model_id', $request->modelFilter);
                });
            }

            if ($request->filled('vehicleFilter')) {
                $query->where('purchase_id', $request->vehicleFilter); // Assuming 'vehicleFilter' contains the purchase ID
            }

            // $query->whereIn('status', [6, 7]);
            $purchases = $query->get();
        }

        // Execute the query


        $models = MstModel::pluck('model', 'id');
        $brands = MstBrandType::pluck('type', 'id');
        $party = MstParty::pluck('party_name', 'id');
        $status = Purchase::getStatus();
        $purchaseIds = PurchaseOrder::pluck('purchase_id')->toArray();
        $vehicles = Purchase::whereIn('id', $purchaseIds)
            ->whereIn('status', [6, 7])
            ->pluck('reg_number', 'id');

        return view('admin.sale-purchase.ready-for-sale.index', compact('purchases', 'models', 'party', 'status', 'list', 'vehicles', 'brands'));
    }
    public function readySaleIndex(Request $request)
    {
        $purchases = Purchase::with('carModel:id,mst_brand_type_id,model','color:id,color','brand:id,type','purchaseOrder:id,purchase_id,price_p1')
        ->whereIn('status', [6,7])
        ->orderBy('id','desc')->get();
        // dd($purchases);

        return view('admin.sale-purchase.ready-for-sale.index', compact('purchases'));
    }

    public function readySaleImages($id){
        $image = PurchasedImage::where('purchase_id', $id)->first();
        return view('admin.sale-purchase.ready-for-sale.images', compact('id','image'));
    }

    public function readySaleImagesStore(Request $request){
        $request->validate([
            'front' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'side' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'back' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'interior' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'tyre' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $updateData = [];

        if ($request->file('front')) {
            $frontPath = $request->file('front')->store('public/purchased');
            $updateData['front'] = basename($frontPath);
        }

        if ($request->file('side')) {
            $sidePath = $request->file('side')->store('public/purchased');
            $updateData['side'] = basename($sidePath);
        }

        if ($request->file('back')) {
            $backPath = $request->file('back')->store('public/purchased');
            $updateData['back'] = basename($backPath);
        }

        if ($request->file('interior')) {
            $interiorPath = $request->file('interior')->store('public/purchased');
            $updateData['interior'] = basename($interiorPath);
        }

        if ($request->file('tyre')) {
            $tyrePath = $request->file('tyre')->store('public/purchased');
            $updateData['tyre'] = basename($tyrePath);
        }

        PurchasedImage::updateOrCreate(
            ['purchase_id' => $request->purchase_id],
            $updateData
        );

        \toastr()->success(ucfirst('Image successfully saved'));
        return redirect()->back();
    }

    public function showReadyForSale(Request $request, $id)
    {
        $type = false;
        $purchase = PurchaseOrder::find($id);
        // $executives = MstExecutive::pluck('name', 'id');
        $parties = MstParty::with('partyContact')->get()->map(function ($party) {
            $contactNumbers = $party->partyContact->pluck('number')->implode(', ');
            return [
                'id' => $party->id,
                'name' => $party->party_name,
                'contacts' => $contactNumbers
            ];
        });
        $colors = MstColor::pluck('color', 'id');
        $brandTypes = MstBrandType::pluck('type', 'id');
        $model = MstModel::pluck('model', 'id');
        $fuelType = Purchase::getFuelType();
        $shapeType = Purchase::getShapeType();
        $serviceBooklet = Purchase::getServiceBooklet();
        $enquiryType = Purchase::getEnquiryType();
        $willingType = Purchase::getWillingType();
        $rcType = Purchase::getRcType();
        $hypothecationType = Purchase::getHypothecationType();
        $status = Purchase::getStatus($purchase->status);
        $company = MstInsurance::pluck('name', 'id');
        $role = Role::where('title', ucfirst('executive'))->first();
        $executives = MstExecutive::pluck('name', 'id');
        $adminCheck = (Auth::guard('admin')->user()->role_id == AdminLogin::ADMIN) ? true : false;

        return view('admin.sale-purchase.ready-for-sale.view', compact('purchase', 'executives', 'parties', 'colors', 'brandTypes', 'model', 'fuelType', 'shapeType', 'serviceBooklet', 'enquiryType', 'willingType', 'rcType', 'hypothecationType', 'status', 'type', 'adminCheck', 'company'));
    }
}
