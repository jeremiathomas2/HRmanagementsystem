<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

// Check if users exist
try {
    $users = \App\Models\User::all();
    echo "Total users: " . $users->count() . "\n";
    
    foreach ($users as $user) {
        echo "User: " . $user->username . " | Email: " . $user->email . "\n";
    }
    
    // Test admin user specifically
    $admin = \App\Models\User::where('username', 'admin')->first();
    if ($admin) {
        echo "\nAdmin user found:\n";
        echo "Username: " . $admin->username . "\n";
        echo "Email: " . $admin->email . "\n";
        echo "Password hash: " . substr($admin->password, 0, 20) . "...\n";
        
        // Test password verification
        if (\Illuminate\Support\Facades\Hash::check('admin123', $admin->password)) {
            echo "Password verification: SUCCESS\n";
        } else {
            echo "Password verification: FAILED\n";
        }
    } else {
        echo "\nAdmin user NOT found!\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
