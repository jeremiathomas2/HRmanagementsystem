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
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
        }
        
        .login-container {
            display: flex;
            height: 100vh;
        }
        
        .left-section {
            flex: 1;
            background-color: #070029;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            color: white;
        }
        
        .right-section {
            flex: 1;
            background-color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
        }
        
        .system-logo {
            width: 120px;
            height: 120px;
            background: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        .system-logo img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }
        
        .system-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
            background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .system-subtitle {
            font-size: 1.2rem;
            color: #a5b4fc;
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .feature {
            text-align: center;
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
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
        
        .login-form {
            width: 100%;
            max-width: 400px;
        }
        
        .login-logo {
            width: 80px;
            height: 80px;
            background: #070029;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
        }
        
        .login-logo img {
            width: 60px;
            height: 60px;
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
        }
        
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
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #070029;
            box-shadow: 0 0 0 3px rgba(7, 0, 41, 0.1);
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
        }
        
        .remember-label {
            font-size: 0.9rem;
            color: #6b7280;
        }
        
        .login-button {
            width: 100%;
            padding: 0.875rem;
            background: #070029;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .login-button:hover {
            background: #0a0138;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(7, 0, 41, 0.2);
        }
        
        .error-message {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            
            .left-section, .right-section {
                padding: 2rem;
            }
            
            .features {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .system-title {
                font-size: 2rem;
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
        // Auto-focus on username field
        document.addEventListener('DOMContentLoaded', function() {
            const usernameField = document.getElementById('username');
            if (usernameField) {
                usernameField.focus();
            }
        });
    </script>
</body>
</html>
