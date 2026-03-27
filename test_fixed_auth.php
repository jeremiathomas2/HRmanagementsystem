<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

// Test the fixed authentication logic
try {
    echo "Testing fixed authentication...\n";
    
    // Find admin user
    $user = \App\Models\User::where('username', 'admin')->first();
    
    if ($user) {
        echo "Found admin user: " . $user->username . "\n";
        echo "User email: " . $user->email . "\n";
        
        // Test password
        if (\Illuminate\Support\Facades\Hash::check('admin123', $user->password)) {
            echo "Password verification: SUCCESS\n";
            
            // Test the fixed authentication logic
            $credentials = [
                'username' => 'admin',
                'password' => 'admin123',
                'remember' => false
            ];

            // Find user by username first
            $testUser = \App\Models\User::where('username', $credentials['username'])->first();
            
            if (!$testUser) {
                echo "User not found in test!\n";
            } else {
                echo "User found in test: " . $testUser->username . "\n";
                
                // Check password
                if (!\Illuminate\Support\Facades\Hash::check($credentials['password'], $testUser->password)) {
                    echo "Password check failed in test!\n";
                } else {
                    echo "Password check passed in test!\n";
                    
                    // Use Auth::attempt with email credentials
                    $emailCredentials = [
                        'email' => $testUser->email,
                        'password' => $credentials['password']
                    ];

                    if (\Illuminate\Support\Facades\Auth::attempt($emailCredentials, $credentials['remember'])) {
                        echo "Fixed authentication: SUCCESS\n";
                        echo "Authenticated user: " . \Illuminate\Support\Facades\Auth::user()->email . "\n";
                        
                        // Logout to clean up
                        \Illuminate\Support\Facades\Auth::logout();
                        
                        echo "Authentication test completed successfully!\n";
                    } else {
                        echo "Fixed authentication: FAILED\n";
                    }
                }
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
