<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleAndPermission;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsurePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $roles = Role::select('id')->get();
        foreach($roles as $role){
            if(Auth::guard('admin')->user()->role_id == $role->id){
                $permission = Permission::where('permissions', $permission)->first();
                // dd($permission);
                if(!$permission){
                    \toastr()->error("You don't have required permission to perform this action.");
                    return back();
                }

                $userRolePermission = RoleAndPermission::where([
                    'role_id' => Auth::guard('admin')->user()->role_id,
                    'permission_id' => $permission->id
                ])->first();
                
                if ($userRolePermission) {
                    return $next($request); 
                } else {
                    \toastr()->error("You don't have required permission to perform this action.");
                    return back();
                } 
            }
        
        }

        // return $next($request); 


    }
}
