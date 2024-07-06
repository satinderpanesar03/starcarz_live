<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\RoleAndPermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = Permission::permissions;

        Permission::truncate();


        foreach ($permissions as $module => $modulePermissions) {
            foreach ($modulePermissions as $permission) {
                Permission::create([
                    'module' => $module,
                    'permissions' => $permission
                ]);
            }
        }

        // $permissions = Permission::select('id')->get();
        // RoleAndPermission::truncate();
        // foreach($permissions as $permission){
        //     RoleAndPermission::create([
        //         'role_id' => 1,
        //         'permission_id' => $permission->id
        //     ]);
        // }

    }
}
