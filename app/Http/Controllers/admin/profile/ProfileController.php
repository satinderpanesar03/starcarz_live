<?php

namespace App\Http\Controllers\admin\profile;

use App\Http\Controllers\Controller;
use App\Models\AdminLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileController extends Controller
{
    public function edit()
    {
        $id = Auth::guard('admin')->user()->id;
        $user = AdminLogin::where('id', $id)->first();

        return view('admin.profile.edit', compact('user'));
    }

    public function store(Request $request)
    {
        $id = Auth::guard('admin')->user()->id;
        $rules = [
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'email|unique:users,email,' . $id . ',id'
        ];
    
        if ($request->filled('new_password')) {
            $rules['password'] = 'min:8|confirmed';
            $rules['password_confirmation'] = 'min:8';
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = AdminLogin::find($id);

        try {
            DB::beginTransaction();

            if ($request->email != $user->email) {
                $user->email = $request->email;
            }

            if ($request->filled('new_password')) {
                $user->password = Hash::make($request->new_password);
            }
            if ($request->hasFile('profile_image')) {
                // Delete old profile image
                Storage::delete('public/' . $user->profile_image);
                $uploadedFile = $request->file('profile_image');
                $manager = new ImageManager(new Driver());
                $filename = time() . '_' . $uploadedFile->getClientOriginalName();
                $image = $manager->read($uploadedFile);
                $image = $image->resize(300, 200);
                $directory = 'public/profile_images/';

                if (!Storage::exists($directory)) {
                    Storage::makeDirectory($directory, 0777, true);
                }

                $image->toJpeg()->save(storage_path('app/' . $directory . $filename));

                // Assign file path to profile_image attribute
                $user->profile_image = 'profile_images/' . $filename;
            }
            $user->save();

            DB::commit();

            \toastr()->success(ucfirst('Profile Updated successfully saved'));
            return redirect()->route('admin.dashboard.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving Sale' . $e->getMessage());
            return redirect()->back();
        }
    }
}
