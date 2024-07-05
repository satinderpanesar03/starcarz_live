<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Admin',
            'Sales Manager',
            'Loans Manager',
            'Showroom Executive Sales',
            'Showroom Executive Purchase',
            'Evaluator',
            'Loans Executive',
            'Backend Car Loans',
            'Backend Mortgage',
            'Backend Insurance-1',
            'Backend Insurance-2',
            'Backend Showroom',
        ];
    Role::truncate();
        foreach ($data as $i){
            Role::create(['title' => $i]);
        }

    }
}
