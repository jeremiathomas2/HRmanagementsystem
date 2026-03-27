<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create HR-ADMIN Super Admin
        $superAdmin = User::create([
            'name' => 'HR-ADMIN Super User',
            'email' => 'admin@hrsystem.co.tz',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'company_id' => 1, // HR Management System
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assign super admin role
        DB::table('role_user')->insert([
            'user_id' => $superAdmin->id,
            'role_id' => 1, // Assuming Super Admin role has ID 1
        ]);

        // Create demo users for each company
        $companies = DB::table('companies')->get();
        
        foreach ($companies as $company) {
            // HR Manager for each company
            $hrManager = User::create([
                'name' => "HR Manager - {$company->short_name}",
                'email' => "hr.manager@{$company->short_name}.co.tz",
                'password' => Hash::make('hrmanager123'),
                'email_verified_at' => now(),
                'company_id' => $company->id,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('role_user')->insert([
                'user_id' => $hrManager->id,
                'role_id' => 2, // Assuming HR Manager role has ID 2
            ]);

            // Lead HR-ADMIN for large companies
            if (in_array($company->id, [2, 3, 4, 5, 9, 11])) {
                $leadHrAdmin = User::create([
                    'name' => "Lead HR-ADMIN - {$company->short_name}",
                    'email' => "lead.hradmin@{$company->short_name}.co.tz",
                    'password' => Hash::make('leadadmin123'),
                    'email_verified_at' => now(),
                    'company_id' => $company->id,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('role_user')->insert([
                    'user_id' => $leadHrAdmin->id,
                    'role_id' => 3, // Assuming Lead HR-ADMIN role has ID 3
                ]);
            }

            // Regular HR Officer
            $hrOfficer = User::create([
                'name' => "HR Officer - {$company->short_name}",
                'email' => "hr.officer@{$company->short_name}.co.tz",
                'password' => Hash::make('hrofficer123'),
                'email_verified_at' => now(),
                'company_id' => $company->id,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('role_user')->insert([
                'user_id' => $hrOfficer->id,
                'role_id' => 4, // Assuming HR Officer role has ID 4
            ]);

            // Payroll Officer
            $payrollOfficer = User::create([
                'name' => "Payroll Officer - {$company->short_name}",
                'email' => "payroll@{$company->short_name}.co.tz",
                'password' => Hash::make('payroll123'),
                'email_verified_at' => now(),
                'company_id' => $company->id,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('role_user')->insert([
                'user_id' => $payrollOfficer->id,
                'role_id' => 5, // Assuming Payroll Officer role has ID 5
            ]);

            // Line Manager
            $lineManager = User::create([
                'name' => "Line Manager - {$company->short_name}",
                'email' => "manager@{$company->short_name}.co.tz",
                'password' => Hash::make('manager123'),
                'email_verified_at' => now(),
                'company_id' => $company->id,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('role_user')->insert([
                'user_id' => $lineManager->id,
                'role_id' => 6, // Assuming Line Manager role has ID 6
            ]);

            // Employee self-service user
            $employee = User::create([
                'name' => "Employee User - {$company->short_name}",
                'email' => "employee@{$company->short_name}.co.tz",
                'password' => Hash::make('employee123'),
                'email_verified_at' => now(),
                'company_id' => $company->id,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('role_user')->insert([
                'user_id' => $employee->id,
                'role_id' => 7, // Assuming Employee role has ID 7
            ]);
        }

        // Create External Auditor user
        $auditor = User::create([
            'name' => 'External Auditor',
            'email' => 'auditor@external.co.tz',
            'password' => Hash::make('auditor123'),
            'email_verified_at' => now(),
            'company_id' => null, // External auditor has no company
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('role_user')->insert([
            'user_id' => $auditor->id,
            'role_id' => 8, // Assuming External Auditor role has ID 8
        ]);
    }
}
