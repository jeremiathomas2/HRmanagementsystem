<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SimpleUserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@hrsystem.co.tz',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create demo users for each company
        $companies = DB::table('companies')->get();
        
        foreach ($companies as $company) {
            // HR Manager
            User::create([
                'name' => "HR Manager - {$company->name}",
                'email' => "hr.manager@" . strtolower(str_replace(' ', '', $company->name)) . ".co.tz",
                'username' => 'hr.manager.' . strtolower(str_replace(' ', '', $company->name)),
                'password' => Hash::make('hrmanager123'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Employee user
            User::create([
                'name' => "Employee - {$company->name}",
                'email' => "employee@" . strtolower(str_replace(' ', '', $company->name)) . ".co.tz",
                'username' => 'employee.' . strtolower(str_replace(' ', '', $company->name)),
                'password' => Hash::make('employee123'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create external auditor
        User::create([
            'name' => 'External Auditor',
            'email' => 'auditor@external.co.tz',
            'username' => 'auditor',
            'password' => Hash::make('auditor123'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
