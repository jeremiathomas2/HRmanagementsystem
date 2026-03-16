<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class CreateTestUsers extends Seeder
{
    public function run(): void
    {
        // Get roles
        $superAdminRole = Role::where('name', 'super_admin')->first();
        $hrAdminRole = Role::where('name', 'hr_admin')->first();
        $leadHrRole = Role::where('name', 'lead_hr_admin')->first();

        // Create Super Admin
        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@tanzaniahr.com',
            'username' => 'superadmin',
            'password' => bcrypt('superadmin123'),
        ]);
        if ($superAdminRole) {
            $superAdmin->roles()->attach($superAdminRole);
        }

        // Create HR Admin
        $hrAdmin = User::create([
            'name' => 'HR Administrator',
            'email' => 'hradmin@tanzaniahr.com',
            'username' => 'hradmin',
            'password' => bcrypt('hradmin123'),
        ]);
        if ($hrAdminRole) {
            $hrAdmin->roles()->attach($hrAdminRole);
        }

        // Create Lead HR Admin
        $leadHr = User::create([
            'name' => 'Lead HR Administrator',
            'email' => 'leadhr@tanzaniahr.com',
            'username' => 'leadhr',
            'password' => bcrypt('leadhr123'),
        ]);
        if ($leadHrRole) {
            $leadHr->roles()->attach($leadHrRole);
        }

        $this->command->info('Test users created successfully!');
        $this->command->info('Super Admin: superadmin@tanzaniahr.com / superadmin123');
        $this->command->info('HR Admin: hradmin@tanzaniahr.com / hradmin123');
        $this->command->info('Lead HR: leadhr@tanzaniahr.com / leadhr123');
    }
}
