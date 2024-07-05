<?php

use App\Models\Role;
use App\Models\RoleAndPermission;
use Illuminate\Support\Facades\Auth;

// function ensureModule($permission){
//     $count = RoleAndPermission::where('role_id', Auth::guard('admin')->user()->role_id)
//     ->whereHas('permission', function ($query) use ($permission) {
//         $query->where('module', $permission);
//     })
//     ->exists();

//     return $count;
// }

function ensureModule($permission){
    $roleIds = explode(',', Auth::guard('admin')->user()->roles);

    $count = RoleAndPermission::whereIn('role_id', $roleIds)
        ->whereHas('permission', function ($query) use ($permission) {
            $query->where('module', $permission);
        })
        ->exists();

    return $count;
}

function showEntries(){
    return [10, 25, 75, 100];
}
