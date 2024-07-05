<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use App\Jobs\AdminPasswordResetJob;
use App\Models\AdminLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgetPasswordController extends Controller
{
    public function forgetPasswordForm(){
        return view('admin.auth.forget_password');
    }

    public function forgetPassword(Request $request){
        $user = AdminLogin::where('email', $request->email)->first();

        if(!$user) {
            \toastr()->error(ucfirst('email does not exist'));
            return redirect()->back();
        }

        $user->update(['reset_link' => Str::random(128)]);

        $data = [
            'email' => $user->email,
            'link' => route('admin.reset.password', $user->reset_link),
        ];
        AdminPasswordResetJob::dispatch($data);

        \toastr()->success(ucfirst('reset password link sent to your registered email address'));
        return redirect()->route('admin.login');

    }

    public function resetPasswordForm($link){
        $link = AdminLogin::where('reset_link', $link)->first();
        if(!$link){
            return response()->json('invalid reset link');
        }
        return view('admin.auth.reset_password')->with(['link' => $link->reset_link]);
    }

    public function resetPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ],[
            'confirm_password.same' => 'Password and Confirm password did not matched'
        ]);

        if($validator->fails()){
            \toastr()->error(ucfirst($validator->errors()->first()));
            return redirect()->back();
        }

        $user = AdminLogin::where('reset_link', $request->link)->first();

        if(Hash::check($request->password, $user->password)){
            \toastr()->error(ucfirst('new password cannot be old password'));
            return redirect()->back();
        }

        $user->update(['password' => Hash::make($request->password), 'reset_link' => null]);
        \toastr()->success(ucfirst('password successfully changed'));
        return redirect()->route('admin.login');

    }

}
