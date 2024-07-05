<?php

namespace App\Http\Controllers\admin\auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yoeunes\Toastr\Toastr;


class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function loginForm(){
        $company = DB::table('companies')->first();
        return view('admin.auth.login', compact('company'));
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:admin_logins',
            'password' => 'required',
        ], [
            'email.exists' => 'Email does not exist'
        ]);

        if($validator->fails()){
            \toastr()->error($validator->errors()->first());
            return redirect()->route('admin.login');
        }

        $credentials = $request->only('email', 'password');
        if (!Auth::guard('admin')->attempt($credentials)) {
            \toastr()->error(ucfirst('invalid password'));

            return redirect()->route('admin.login');
        }

        Session::put('user', Auth::guard('admin')->user());

        \toastr()->success(ucfirst('login successfully'));
        return redirect()->intended('admin/dashboard');
    }

    public function logout(){
        Session::flush();
        Auth::logout();

        \toastr()->success(ucfirst('logout successfully'));

        return redirect()->route('admin.login');
    }
}
