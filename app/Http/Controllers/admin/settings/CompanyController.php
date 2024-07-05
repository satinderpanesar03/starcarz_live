<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function create()
    {
        $company = Company::first() ?? [];
        return view('admin.settings.company.create', ['company' => $company]);
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:companies,email,' . $request->id,
            // 'phone_number' => 'required|string|max:15',
            'gst_number' => 'required|string|max:20',
            // 'website' => 'required|url|max:255',
            'address' => 'required|string|max:500',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'ifsc_code' => 'required|string|max:15',
            'account_number' => 'required|string|max:20',
            'term_condition' => 'required|string',
            'logo' => 'sometimes|file|mimes:jpg,jpeg,png|max:2048',
        ]);
        $input = $request->all();
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $storagePath = 'public/logos/';

            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs($storagePath, $filename);
            $input['logo'] = 'logos/' . $filename;
        }
        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();
            if ($request->id) {
                $company = Company::findOrFail($request->id);
                $company->update($input);
            } else {
                $company = Company::create($input);
            }

            DB::commit();

            \toastr()->success(ucfirst('Company saved successfully'));
            return redirect()->route('admin.dashboard.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving company');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $company = Company::find($id);

        return view('admin.settings.company.create', compact('company'));
    }
}
