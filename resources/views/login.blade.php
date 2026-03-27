<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Orvion | HR management System</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css'])
    
    <style>
        /* CSS Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow-x: hidden;
        }
        
        /* Base Styles */
        body {
            height: 100vh;
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }
        
        .login-container {
            display: flex;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }
        
        /* Left Section - System Information */
        .left-section {
            flex: 1;
            background: linear-gradient(135deg, #070029 0%, #1a1a4e 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .left-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }
        
        /* Right Section - Login Form */
        .right-section {
            flex: 1;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            position: relative;
        }
        
        /* System Logo */
        .system-logo {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 10;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .system-logo:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        }
        
        .system-logo img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }
        
        /* System Title */
        .system-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
            background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            z-index: 10;
        }
        
        .system-subtitle {
            font-size: 1.2rem;
            color: #a5b4fc;
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
            z-index: 10;
        }
        
        /* Features Grid */
        .features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-top: 2rem;
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 600px;
        }
        
        .feature {
            text-align: center;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease, background 0.3s ease;
        }
        
        .feature:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.1);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease, background 0.3s ease;
        }
        
        .feature:hover .feature-icon {
            transform: scale(1.1);
            background: rgba(255, 255, 255, 0.2);
        }
        
        .feature-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .feature-desc {
            font-size: 0.9rem;
            color: #a5b4fc;
            line-height: 1.4;
        }
        
        /* Login Form */
        .login-form {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 2.5rem;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .login-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #070029 0%, #1a1a4e 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 10px 20px rgba(7, 0, 41, 0.2);
            transition: transform 0.3s ease;
        }
        
        .login-logo:hover {
            transform: scale(1.05);
        }
        
        .login-logo img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }
        
        .login-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            text-align: center;
            margin-bottom: 0.5rem;
        }
        
        .login-subtitle {
            color: #6b7280;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }
        
        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f9fafb;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #070029;
            box-shadow: 0 0 0 3px rgba(7, 0, 41, 0.1);
            background: white;
        }
        
        .form-input::placeholder {
            color: #9ca3af;
        }
        
        .remember-group {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .remember-checkbox {
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
            accent-color: #070029;
            cursor: pointer;
        }
        
        .remember-label {
            font-size: 0.9rem;
            color: #6b7280;
            cursor: pointer;
            user-select: none;
        }
        
        .login-button {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #070029 0%, #1a1a4e 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .login-button:hover::before {
            left: 100%;
        }
        
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(7, 0, 41, 0.3);
        }
        
        .login-button:active {
            transform: translateY(0);
        }
        
        /* Messages */
        .error-message, .success-message {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            border-left: 4px solid;
        }
        
        .error-message {
            background: #fef2f2;
            border-left-color: #dc2626;
            color: #dc2626;
            border: 1px solid #fecaca;
        }
        
        .success-message {
            background: #f0fdf4;
            border-left-color: #16a34a;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }
        
        /* Tablet Responsive (768px - 1024px) */
        @media (max-width: 1024px) {
            .left-section, .right-section {
                padding: 1.5rem;
            }
            
            .system-title {
                font-size: 2.2rem;
            }
            
            .system-subtitle {
                font-size: 1.1rem;
            }
            
            .features {
                gap: 1.8rem;
            }
            
            .feature {
                padding: 1.3rem;
            }
            
            .login-form {
                padding: 2rem;
            }
        }
        
        /* Mobile Responsive (320px - 768px) */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                width: 100vw;
                height: 100vh;
            }
            
            .left-section {
                min-height: 60vh;
                padding: 1.5rem;
                position: relative;
            }
            
            .right-section {
                min-height: 40vh;
                padding: 1.5rem;
            }
            
            .system-logo {
                width: 80px;
                height: 80px;
                margin-bottom: 1.5rem;
            }
            
            .system-logo img {
                width: 60px;
                height: 60px;
            }
            
            .system-title {
                font-size: 1.8rem;
                margin-bottom: 0.8rem;
            }
            
            .system-subtitle {
                font-size: 1rem;
                margin-bottom: 2rem;
            }
            
            .features {
                grid-template-columns: 1fr;
                gap: 1rem;
                margin-top: 1.5rem;
            }
            
            .feature {
                padding: 1rem;
            }
            
            .feature-icon {
                width: 50px;
                height: 50px;
                margin-bottom: 0.8rem;
            }
            
            .feature-icon svg {
                width: 1.5rem;
                height: 1.5rem;
            }
            
            .feature-title {
                font-size: 0.9rem;
            }
            
            .feature-desc {
                font-size: 0.8rem;
            }
            
            .login-form {
                max-width: 100%;
                padding: 1.5rem;
                border-radius: 15px;
                margin: 0;
            }
            
            .login-logo {
                width: 60px;
                height: 60px;
                margin-bottom: 1.5rem;
            }
            
            .login-logo img {
                width: 40px;
                height: 40px;
            }
            
            .login-title {
                font-size: 1.6rem;
                margin-bottom: 0.5rem;
            }
            
            .login-subtitle {
                font-size: 0.9rem;
                margin-bottom: 1.5rem;
            }
            
            .form-input {
                padding: 0.75rem;
                font-size: 0.95rem;
            }
            
            .login-button {
                padding: 0.875rem;
                font-size: 0.95rem;
            }
        }
        
        /* Small Mobile (320px - 480px) */
        @media (max-width: 480px) {
            .left-section, .right-section {
                padding: 1rem;
            }
            
            .system-title {
                font-size: 1.5rem;
            }
            
            .system-subtitle {
                font-size: 0.9rem;
            }
            
            .features {
                gap: 0.8rem;
            }
            
            .feature {
                padding: 0.8rem;
            }
            
            .feature-icon {
                width: 40px;
                height: 40px;
            }
            
            .feature-icon svg {
                width: 1.25rem;
                height: 1.25rem;
            }
            
            .login-form {
                padding: 1rem;
            }
            
            .login-title {
                font-size: 1.4rem;
            }
            
            .login-subtitle {
                font-size: 0.85rem;
            }
            
            .form-input {
                padding: 0.625rem;
                font-size: 0.9rem;
            }
            
            .login-button {
                padding: 0.75rem;
                font-size: 0.9rem;
            }
        }
        
        /* Ultra Small Mobile (320px and below) */
        @media (max-width: 320px) {
            .left-section, .right-section {
                padding: 0.75rem;
            }
            
            .system-logo {
                width: 60px;
                height: 60px;
            }
            
            .system-logo img {
                width: 45px;
                height: 45px;
            }
            
            .system-title {
                font-size: 1.3rem;
            }
            
            .system-subtitle {
                font-size: 0.8rem;
            }
            
            .login-form {
                padding: 0.75rem;
            }
            
            .login-title {
                font-size: 1.2rem;
            }
            
            .login-subtitle {
                font-size: 0.8rem;
            }
        }
        
        /* Large Desktop (1200px and above) */
        @media (min-width: 1200px) {
            .login-container {
                width: 100vw;
                height: 100vh;
            }
            
            .left-section, .right-section {
                padding: 3rem;
            }
            
            .system-title {
                font-size: 3rem;
            }
            
            .system-subtitle {
                font-size: 1.3rem;
            }
            
            .features {
                gap: 2.5rem;
            }
            
            .feature {
                padding: 2rem;
            }
            
            .login-form {
                max-width: 450px;
                padding: 3rem;
            }
        }
        
        /* Ultra Wide Desktop (1600px and above) */
        @media (min-width: 1600px) {
            .login-container {
                width: 100vw;
                height: 100vh;
            }
            
            .system-title {
                font-size: 3.5rem;
            }
            
            .system-subtitle {
                font-size: 1.5rem;
            }
            
            .features {
                max-width: 700px;
            }
        }
        
        /* Landscape Mobile (480px - 768px height) */
        @media (max-height: 768px) and (orientation: landscape) {
            .login-container {
                flex-direction: row;
            }
            
            .left-section {
                min-height: 100vh;
            }
            
            .right-section {
                min-height: 100vh;
            }
            
            .system-title {
                font-size: 1.8rem;
            }
            
            .system-subtitle {
                font-size: 0.9rem;
                margin-bottom: 1.5rem;
            }
            
            .features {
                margin-top: 1rem;
                gap: 1rem;
            }
            
            .feature {
                padding: 0.8rem;
            }
            
            .login-form {
                padding: 1.5rem;
            }
        }
        
        /* High DPI Displays */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .system-logo, .login-logo {
                border-radius: 25px;
            }
            
            .feature {
                border-radius: 20px;
            }
            
            .form-input, .login-button {
                border-radius: 12px;
            }
        }
        
        /* Reduced Motion */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
        
        /* Dark Mode Support */
        @media (prefers-color-scheme: dark) {
            .right-section {
                background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
            }
            
            .login-form {
                background: #374151;
                border-color: rgba(255, 255, 255, 0.1);
            }
            
            .login-title {
                color: white;
            }
            
            .login-subtitle {
                color: #d1d5db;
            }
            
            .form-label {
                color: #e5e7eb;
            }
            
            .form-input {
                background: #4b5563;
                border-color: #6b7280;
                color: white;
            }
            
            .form-input::placeholder {
                color: #9ca3af;
            }
            
            .remember-label {
                color: #d1d5db;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Left Section - System Information -->
        <div class="left-section">
            <!-- System Logo -->
            <div class="system-logo">
                <img src="{{ asset('images/logos/orvion-logo.png') }}" alt="Orvion">
            </div>
            
            <!-- System Title -->
            <h1 class="system-title">Orvion</h1>
            <p class="system-subtitle">HR Management System</p>
            
            <!-- Features -->
            <div class="features">
                <div class="feature">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Employee Management</h3>
                    <p class="feature-desc">Comprehensive staff database and records</p>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2V7a2 2 0 00-2-2H9a2 2 0 00-2-2h2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Payroll System</h3>
                    <p class="feature-desc">Automated salary calculations</p>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Compliance</h3>
                    <p class="feature-desc">Regulatory compliance tracking</p>
                </div>
                
                <div class="feature">
                    <div class="feature-icon">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Analytics</h3>
                    <p class="feature-desc">Advanced reporting and insights</p>
                </div>
            </div>
        </div>
        
        <!-- Right Section - Login Form -->
        <div class="right-section">
            <form class="login-form" method="POST" action="{{ route('login.process') }}">
                @csrf
                
                <!-- Login Logo -->
                <div class="login-logo">
                    <img src="{{ asset('images/logos/orvion-logo.png') }}" alt="Orvion">
                </div>
                
                <!-- Login Title -->
                <h2 class="login-title">Welcome Back</h2>
                <p class="login-subtitle">Sign in to access your HR dashboard</p>
                
                <!-- Error Message -->
                @if(session()->has('error'))
                    <div class="error-message">
                        {{ session()->get('error') }}
                    </div>
                @endif
                
                <!-- Validation Errors -->
                @if($errors->any())
                    <div class="error-message">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                
                <!-- Success Message -->
                @if(session()->has('success'))
                    <div class="success-message">
                        {{ session()->get('success') }}
                    </div>
                @endif
                
                <!-- Username -->
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input
                        id="username"
                        name="username"
                        type="text"
                        autocomplete="username"
                        required
                        class="form-input"
                        placeholder="Enter your username"
                        value="{{ old('username') }}"
                    >
                </div>
                
                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        class="form-input"
                        placeholder="Enter your password"
                    >
                </div>
                
                <!-- Remember Me -->
                <div class="remember-group">
                    <input
                        id="remember-me"
                        name="remember"
                        type="checkbox"
                        class="remember-checkbox"
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    <label for="remember-me" class="remember-label">Remember me</label>
                </div>
                
                <!-- Login Button -->
                <button type="submit" class="login-button">
                    Sign In
                </button>
            </form>
        </div>
    </div>
    
    <script>
        // Enhanced login page functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-focus on username field
            const usernameField = document.getElementById('username');
            const passwordField = document.getElementById('password');
            const loginForm = document.querySelector('.login-form');
            
            if (usernameField) {
                usernameField.focus();
            }
            
            // Add input validation and feedback
            if (usernameField && passwordField) {
                // Username field validation
                usernameField.addEventListener('input', function() {
                    const value = this.value.trim();
                    if (value.length > 0 && value.length < 3) {
                        this.classList.add('border-red-500');
                        this.classList.remove('border-green-500');
                    } else if (value.length >= 3) {
                        this.classList.add('border-green-500');
                        this.classList.remove('border-red-500');
                    } else {
                        this.classList.remove('border-green-500', 'border-red-500');
                    }
                });
                
                // Password field validation
                passwordField.addEventListener('input', function() {
                    const value = this.value;
                    if (value.length > 0 && value.length < 6) {
                        this.classList.add('border-red-500');
                        this.classList.remove('border-green-500');
                    } else if (value.length >= 6) {
                        this.classList.add('border-green-500');
                        this.classList.remove('border-red-500');
                    } else {
                        this.classList.remove('border-green-500', 'border-red-500');
                    }
                });
                
                // Enter key navigation
                usernameField.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        passwordField.focus();
                    }
                });
                
                passwordField.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        loginForm.submit();
                    }
                });
            }
            
            // Mobile touch feedback
            const loginButton = document.querySelector('.login-button');
            const formInputs = document.querySelectorAll('.form-input');
            
            // Add touch feedback for mobile
            if ('ontouchstart' in window) {
                formInputs.forEach(input => {
                    input.addEventListener('touchstart', function() {
                        this.style.transform = 'scale(1.02)';
                    });
                    
                    input.addEventListener('touchend', function() {
                        this.style.transform = 'scale(1)';
                    });
                });
                
                if (loginButton) {
                    loginButton.addEventListener('touchstart', function() {
                        this.style.transform = 'scale(0.98)';
                    });
                    
                    loginButton.addEventListener('touchend', function() {
                        this.style.transform = 'scale(1)';
                    });
                }
            }
            
            // Add loading state to login button
            if (loginForm && loginButton) {
                loginForm.addEventListener('submit', function(e) {
                    // Validate form before submission
                    if (!usernameField.value.trim() || !passwordField.value) {
                        e.preventDefault();
                        showFormError('Please fill in all fields');
                        return;
                    }
                    
                    if (usernameField.value.trim().length < 3) {
                        e.preventDefault();
                        showFormError('Username must be at least 3 characters');
                        return;
                    }
                    
                    if (passwordField.value.length < 6) {
                        e.preventDefault();
                        showFormError('Password must be at least 6 characters');
                        return;
                    }
                    
                    // Show loading state
                    const originalText = loginButton.innerHTML;
                    loginButton.innerHTML = `
                        <span class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Signing in...
                        </span>
                    `;
                    loginButton.disabled = true;
                    loginButton.classList.add('opacity-75', 'cursor-not-allowed');
                    
                    // Reset button after 10 seconds (in case of server issues)
                    setTimeout(() => {
                        loginButton.innerHTML = originalText;
                        loginButton.disabled = false;
                        loginButton.classList.remove('opacity-75', 'cursor-not-allowed');
                    }, 10000);
                });
            }
            
            // Show form error function
            function showFormError(message) {
                // Remove existing error messages
                const existingError = loginForm.querySelector('.form-error-message');
                if (existingError) {
                    existingError.remove();
                }
                
                // Create error message
                const errorDiv = document.createElement('div');
                errorDiv.className = 'form-error-message error-message mb-4';
                errorDiv.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        ${message}
                    </div>
                `;
                
                // Insert before first form group
                const firstFormGroup = loginForm.querySelector('.form-group');
                if (firstFormGroup) {
                    loginForm.insertBefore(errorDiv, firstFormGroup);
                } else {
                    loginForm.insertBefore(errorDiv, loginButton);
                }
                
                // Auto-remove after 5 seconds
                setTimeout(() => {
                    if (errorDiv.parentNode) {
                        errorDiv.remove();
                    }
                }, 5000);
                
                // Shake animation
                loginForm.style.animation = 'shake 0.5s';
                setTimeout(() => {
                    loginForm.style.animation = '';
                }, 500);
            }
            
            // Add shake animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                    20%, 40%, 60%, 80% { transform: translateX(5px); }
                }
                
                .form-error-message {
                    animation: slideInDown 0.3s ease-out;
                }
                
                @keyframes slideInDown {
                    from {
                        opacity: 0;
                        transform: translateY(-10px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                
                .border-green-500 {
                    border-color: #10b981 !important;
                }
                
                .border-red-500 {
                    border-color: #ef4444 !important;
                }
            `;
            document.head.appendChild(style);
            
            // Responsive adjustments for mobile
            function adjustForMobile() {
                const isMobile = window.innerWidth <= 768;
                const isLandscape = window.innerHeight < window.innerWidth;
                
                // Ensure full width layout
                const loginContainer = document.querySelector('.login-container');
                if (loginContainer) {
                    loginContainer.style.width = '100vw';
                    loginContainer.style.height = '100vh';
                    loginContainer.style.margin = '0';
                    loginContainer.style.padding = '0';
                }
                
                if (isMobile && isLandscape) {
                    // Adjust for landscape mobile
                    document.body.classList.add('landscape-mobile');
                    
                    // Reduce padding for landscape
                    const leftSection = document.querySelector('.left-section');
                    const rightSection = document.querySelector('.right-section');
                    
                    if (leftSection) leftSection.style.padding = '1rem';
                    if (rightSection) rightSection.style.padding = '1rem';
                } else {
                    document.body.classList.remove('landscape-mobile');
                }
            }
            
            // Initial adjustment
            adjustForMobile();
            
            // Listen for orientation changes
            window.addEventListener('resize', adjustForMobile);
            window.addEventListener('orientationchange', function() {
                setTimeout(adjustForMobile, 100);
            });
            
            // Add smooth scroll behavior
            document.documentElement.style.scrollBehavior = 'smooth';
            
            // Prevent zoom on input focus (iOS)
            const viewport = document.querySelector('meta[name="viewport"]');
            if (viewport) {
                viewport.setAttribute('content', 'width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no');
            }
            
            // Add iOS Safari specific fixes
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
            if (isIOS) {
                // Fix viewport height issues
                function setViewportHeight() {
                    const vh = window.innerHeight * 0.01;
                    document.documentElement.style.setProperty('--vh', `${vh}px`);
                }
                
                setViewportHeight();
                window.addEventListener('resize', setViewportHeight);
                window.addEventListener('orientationchange', setViewportHeight);
                
                // Add iOS specific styles
                const iosStyle = document.createElement('style');
                iosStyle.textContent = `
                    .login-container {
                        height: 100vh;
                        height: calc(var(--vh, 1vh) * 100);
                    }
                    
                    .form-input {
                        -webkit-appearance: none;
                        border-radius: 10px;
                    }
                    
                    .login-button {
                        -webkit-appearance: none;
                        -webkit-user-select: none;
                    }
                `;
                document.head.appendChild(iosStyle);
            }
            
            // Add accessibility improvements
            // Add proper ARIA labels
            if (usernameField) {
                usernameField.setAttribute('aria-describedby', 'username-help');
                usernameField.setAttribute('autocomplete', 'username');
            }
            
            if (passwordField) {
                passwordField.setAttribute('aria-describedby', 'password-help');
                passwordField.setAttribute('autocomplete', 'current-password');
            }
            
            if (loginButton) {
                loginButton.setAttribute('aria-label', 'Sign in to HR Management System');
            }
            
            // Add keyboard navigation
            document.addEventListener('keydown', function(e) {
                // Alt + L: Focus login form
                if (e.altKey && e.key === 'l') {
                    e.preventDefault();
                    if (usernameField) usernameField.focus();
                }
                
                // Escape: Clear form
                if (e.key === 'Escape') {
                    if (usernameField) usernameField.value = '';
                    if (passwordField) passwordField.value = '';
                    if (usernameField) usernameField.focus();
                }
            });
            
            // Add feature animations on scroll (for desktop)
            if (window.innerWidth > 768) {
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                };
                
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }
                    });
                }, observerOptions);
                
                // Observe feature elements
                const features = document.querySelectorAll('.feature');
                features.forEach((feature, index) => {
                    feature.style.opacity = '0';
                    feature.style.transform = 'translateY(20px)';
                    feature.style.transition = `opacity 0.5s ease ${index * 0.1}s, transform 0.5s ease ${index * 0.1}s`;
                    observer.observe(feature);
                });
            }
            
            console.log('Login page enhanced with responsive features');
        });
    </script>
</body>
</html>
