<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

// Test web login request simulation
try {
    echo "=== WEB LOGIN TEST ===\n";
    
    // Create a mock request
    $request = new \Illuminate\Http\Request();
    $request->merge([
        'username' => 'admin',
        'password' => 'admin123',
        'remember' => false,
        '_token' => 'test-token'
    ]);
    
    echo "Request data:\n";
    echo "   Username: " . $request->get('username') . "\n";
    echo "   Password: " . $request->get('password') . "\n";
    echo "   Remember: " . $request->get('remember') . "\n";
    
    // Test validation
    try {
        $credentials = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'remember' => 'boolean'
        ]);
        echo "✅ Validation: PASSED\n";
    } catch (\Illuminate\Validation\ValidationException $e) {
        echo "❌ Validation: FAILED\n";
        echo "   Errors: " . json_encode($e->errors()) . "\n";
        exit;
    }
    
    // Find user by username first
    $user = \App\Models\User::where('username', $credentials['username'])->first();
    
    if (!$user) {
        echo "❌ User not found\n";
        exit;
    }
    
    echo "✅ User found: " . $user->username . "\n";
    
    // Check password
    if (!\Illuminate\Support\Facades\Hash::check($credentials['password'], $user->password)) {
        echo "❌ Password check failed\n";
        exit;
    }
    
    echo "✅ Password check passed\n";
    
    // Use Auth::attempt with email credentials
    $emailCredentials = [
        'email' => $user->email,
        'password' => $credentials['password']
    ];
    
    if (\Illuminate\Support\Facades\Auth::attempt($emailCredentials, $request->filled('remember'))) {
        echo "✅ Web login: SUCCESS\n";
        echo "   Authenticated user: " . \Illuminate\Support\Facades\Auth::user()->email . "\n";
        
        // Logout to clean up
        \Illuminate\Support\Facades\Auth::logout();
        
        echo "✅ Web login test: PASSED\n";
    } else {
        echo "❌ Web login: FAILED\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
