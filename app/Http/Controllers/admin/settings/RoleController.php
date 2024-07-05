<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleAndPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::paginate($request->limit ? $request->limit : 10);
        return view('admin.settings.role.index')->with(['roles' => $roles]);
    }

    public function create()
    {
        $permissions = Permission::orderBy('permissions')->pluck('permissions', 'id');
        return view('admin.settings.role.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => [
                'required',
                'string',
                Rule::unique('roles')->ignore($request->role_id),
            ],
            'permissions' => 'required|array',
        ]);
        if ($validator->fails()) {
            \toastr()->error($validator->errors()->first());
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            DB::beginTransaction();

            if ($request->role_id) {
                RoleAndPermission::where('role_id', $request->role_id)->delete();
                foreach ($request->permissions as $permission) {
                    RoleAndPermission::updateOrCreate(
                        [
                            'role_id' => $request->role_id,
                            'permission_id' => $permission
                        ]
                    );
                }
            } else {
                $role = Role::create(['title' => $request->title]);
                if ($role) {
                    foreach ($request->permissions as $permission) {
                        RoleAndPermission::create([
                            'role_id' => $role->id,
                            'permission_id' => $permission
                        ]);
                    }
                }
            }

            DB::commit();

            \toastr()->success(ucfirst('role successfully saved'));
            return redirect()->route('admin.setting.role.index');
        } catch (\Exception $e) {
            DB::rollBack();
            \toastr()->error('Error occurred while saving role');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        $permissions = Permission::get();
        $grouped = $permissions->groupBy('module');
        $role = Role::with('rolePermission')->find($id);
        $permissionIds = $role->rolePermission->pluck('permission_id')->toArray();

        return view('admin.settings.role.create', compact('grouped', 'role','id','permissionIds'));
    }

    public function delete($id)
    {
        $role = Role::with('users')->find($id);
        if ($role->users->count() > 0) {
            \toastr()->error(ucfirst('Role is assigned with users.'));
            return back();
        }
        $role->delete();
        \toastr()->success(ucfirst('Role successfully deleted'));
        return back();
    }
}
