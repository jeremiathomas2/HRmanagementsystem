<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SimpleAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the admin user
        $user = User::updateOrCreate(
            ['username' => 'admin@test.com'],
            [
                'name' => 'System Administrator',
                'email' => 'admin@test.com',
                'password' => Hash::make('admin@123'),
                'email_verified_at' => now(),
            ]
        );

        echo "Admin user created successfully!\n";
        echo "Username: admin@test.com\n";
        echo "Password: admin@123\n";
    }
}
