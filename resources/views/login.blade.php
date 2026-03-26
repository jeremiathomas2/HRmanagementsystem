<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Tanzania HR Management System</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css'])
    
    <style>
        body {
            background: linear-gradient(135deg, rgb(79, 70, 229) 0%, rgb(67, 56, 202) 50%, rgb(79, 70, 229) 100%);
            min-height: 100vh;
        }
        
        .login-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 2rem;
        }
        
        .login-form {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 28rem;
        }
        
        .logo-enhanced {
            background: linear-gradient(135deg, rgb(99, 102, 241) 0%, rgb(139, 92, 246) 100%);
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.3);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }
        
        .form-input {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
            color: white !important;
            -webkit-text-fill-color: white !important;
            -webkit-opacity: 1 !important;
            opacity: 1 !important;
        }
        
        .form-input:focus {
            background: rgba(255, 255, 255, 0.15) !important;
            border-color: rgba(99, 102, 241, 0.8) !important;
            color: white !important;
            -webkit-text-fill-color: white !important;
            -webkit-opacity: 1 !important;
            opacity: 1 !important;
        }
        
        .btn-login {
            background: linear-gradient(135deg, rgb(99, 102, 241) 0%, rgb(139, 92, 246) 100%) !important;
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.3) !important;
            transition: all 0.3s ease !important;
        }
        
        .btn-login:hover {
            background: linear-gradient(135deg, rgb(79, 70, 229) 0%, rgb(67, 56, 202) 50%) !important;
            box-shadow: 0 15px 35px -5px rgba(99, 102, 241, 0.4) !important;
            transform: translateY(-2px) !important;
        }
        
        .error-message {
            background: rgba(239, 68, 68, 0.2) !important;
            border: 1px solid rgba(239, 68, 68, 0.5) !important;
            color: rgb(254, 202, 202) !important;
        }
        
        .checkbox-custom {
            background-color: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
        }
        
        .checkbox-custom:checked {
            background-color: rgb(99, 102, 241) !important;
            border-color: rgb(99, 102, 241) !important;
        }
        
        .link-white {
            color: rgb(199, 210, 254) !important;
        }
        
        .link-white:hover {
            color: white !important;
        }
        
        /* Ensure all text is white */
        .login-container * {
            color: white !important;
        }
        
        .text-white {
            color: white !important;
        }
        
        .text-gray-200 {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        .text-indigo-300 {
            color: rgb(199, 210, 254) !important;
        }
        
        .text-indigo-200 {
            color: rgba(199, 210, 254, 0.9) !important;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <form class="login-form" method="POST" action="{{ route('login.process') }}">
            @csrf
            <!-- Logo -->
            <div class="flex justify-center mb-8">
                <div class="w-12 h-12 logo-enhanced rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-xl">HR</span>
                </div>
            </div>
            
            <!-- Title -->
            <h2 class="text-center text-3xl font-extrabold text-white mb-2">
                Sign in to your account
            </h2>
            <p class="text-center text-sm text-gray-200 mb-8">
                Welcome to
            </p>
            <p class="text-center text-sm text-gray-200 mb-8">
                HR Management System
            </p>
            
            <!-- Error Message -->
            @if(session()->has('error'))
                <div class="rounded-md error-message p-3 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2 2m2 2l2 2m7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-200">{{ session()->get('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Username -->
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-200 mb-2">
                    Username
                </label>
                <div class="mt-1">
                    <input
                        id="username"
                        name="username"
                        type="text"
                        autocomplete="username"
                        required
                        class="appearance-none block w-full px-3 py-2 border border-white/30 rounded-md placeholder-gray-400 text-white bg-white/10 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 form-input"
                        placeholder="Enter your username"
                        value="{{ old('username') }}"
                    >
                </div>
            </div>
            
            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-200 mb-2">
                    Password
                </label>
                <div class="mt-1">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        class="appearance-none block w-full px-3 py-2 border border-white/30 rounded-md placeholder-gray-400 text-white bg-white/10 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 form-input"
                        placeholder="Enter your password"
                    >
                </div>
            </div>
            
            <!-- Remember Me -->
            <div class="flex items-center mb-6">
                <div class="flex items-center">
                    <input
                        id="remember-me"
                        name="remember"
                        type="checkbox"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded checkbox-custom"
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    <label for="remember-me" class="ml-2 block text-sm text-gray-200">
                        Remember me
                    </label>
                </div>
            </div>
            
            <!-- Login Button -->
            <div>
                <button
                    type="submit"
                    :disabled="request()->has('loading')"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white btn-login disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    @if(request()->has('loading'))
                        <span class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018 0l4.4 4.4a6 6 0 014 0z"></path>
                            </svg>
                            Signing in...
                        </span>
                    @else
                        Sign in
                    @endif
                </button>
            </div>
        </form>
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
