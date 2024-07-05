<?php

namespace Database\Seeders;

use App\Models\AdminLogin;
use App\Models\Permission;
use App\Models\RoleAndPermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminLogin::truncate();
        $admin = AdminLogin::create([
            'name' => 'webchilli',
            'role_id' => 1,
            'email' => 'admin@starcarz.com',
            'password' => Hash::make('Admin@123'),
        ]);

        
    }
}
