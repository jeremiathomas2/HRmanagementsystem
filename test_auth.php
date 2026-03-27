<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

// Test authentication manually
try {
    echo "Testing authentication...\n";
    
    // Find admin user
    $user = \App\Models\User::where('username', 'admin')->first();
    
    if ($user) {
        echo "Found admin user: " . $user->username . "\n";
        echo "User email: " . $user->email . "\n";
        
        // Test password
        if (\Illuminate\Support\Facades\Hash::check('admin123', $user->password)) {
            echo "Password verification: SUCCESS\n";
            
            // Test Auth::attempt with email
            $credentials = [
                'email' => $user->email,
                'password' => 'admin123'
            ];
            
            if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
                echo "Auth::attempt with email: SUCCESS\n";
                echo "Authenticated user: " . \Illuminate\Support\Facades\Auth::user()->email . "\n";
                
                // Logout to test again
                \Illuminate\Support\Facades\Auth::logout();
                
                // Test Auth::login
                if (\Illuminate\Support\Facades\Auth::login($user)) {
                    echo "Auth::login: SUCCESS\n";
                    echo "Authenticated user: " . \Illuminate\Support\Facades\Auth::user()->username . "\n";
                } else {
                    echo "Auth::login: FAILED\n";
                }
            } else {
                echo "Auth::attempt with email: FAILED\n";
            }
        } else {
            echo "Password verification: FAILED\n";
        }
    } else {
        echo "Admin user not found!\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
