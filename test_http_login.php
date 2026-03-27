<?php

// Test HTTP login request
$url = 'http://127.0.0.1:8000/login/process';

// Get CSRF token first
$context = stream_context_create([
    'http' => [
        'method' => 'GET',
        'header' => "User-Agent: Test Client\r\n"
    ]
]);

$html = file_get_contents('http://127.0.0.1:8000/login', false, $context);

// Extract CSRF token (simple approach)
if (preg_match('/<meta name="csrf-token" content="([^"]+)"/', $html, $matches)) {
    $csrfToken = $matches[1];
    echo "✅ CSRF Token found: " . substr($csrfToken, 0, 20) . "...\n";
} else {
    echo "❌ CSRF Token not found\n";
    exit;
}

// Also extract session cookie
preg_match('/Set-Cookie: laravel-session=([^;]+)/', $html, $sessionMatch);
$sessionCookie = $sessionMatch ? $sessionMatch[1] : '';
echo "🍪 Session cookie: " . substr($sessionCookie, 0, 20) . "...\n";

// Prepare login data
$postData = http_build_query([
    'username' => 'admin',
    'password' => 'admin123',
    'remember' => '0',
    '_token' => $csrfToken
]);

// Create POST request with proper cookies
$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => [
            'Content-Type: application/x-www-form-urlencoded',
            'User-Agent: Test Client',
            'Cookie: laravel-session=' . $sessionCookie . '; XSRF-TOKEN=' . $csrfToken
        ],
        'content' => $postData,
        'ignore_errors' => true
    ]
]);

echo "🔄 Sending login request...\n";

$response = file_get_contents($url, false, $context);

// Check response
if ($response === false) {
    echo "❌ No response received\n";
} else {
    echo "✅ Response received\n";
    echo "Response length: " . strlen($response) . " bytes\n";
    
    // Check if redirected to dashboard
    if (isset($http_response_header)) {
        foreach ($http_response_header as $header) {
            echo "Header: " . $header . "\n";
            if (strpos($header, 'Location:') === 0) {
                echo "📍 Redirect: " . $header . "\n";
                if (strpos($header, 'dashboard') !== false) {
                    echo "✅ Login successful - redirected to dashboard\n";
                } else {
                    echo "❌ Login failed - redirected elsewhere\n";
                }
            }
        }
    }
    
    // Check response content
    if (strpos($response, 'error-message') !== false) {
        echo "❌ Error message found in response\n";
        // Extract error message
        if (preg_match('/<div class="error-message">(.*?)<\/div>/s', $response, $errorMatch)) {
            echo "Error: " . strip_tags($errorMatch[1]) . "\n";
        }
    }
    
    if (strpos($response, 'Welcome Back') !== false) {
        echo "❌ Still on login page - login failed\n";
    }
    
    if (strpos($response, 'Dashboard') !== false || strpos($response, 'dashboard') !== false) {
        echo "✅ Dashboard content found - login successful\n";
    }
}
