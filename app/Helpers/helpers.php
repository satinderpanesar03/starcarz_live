<?php

use App\Models\Role;
use App\Models\RoleAndPermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

function calculateGst($amount, $percentage){

    $gstAmount = ($amount * $percentage) / 100;
    $totalAmount = $amount + $gstAmount;

    return $totalAmount;
}

function allAccess(){
    if(Auth::guard('admin')->user()->all_access == 1 || in_array(\App\Models\AdminLogin::ADMIN,explode(',',Auth::guard('admin')->user()->roles))){
        return [
            'status' => true,
            'id' => null
        ];
    }
    $executive = DB::table('mst_executives')->where('admin_login_id', Auth::guard('admin')->id())->first();

    return [
        'status' => false,
        'id' => $executive->id
    ];
}
