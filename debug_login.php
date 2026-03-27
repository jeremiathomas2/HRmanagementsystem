<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

// Test authentication step by step
try {
    echo "=== DEBUG LOGIN ===\n";
    
    // Step 1: Check if users exist
    $userCount = \App\Models\User::count();
    echo "Total users in database: " . $userCount . "\n";
    
    // Step 2: Find admin user
    $admin = \App\Models\User::where('username', 'admin')->first();
    if ($admin) {
        echo "✅ Admin user found:\n";
        echo "   Username: " . $admin->username . "\n";
        echo "   Email: " . $admin->email . "\n";
        echo "   ID: " . $admin->id . "\n";
        
        // Step 3: Test password
        if (\Illuminate\Support\Facades\Hash::check('admin123', $admin->password)) {
            echo "✅ Password verification: SUCCESS\n";
            
            // Step 4: Test Auth::attempt with email
            $emailCredentials = [
                'email' => $admin->email,
                'password' => 'admin123'
            ];
            
            if (\Illuminate\Support\Facades\Auth::attempt($emailCredentials)) {
                echo "✅ Auth::attempt with email: SUCCESS\n";
                echo "   Authenticated user: " . \Illuminate\Support\Facades\Auth::user()->email . "\n";
                
                // Logout to clean up
                \Illuminate\Support\Facades\Auth::logout();
                
                echo "✅ Authentication test: PASSED\n";
            } else {
                echo "❌ Auth::attempt with email: FAILED\n";
            }
        } else {
            echo "❌ Password verification: FAILED\n";
        }
    } else {
        echo "❌ Admin user NOT found!\n";
        
        // Show all users for debugging
        $users = \App\Models\User::take(5)->get(['id', 'username', 'email']);
        echo "\nFirst 5 users:\n";
        foreach ($users as $user) {
            echo "   ID: " . $user->id . " | Username: " . $user->username . " | Email: " . $user->email . "\n";
        }
    }
    
    // Step 5: Check if migrations are up to date
    echo "\n=== MIGRATION STATUS ===\n";
    $migrations = \Illuminate\Support\Facades\DB::table('migrations')->pluck('migration')->toArray();
    $usernameMigration = '2026_03_10_151115_add_username_to_users_table';
    
    if (in_array($usernameMigration, $migrations)) {
        echo "✅ Username migration: RUN\n";
    } else {
        echo "❌ Username migration: NOT RUN\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
