<?php

namespace App\Http\Controllers\admin\settings;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\RoleAndPermission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $permission = Permission::paginate($request->limit ? $request->limit : 10);

        return view('admin.settings.permission.index')->with(['permissions' => $permission]);
    }

    public function updatePermission(Request $request){
        if($request->status == 1){
            RoleAndPermission::create([
                'role_id' => $request->roleId,
                'permission_id' => $request->permissionId,
            ]);
            return response()->json(['message' => ucfirst('status successfully updated')]);
        }else{
            RoleAndPermission::where([
                'role_id' => $request->roleId,
                'permission_id' => $request->permissionId,
            ])->delete();
            return response()->json(['message' => ucfirst('status successfully removed')]);
        }
        
    }
}
