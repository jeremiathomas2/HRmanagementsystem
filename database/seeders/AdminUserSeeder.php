<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update a company for the admin user
        $company = Company::updateOrCreate(
            ['registration_number' => 'HR-DEMO-2024'],
            [
                'name' => 'Tanzania HR System Demo',
                'tax_identification_number' => 'TAX-DEMO-2024',
                'sector' => 'technology',
                'risk_level' => 'low',
                'address' => 'Demo Address',
                'city' => 'Dar es Salaam',
                'region' => 'Dar es Salaam',
                'postal_code' => '12345',
                'phone' => '+255 123 456 789',
                'email' => 'admin@test.com',
                'website' => 'http://demo.tanzania-hr.com',
                'union_status' => 'non_unionized',
                'employee_count' => 1,
                'registration_date' => now(),
                'is_active' => true,
            ]
        );

        // Create roles if they don't exist
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'super_admin'],
            [
                'display_name' => 'Super Admin',
                'description' => 'System administrator with full access',
                'role_type' => 'super_admin',
                'company_id' => $company->id,
                'hierarchy_level' => 100,
                'is_system_role' => true,
                'is_active' => true,
            ]
        );

        // Create or update the admin user
        $user = User::updateOrCreate(
            ['username' => 'admin@test.com'],
            [
                'name' => 'System Administrator',
                'email' => 'admin@test.com',
                'password' => Hash::make('admin@123'),
                'email_verified_at' => now(),
            ]
        );

        // Assign the role to the user if not already assigned
        if (!$user->roles()->where('role_id', $superAdminRole->id)->exists()) {
            $user->roles()->attach($superAdminRole->id, [
                'company_id' => $company->id,
                'assigned_at' => now(),
                'is_active' => true,
            ]);
        }

        echo "Admin user created successfully!\n";
        echo "Username: admin@test.com\n";
        echo "Password: admin@123\n";
    }
}
