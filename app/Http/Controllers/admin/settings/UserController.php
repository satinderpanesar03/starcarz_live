<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Models\AdminLogin;
use App\Models\MstExecutive;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::guard('admin')->user()->role_id != Role::ADMINISTATOR) {
            $users = AdminLogin::where('id', '!=', Role::ADMINISTATOR)->paginate($request->limit ? $request->limit : 10);
        } else {
            $users = AdminLogin::paginate($request->limit ? $request->limit : 10);
        }

        return view('admin.settings.user.index')->with(['users' => $users]);
    }

    public function create()
    {
        if (Auth::guard('admin')->user()->role_id != Role::ADMINISTATOR) {
            $roles = Role::where('id', '!=', Role::ADMINISTATOR)->pluck('title', 'id');
        } else {
            $roles = Role::pluck('title', 'id');
        }
        $genderOption = AdminLogin::getGenderOption();
        return view('admin.settings.user.create', compact('roles', 'genderOption'));
    }

    public function store(Request $request)
    {
        $rules['email'] = [
            'required',
            'email',
            Rule::unique('users')->ignore($request->id),
        ];
        if ($request->isMethod('post')) {
            $rules['password'] = 'required|confirmed|min:8';
        }

        $validator = Validator::make($request->all(), $rules);

        // $name = Role::where('id', $request->role_id)->pluck('title');

        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {


            DB::beginTransaction();
            $user = $request->isMethod('post') ? new AdminLogin() : AdminLogin::findOrFail($request->id); // Create or update operation

            $user->name =  $request->input('name');
            $user->email = $request->input('email');
            $user->address = $request->input('address');
            $user->gender = $request->input('gender');
            $user->contact_number = $request->input('contact_number');
            $user->role_id = $request->role_id[0];
            $user->roles = implode(',',$request->role_id);
            if ($request->has('password') && !empty($request->password)) {
                $user->password = Hash::make($request->input('password'));
            }
            $user->save();

            foreach(explode(',',$user->roles) as $role){
                if($role == 4 || $role == 5 || $role == 7){
                    MstExecutive::create([
                        'name' => $user->name,
                        'admin_login_id' => $user->id,
                    ]);
                }
            }

            DB::commit();

            \toastr()->success('User successfully saved');
            return redirect()->route('admin.setting.user.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving user' . $e->getMessage());
            return redirect()->back();
        }
    }


    public function show($id)
    {
        $user = AdminLogin::findOrFail($id);
        $roles = Role::pluck('title', 'id'); //->pluck('id','title')->toArray()
        $genderOption = AdminLogin::getGenderOption();

        return view('admin.settings.user.create', compact('user', 'roles', 'genderOption'));
    }


    public function delete($id)
    {
        $user = AdminLogin::find($id);

        $user->delete();
        \toastr()->success(ucfirst('User successfully deleted'));
        return back();
    }

    public function view($id)
    {
        $user = AdminLogin::findOrFail($id);
        return view('admin.settings.user.show', compact('user'));
    }

    public function grantAccess(Request $request, $id){
        $user = AdminLogin::findOrFail($id);

        $access = ($request->all_access == 'on') ? 1 : null;
        $user->update(['all_access' => $access]);

        $access ? \toastr()->success(ucfirst('User access granted')) : \toastr()->success(ucfirst('User access revoked'));
        return back();

    }


}
