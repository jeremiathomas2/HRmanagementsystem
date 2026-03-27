<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Tanzania HR Management System')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css'])
    
    <!-- Custom Styles -->
    <style>
        /* Ensure all text is white on dark backgrounds */
        .dark-bg * {
            color: white !important;
        }
        
        .notification-container {
            position: fixed !important;
            top: 20px !important;
            right: 20px !important;
            z-index: 9999 !important;
            pointer-events: none !important;
        }
        
        .notification-container > * {
            pointer-events: auto !important;
        }
        
        .notification-container .bg-white {
            background: white !important;
        }
        
        .notification-container .text-gray-900 {
            color: rgb(17, 24, 39) !important;
        }
        
        .notification-container .text-gray-600 {
            color: rgb(75, 85, 99) !important;
        }
        
        .notification-container .text-gray-500 {
            color: rgb(107, 114, 128) !important;
        }
        
        .notification-container .hover\:text-gray-600:hover {
            color: rgb(55, 65, 81) !important;
        }
        
        .notification-container .focus\:text-gray-600:focus {
            color: rgb(55, 65, 81) !important;
        }
        
        /* Icon visibility */
        .notification-container .text-green-600 {
            color: rgb(22, 163, 74) !important;
        }
        
        .notification-container .text-red-600 {
            color: rgb(220, 38, 38) !important;
        }
        
        .notification-container .text-yellow-600 {
            color: rgb(202, 138, 4) !important;
        }
        
        .notification-container .text-blue-600 {
            color: rgb(37, 99, 235) !important;
        }
        
        /* Progress bar styling */
        .notification-container .bg-gray-200 {
            background-color: rgb(229, 231, 235) !important;
        }
        
        /* Border styling */
        .notification-container .border-gray-200 {
            border-color: rgb(229, 231, 235) !important;
        }
        
        .notification-container .border-green-500 {
            border-color: rgb(34, 197, 94) !important;
        }
        
        .notification-container .border-red-500 {
            border-color: rgb(239, 68, 68) !important;
        }
        
        .notification-container .border-yellow-500 {
            border-color: rgb(245, 158, 11) !important;
        }
        
        .notification-container .border-blue-500 {
            border-color: rgb(59, 130, 246) !important;
        }
        
        .notification-container .border-gray-500 {
            border-color: rgb(107, 114, 128) !important;
        }
        
        /* Background colors */
        .notification-container .bg-green-50 {
            background-color: rgb(240, 253, 244) !important;
        }
        
        .notification-container .bg-red-50 {
            background-color: rgb(254, 242, 242) !important;
        }
        
        .notification-container .bg-yellow-50 {
            background-color: rgb(254, 252, 220) !important;
        }
        
        .notification-container .bg-blue-50 {
            background-color: rgb(239, 246, 255) !important;
        }
        
        .notification-container .bg-gray-50 {
            background-color: rgb(249, 250, 251) !important;
        }
        
        /* Sidebar transitions */
        .sidebar-transition {
            transition: all 0.3s ease;
        }
        
        /* Form styling */
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
        
        /* Modal styling */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 9998;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            max-width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            animation: modalFadeIn 0.3s ease-out;
        }
        
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        /* Icon styling */
        .icon-white {
            color: white !important;
            fill: white !important;
            stroke: white !important;
        }
        
        .icon-large {
            width: 20px;
            height: 20px;
        }
        
        .icon-medium {
            width: 16px;
            height: 16px;
        }
        
        .icon-small {
            width: 14px;
            height: 14px;
        }
        
        /* Icon visibility fixes */
        [data-icon] svg {
            display: inline-block !important;
            vertical-align: middle !important;
            width: 1em !important;
            height: 1em !important;
        }
        
        [data-icon] {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        /* Profile dropdown animations */
        .animate-fade-in {
            animation: fadeIn 0.2s ease-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Profile dropdown hover effects */
        #profile-dropdown {
            transition: all 0.2s ease;
        }
        
        #profile-dropdown button:hover,
        #profile-dropdown a:hover {
            transform: translateX(2px);
            transition: transform 0.2s ease;
        }
        
        /* Company switcher enhancements */
        select[onchange*="switchCompany"] {
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        
        select[onchange*="switchCompany"]:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 antialiased">
    @include('partials.notifications')
    
    <script>
        // Test icon rendering after page load
        setTimeout(() => {
            console.log('Testing icon rendering...');
            if (window.testIcons) {
                window.testIcons();
            } else {
                // Manual test
                const testIcon = document.querySelector('[data-icon="home"]');
                if (testIcon) {
                    testIcon.innerHTML = '<svg class="h-5 w-5" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7m-7-7v8m0 0l-7 7m7 7v8m0 0a9 9 0 00-9 9 9 9 0 0118 0z"></path></svg>';
                    console.log('Manual icon test applied');
                }
            }
        }, 500);
    </script>
    
    <div class="min-h-screen bg-gray-100 flex">
        <!-- Sidebar -->
        @include('partials.sidebar')
        
        <!-- Main Content Area (outside sidebar) -->
        <div id="main-content" class="flex-1 transition-all duration-300 ease-in-out bg-gray-50 overflow-hidden ml-64">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 fixed top-0 right-0 z-50 transition-all duration-300 left-64" id="top-header">
                <div class="px-2 sm:px-4 py-2 sm:py-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center flex-1 min-w-0">
                            <!-- Menu Icon (Always Visible) -->
                            <button onclick="toggleSidebar(event)" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors mr-2 sm:mr-3 bg-gray-200" title="Toggle Menu" aria-expanded="true">
                                <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                            </button>
                            
                            <!-- Mobile Title -->
                            <div class="lg:hidden flex-1 min-w-0">
                                <h1 class="text-lg sm:text-xl font-semibold text-gray-900 truncate">Dashboard</h1>
                            </div>
                            
                            <!-- Breadcrumb (hidden on mobile) -->
                            <nav class="hidden lg:flex space-x-1" aria-label="Breadcrumb">
                                <ol class="flex items-center space-x-2">
                                    <li>
                                        <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700">
                                            Dashboard
                                        </a>
                                    </li>
                                    @if(request()->segment(1))
                                        <li>
                                            <div class="flex items-center">
                                                <svg class="flex-shrink-0 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                                <span class="ml-2 text-sm font-medium text-gray-900 truncate max-w-[150px]">
                                                    {{ ucfirst(request()->segment(1)) }}
                                                </span>
                                            </div>
                                        </li>
                                    @endif
                                </ol>
                            </nav>
                        </div>
                        
                        <!-- Company Switcher (Middle) -->
                        <div class="hidden lg:flex items-center">
                            <div class="relative">
                                <button onclick="toggleHeaderCompanySwitcher()" class="flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    <span id="current-company-name" class="hidden sm:block">Tanzania Cigarette Company (TCC)</span>
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                
                                <!-- Company Dropdown -->
                                <div id="header-company-dropdown" class="hidden origin-top-right absolute right-0 mt-2 w-64 sm:w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                    <div class="py-1">
                                        <div class="px-4 py-2 border-b border-gray-100">
                                            <h3 class="text-sm font-medium text-gray-900">Switch Company</h3>
                                        </div>
                                        <div class="max-h-60 overflow-y-auto">
                                            <button onclick="switchHeaderCompany('tcc', 'Tanzania Cigarette Company (TCC)')" class="w-full text-left px-4 py-3 hover:bg-gray-50 border-b border-gray-100 flex items-center space-x-3">
                                                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <span class="text-xs font-medium text-blue-600">TCC</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Tanzania Cigarette Company</p>
                                                    <p class="text-xs text-gray-500">Tobacco Manufacturing</p>
                                                </div>
                                                @if(config('app.name', 'HR Management System') === 'Tanzania Cigarette Company (TCC)')
                                                    <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                            <button onclick="switchHeaderCompany('tbl', 'Tanzania Breweries Limited (TBL)')" class="w-full text-left px-4 py-3 hover:bg-gray-50 border-b border-gray-100 flex items-center space-x-3">
                                                <div class="flex-shrink-0 w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                                    <span class="text-xs font-medium text-yellow-600">TBL</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Tanzania Breweries Limited</p>
                                                    <p class="text-xs text-gray-500">Beverage Production</p>
                                                </div>
                                                @if(config('app.name', 'HR Management System') === 'Tanzania Breweries Limited (TBL)')
                                                    <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                            <button onclick="switchHeaderCompany('nmb', 'NMB Bank Plc')" class="w-full text-left px-4 py-3 hover:bg-gray-50 border-b border-gray-100 flex items-center space-x-3">
                                                <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                    <span class="text-xs font-medium text-green-600">NMB</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">NMB Bank Plc</p>
                                                    <p class="text-xs text-gray-500">Commercial Banking</p>
                                                </div>
                                                @if(config('app.name', 'HR Management System') === 'NMB Bank Plc')
                                                    <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                            <button onclick="switchHeaderCompany('crdb', 'CRDB Bank Plc')" class="w-full text-left px-4 py-3 hover:bg-gray-50 border-b border-gray-100 flex items-center space-x-3">
                                                <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                                    <span class="text-xs font-medium text-purple-600">CRDB</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">CRDB Bank Plc</p>
                                                    <p class="text-xs text-gray-500">Financial Services</p>
                                                </div>
                                                @if(config('app.name', 'HR Management System') === 'CRDB Bank Plc')
                                                    <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                            <button onclick="switchHeaderCompany('tigo', 'Tigo Tanzania')" class="w-full text-left px-4 py-3 hover:bg-gray-50 border-b border-gray-100 flex items-center space-x-3">
                                                <div class="flex-shrink-0 w-8 h-8 bg-cyan-100 rounded-full flex items-center justify-center">
                                                    <span class="text-xs font-medium text-cyan-600">TIGO</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Tigo Tanzania</p>
                                                    <p class="text-xs text-gray-500">Telecommunications</p>
                                                </div>
                                                @if(config('app.name', 'HR Management System') === 'Tigo Tanzania')
                                                    <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                            <button onclick="switchHeaderCompany('vodacom', 'Vodacom Tanzania')" class="w-full text-left px-4 py-3 hover:bg-gray-50 border-b border-gray-100 flex items-center space-x-3">
                                                <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                                    <span class="text-xs font-medium text-red-600">VODA</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Vodacom Tanzania</p>
                                                    <p class="text-xs text-gray-500">Mobile Network</p>
                                                </div>
                                                @if(config('app.name', 'HR Management System') === 'Vodacom Tanzania')
                                                    <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                            <button onclick="switchHeaderCompany('airtel', 'Airtel Tanzania')" class="w-full text-left px-4 py-3 hover:bg-gray-50 flex items-center space-x-3">
                                                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <span class="text-xs font-medium text-blue-600">AIRTEL</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Airtel Tanzania</p>
                                                    <p class="text-xs text-gray-500">Telecom Services</p>
                                                </div>
                                                @if(config('app.name', 'HR Management System') === 'Airtel Tanzania')
                                                    <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                            <button onclick="switchHeaderCompany('tanesco', 'TANESCO')" class="w-full text-left px-4 py-3 hover:bg-gray-50 flex items-center space-x-3">
                                                <div class="flex-shrink-0 w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                                    <span class="text-xs font-medium text-orange-600">TANESCO</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">TANESCO</p>
                                                    <p class="text-xs text-gray-500">Electricity Supply</p>
                                                </div>
                                                @if(config('app.name', 'HR Management System') === 'TANESCO')
                                                    <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                            <button onclick="switchHeaderCompany('twiga', 'Twiga Cement')" class="w-full text-left px-4 py-3 hover:bg-gray-50 flex items-center space-x-3">
                                                <div class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                                    <span class="text-xs font-medium text-gray-600">TWIGA</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Twiga Cement</p>
                                                    <p class="text-xs text-gray-500">Cement Manufacturing</p>
                                                </div>
                                                @if(config('app.name', 'HR Management System') === 'Twiga Cement')
                                                    <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                            <button onclick="switchHeaderCompany('azam', 'Azam Tanzania')" class="w-full text-left px-4 py-3 hover:bg-gray-50 flex items-center space-x-3">
                                                <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                                    <span class="text-xs font-medium text-indigo-600">AZAM</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Azam Tanzania</p>
                                                    <p class="text-xs text-gray-500">Industrial Conglomerate</p>
                                                </div>
                                                @if(config('app.name', 'HR Management System') === 'Azam Tanzania')
                                                    <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                            <button onclick="switchHeaderCompany('yara', 'Yara Tanzania')" class="w-full text-left px-4 py-3 hover:bg-gray-50 flex items-center space-x-3">
                                                <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                    <span class="text-xs font-medium text-green-600">YARA</span>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">Yara Tanzania</p>
                                                    <p class="text-xs text-gray-500">Agricultural Solutions</p>
                                                </div>
                                                @if(config('app.name', 'HR Management System') === 'Yara Tanzania')
                                                    <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Online Status & Time -->
                            <div class="hidden md:flex items-center space-x-3 text-sm text-gray-600">
                                <!-- Online Status -->
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                        <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <circle cx="10" cy="10" r="3"></circle>
                                        </svg>
                                        Online
                                    </span>
                                </div>
                                
                                <!-- Current Time -->
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span id="current-time">{{ date('g:i A') }}</span>
                                </div>
                            </div>
                            
                            <!-- Notifications -->
                            <div class="relative">
                                <button class="p-1.5 sm:p-2 rounded-full text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors" data-notifications-btn="true">
                                    <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0v1a3 3 0 01-6 0v-1m6 0H9"></path>
                                    </svg>
                                    
                                    @if(session()->has('unread_notifications'))
                                        <span class="absolute top-0 right-0 block h-2 w-2 sm:h-2.5 sm:w-2.5 rounded-full bg-red-500 ring-2 ring-white"></span>
                                    @endif
                                </button>
                                
                                <!-- Notifications Dropdown -->
                                <div id="notifications-dropdown" class="hidden origin-top-right absolute right-0 mt-2 w-72 sm:w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="py-1">
                                        <div class="px-3 sm:px-4 py-2 border-b border-gray-100">
                                            <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                                        </div>
                                        <div class="max-h-60 overflow-y-auto">
                                            @if(session()->has('unread_notifications'))
                                                @foreach(session()->get('unread_notifications') as $notification)
                                                    <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                                                        <div class="flex items-start">
                                                            <div class="flex-shrink-0">
                                                                @if($notification['type'] === 'success')
                                                                    <svg class="h-6 w-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                @elseif($notification['type'] === 'error')
                                                                    <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2 2m2 2l2 2m7-5a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                @else
                                                                    <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                @endif
                                                            </div>
                                                            <div class="ml-3 flex-1">
                                                                <p class="text-sm font-medium text-gray-900">{{ $notification['title'] }}</p>
                                                                <p class="mt-1 text-sm text-gray-600">{{ $notification['message'] }}</p>
                                                                <p class="mt-1 text-xs text-gray-500">{{ date('M j, Y H:i', strtotime($notification['timestamp'])) }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="px-4 py-6 text-center text-gray-500">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 00-2 2v4" />
                                                    </svg>
                                                    <p class="mt-2">No notifications</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Advanced User Profile -->
                            <div class="relative">
                                <button onclick="toggleProfileDropdown()" class="flex items-center text-sm rounded-full hover:bg-gray-100 p-1.5 sm:p-2 transition-colors" data-profile-btn="true">
                                    <img class="h-7 w-7 sm:h-8 sm:w-8 rounded-full" src="{{ Auth::user()->profile_photo ?? asset('images/default-avatar.png') }}" alt="{{ Auth::user()->name }}">
                                    <span class="hidden sm:block ml-2 font-medium text-gray-700">{{ Auth::user()->name }}</span>
                                    <svg class="ml-1 sm:ml-2 h-3.5 w-3.5 sm:h-4 sm:w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                
                                <!-- Profile Dropdown -->
                                <div id="profile-dropdown" class="hidden origin-top-right absolute right-0 mt-3 w-80 sm:w-96 rounded-2xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden transform transition-all duration-200 scale-95 opacity-0">
                                    <div class="relative">
                                        <!-- Gradient Header -->
                                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-4 sm:px-6 py-3 sm:py-4">
                                            <div class="flex items-center">
                                                <div class="relative">
                                                    <img class="h-14 w-14 sm:h-16 sm:w-16 rounded-full border-3 border-white shadow-lg" src="{{ Auth::user()->profile_photo ?? asset('images/default-avatar.png') }}" alt="{{ Auth::user()->name }}">
                                                    <div class="absolute bottom-0 right-0 h-3.5 w-3.5 sm:h-4 sm:w-4 bg-green-400 border-2 border-white rounded-full"></div>
                                                </div>
                                                <div class="ml-3 sm:ml-4 flex-1 min-w-0">
                                                    <p class="text-base sm:text-lg font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                                                    <p class="text-xs sm:text-sm text-indigo-100 truncate">{{ Auth::user()->email }}</p>
                                                    <div class="flex items-center mt-1 sm:mt-2">
                                                        <span class="inline-flex items-center px-2 sm:px-2.5 py-0.5 rounded-full text-xs font-medium bg-white/20 text-white backdrop-blur-sm">
                                                            <svg class="w-2.5 h-2.5 sm:w-3 sm:h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000-16zm3.707-9.293a1 1 0 00-1.414-1.414 1 1 0 001.414 1.414l-.707.707a1 1 0 00-.004-.002V8.5a.5.5 0 00-.5-.5V4.5a.5.5 0 00-.5-.5z" />
                                                            </svg>
                                                            Active Now
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Stats Cards -->
                                        <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gray-50 border-b border-gray-100">
                                            <div class="grid grid-cols-3 gap-2 sm:gap-4">
                                                <div class="text-center">
                                                    <p class="text-xl sm:text-2xl font-bold text-gray-900">24</p>
                                                    <p class="text-xs text-gray-500">Tasks</p>
                                                </div>
                                                <div class="text-center border-x border-gray-200">
                                                    <p class="text-xl sm:text-2xl font-bold text-gray-900">8</p>
                                                    <p class="text-xs text-gray-500">Projects</p>
                                                </div>
                                                <div class="text-center">
                                                    <p class="text-xl sm:text-2xl font-bold text-gray-900">92%</p>
                                                    <p class="text-xs text-gray-500">Complete</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Time Display -->
                                        <div class="px-4 sm:px-6 py-3 sm:py-4 bg-white border-b border-gray-100">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div class="flex items-center justify-center w-8 h-8 sm:w-10 sm:h-10 bg-indigo-100 rounded-lg">
                                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3">
                                                        <p class="text-sm font-medium text-gray-900">{{ date('g:i A') }}</p>
                                                        <p class="text-xs text-gray-500">{{ date('l M d, Y') }}</p>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <span class="inline-flex items-center px-2 sm:px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        On Time
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Menu Items -->
                                        <div class="py-2">
                                            <a href="{{ route('profile') }}" class="group flex items-center px-4 sm:px-6 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                                <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg group-hover:bg-indigo-100 transition-colors">
                                                    <svg class="h-4 w-4 text-gray-600 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                </div>
                                                <span class="ml-3 font-medium">View Profile</span>
                                                <svg class="ml-auto h-4 w-4 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                            
                                            <a href="{{ route('settings') }}" class="group flex items-center px-4 sm:px-6 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors">
                                                <div class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-lg group-hover:bg-indigo-100 transition-colors">
                                                    <svg class="h-4 w-4 text-gray-600 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 1.756-1.756H11.175v-2.236c0-1.18.91-2.175 2.175-2.175H8.25c0-1.18.91-2.175 2.175-2.175v13.53c0 1.473.31 2.175 2.175 2.175h1.354l3.417 3.417c.426 1.756 1.756 1.756h-1.354v-2.236c0-1.18.91-2.175 2.175-2.175H8.25c0-1.18.91-2.175 2.175-2.175v13.53c0 1.473.31 2.175 2.175 2.175h1.354z" />
                                                    </svg>
                                                </div>
                                                <span class="ml-3 font-medium">Settings</span>
                                                <svg class="ml-auto h-4 w-4 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                            
                                            <div class="border-t border-gray-100 my-2"></div>
                                            
                                            <form action="{{ route('logout') }}" method="POST" class="block">
                                                @csrf
                                                <button type="submit" class="group flex items-center w-full px-4 sm:px-6 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                                    <div class="flex items-center justify-center w-8 h-8 bg-red-100 rounded-lg group-hover:bg-red-200 transition-colors">
                                                        <svg class="h-4 w-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                        </svg>
                                                    </div>
                                                    <span class="ml-3 font-medium">Logout</span>
                                                    <svg class="ml-auto h-4 w-4 text-red-400 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Settings -->
                            <a href="{{ route('system.settings') }}" class="p-1 rounded-full text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 1.756-1.756H11.175v-2.236c0-1.18.91-2.175 2.175-2.175H8.25c0-1.18.91-2.175 2.175-2.175v13.53c0 1.473.31 2.175 2.175 2.175h1.354l3.417 3.417c.426 1.756 1.756 1.756h-1.354v-2.236c0-1.18.91-2.175 2.175-2.175H8.25c0-1.18.91-2.175 2.175-2.175v13.53c0 1.473.31 2.175 2.175 2.175h1.354z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="pt-16">
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Idle Warning Modal -->
    @include('partials.idle-modal')
    
    <!-- JavaScript -->
    <script src="{{ asset('resources/js/app-blade.js') }}" defer></script>
    
    <!-- Enhanced Dropdown Functionality -->
    <script>
    // Notification System
    function showNotification(type, title, message) {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.notification-toast');
        existingNotifications.forEach(notification => notification.remove());
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification-toast fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
        
        // Set background color based on type
        const bgColors = {
            'success': 'bg-green-500',
            'error': 'bg-red-500',
            'warning': 'bg-yellow-500',
            'info': 'bg-blue-500'
        };
        
        notification.classList.add(bgColors[type] || 'bg-gray-500');
        
        // Create notification content
        notification.innerHTML = `
            <div class="flex items-center text-white">
                <div class="flex-shrink-0">
                    ${getNotificationIcon(type)}
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">${title}</p>
                    <p class="text-sm">${message}</p>
                </div>
                <div class="ml-4 flex-shrink-0">
                    <button onclick="this.parentElement.parentElement.remove()" class="text-white hover:text-gray-200">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        `;
        
        // Add to body
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
            notification.classList.add('translate-x-0');
        }, 100);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.classList.add('translate-x-full');
                setTimeout(() => notification.remove(), 300);
            }
        }, 5000);
    }
    
    function getNotificationIcon(type) {
        const icons = {
            'success': '<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
            'error': '<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>',
            'warning': '<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
            'info': '<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>'
        };
        return icons[type] || icons['info'];
    }
    
    // Enhanced Profile Dropdown Script
    function toggleProfileDropdown() {
        console.log('Profile dropdown toggle called');
        const dropdown = document.getElementById('profile-dropdown');
        const button = document.querySelector('[data-profile-btn="true"]');
        
        if (!dropdown) {
            console.error('Profile dropdown element not found');
            return;
        }
        
        const isHidden = dropdown.classList.contains('hidden');
        console.log('Profile dropdown isHidden:', isHidden);
        
        if (isHidden) {
            // Show dropdown with animation
            dropdown.classList.remove('hidden');
            dropdown.classList.remove('scale-95', 'opacity-0');
            dropdown.classList.add('scale-100', 'opacity-100');
            
            // Update button state
            if (button) {
                button.classList.add('bg-gray-200');
                button.setAttribute('aria-expanded', 'true');
            }
            
            // Add click outside listener
            setTimeout(() => {
                document.addEventListener('click', handleProfileDropdownClickOutside);
            }, 100);
        } else {
            // Hide dropdown with animation
            dropdown.classList.remove('scale-100', 'opacity-100');
            dropdown.classList.add('scale-95', 'opacity-0');
            
            // Update button state
            if (button) {
                button.classList.remove('bg-gray-200');
                button.setAttribute('aria-expanded', 'false');
            }
            
            // Remove click outside listener
            document.removeEventListener('click', handleProfileDropdownClickOutside);
        }
    }
    
    function handleProfileDropdownClickOutside(event) {
        const dropdown = document.getElementById('profile-dropdown');
        const button = document.querySelector('[data-profile-btn="true"]');
        
        // Check if click is outside dropdown and button
        if (dropdown && !dropdown.contains(event.target) && 
            button && !button.contains(event.target) &&
            !event.target.closest('#profile-dropdown') &&
            !event.target.closest('[data-profile-btn="true"]')) {
            
            // Hide dropdown
            dropdown.classList.add('hidden');
            dropdown.classList.remove('scale-100', 'opacity-100');
            dropdown.classList.add('scale-95', 'opacity-0');
            
            // Update button state
            if (button) {
                button.classList.remove('bg-gray-200');
                button.setAttribute('aria-expanded', 'false');
            }
            
            // Remove click outside listener
            document.removeEventListener('click', handleProfileDropdownClickOutside);
        }
    }
    
    // Header Company Switcher
    function toggleHeaderCompanySwitcher() {
        console.log('Company switcher toggle called');
        const dropdown = document.getElementById('header-company-dropdown');
        if (dropdown) {
            const isHidden = dropdown.classList.contains('hidden');
            console.log('Company dropdown isHidden:', isHidden);
            
            if (isHidden) {
                dropdown.classList.remove('hidden');
                dropdown.classList.add('animate-fade-in');
            } else {
                dropdown.classList.add('hidden');
                dropdown.classList.remove('animate-fade-in');
            }
        }
    }
    
    function switchHeaderCompany(companyId, companyName) {
        console.log('Switching to company:', companyId, companyName);
        
        // Update current company name display
        const currentCompanyElement = document.getElementById('current-company-name');
        if (currentCompanyElement) {
            currentCompanyElement.textContent = companyName;
        }
        
        // Update page title
        document.title = `${companyName} - HR Management System`;
        
        // Update sidebar menu items based on company
        updateSidebarMenu(companyId, companyName);
        
        // Close dropdown
        const dropdown = document.getElementById('header-company-dropdown');
        if (dropdown) {
            dropdown.classList.add('hidden');
        }
        
        // Show notification
        showNotification('success', 'Company Switched', `Successfully switched to ${companyName}`);
        
        // Store company preference
        localStorage.setItem('activeCompany', companyId);
        localStorage.setItem('activeCompanyName', companyName);
        
        // Trigger company changed event
        window.dispatchEvent(new CustomEvent('companyChanged', {
            detail: { companyId, companyName }
        }));
    }
    
    // Update sidebar menu items based on company
    function updateSidebarMenu(companyId, companyName) {
        const companyMenuTexts = {
            'hr-system': {
                'dashboard': 'Dashboard',
                'employee-management': 'Employee Management',
                'add-employee': 'Add Employee',
                'contracts': 'Contracts',
                'departments': 'Departments',
                'payroll-management': 'Payroll Management',
                'payroll-history': 'Payroll History',
                'statutory-deductions': 'Statutory Deductions',
                'payroll-reports': 'Payroll Reports',
                'discipline-management': 'Discipline Management',
                'compliance-management': 'Compliance Management',
                'attendance-management': 'Attendance Management',
                'leave-management': 'Leave Management',
                'recruitment-management': 'Recruitment Management',
                'performance-management': 'Performance Management',
                'training-management': 'Training Management',
                'system-management': 'System Management'
            },
            'tcc': {
                'dashboard': 'TCC Dashboard',
                'employee-management': 'TCC Staff Management',
                'add-employee': 'Add TCC Staff',
                'contracts': 'TCC Contracts',
                'departments': 'TCC Departments',
                'payroll-management': 'TCC Payroll',
                'payroll-history': 'TCC Payroll History',
                'statutory-deductions': 'TCC Deductions',
                'payroll-reports': 'TCC Payroll Reports',
                'discipline-management': 'TCC Discipline',
                'compliance-management': 'TCC Compliance',
                'attendance-management': 'TCC Attendance',
                'leave-management': 'TCC Leave',
                'recruitment-management': 'TCC Recruitment',
                'performance-management': 'TCC Performance',
                'training-management': 'TCC Training',
                'system-management': 'TCC Systems'
            },
            'tbl': {
                'dashboard': 'TBL Dashboard',
                'employee-management': 'TBL Staff Management',
                'add-employee': 'Add TBL Staff',
                'contracts': 'TBL Contracts',
                'departments': 'TBL Departments',
                'payroll-management': 'TBL Payroll',
                'payroll-history': 'TBL Payroll History',
                'statutory-deductions': 'TBL Deductions',
                'payroll-reports': 'TBL Payroll Reports',
                'discipline-management': 'TBL Discipline',
                'compliance-management': 'TBL Compliance',
                'attendance-management': 'TBL Attendance',
                'leave-management': 'TBL Leave',
                'recruitment-management': 'TBL Recruitment',
                'performance-management': 'TBL Performance',
                'training-management': 'TBL Training',
                'system-management': 'TBL Systems'
            },
            'nmb': {
                'dashboard': 'NMB Dashboard',
                'employee-management': 'NMB Staff Management',
                'add-employee': 'Add NMB Staff',
                'contracts': 'NMB Contracts',
                'departments': 'NMB Branches',
                'payroll-management': 'NMB Payroll',
                'payroll-history': 'NMB Payroll History',
                'statutory-deductions': 'NMB Deductions',
                'payroll-reports': 'NMB Payroll Reports',
                'discipline-management': 'NMB Discipline',
                'compliance-management': 'NMB Compliance',
                'attendance-management': 'NMB Attendance',
                'leave-management': 'NMB Leave',
                'recruitment-management': 'NMB Recruitment',
                'performance-management': 'NMB Performance',
                'training-management': 'NMB Training',
                'system-management': 'NMB Systems'
            },
            'crdb': {
                'dashboard': 'CRDB Dashboard',
                'employee-management': 'CRDB Staff Management',
                'add-employee': 'Add CRDB Staff',
                'contracts': 'CRDB Contracts',
                'departments': 'CRDB Branches',
                'payroll-management': 'CRDB Payroll',
                'payroll-history': 'CRDB Payroll History',
                'statutory-deductions': 'CRDB Deductions',
                'payroll-reports': 'CRDB Payroll Reports',
                'discipline-management': 'CRDB Discipline',
                'compliance-management': 'CRDB Compliance',
                'attendance-management': 'CRDB Attendance',
                'leave-management': 'CRDB Leave',
                'recruitment-management': 'CRDB Recruitment',
                'performance-management': 'CRDB Performance',
                'training-management': 'CRDB Training',
                'system-management': 'CRDB Systems'
            },
            'tigo': {
                'dashboard': 'Tigo Dashboard',
                'employee-management': 'Tigo Staff Management',
                'add-employee': 'Add Tigo Staff',
                'contracts': 'Tigo Contracts',
                'departments': 'Tigo Departments',
                'payroll-management': 'Tigo Payroll',
                'payroll-history': 'Tigo Payroll History',
                'statutory-deductions': 'Tigo Deductions',
                'payroll-reports': 'Tigo Payroll Reports',
                'discipline-management': 'Tigo Discipline',
                'compliance-management': 'Tigo Compliance',
                'attendance-management': 'Tigo Attendance',
                'leave-management': 'Tigo Leave',
                'recruitment-management': 'Tigo Recruitment',
                'performance-management': 'Tigo Performance',
                'training-management': 'Tigo Training',
                'system-management': 'Tigo Systems'
            },
            'vodacom': {
                'dashboard': 'Vodacom Dashboard',
                'employee-management': 'Vodacom Staff Management',
                'add-employee': 'Add Vodacom Staff',
                'contracts': 'Vodacom Contracts',
                'departments': 'Vodacom Departments',
                'payroll-management': 'Vodacom Payroll',
                'payroll-history': 'Vodacom Payroll History',
                'statutory-deductions': 'Vodacom Deductions',
                'payroll-reports': 'Vodacom Payroll Reports',
                'discipline-management': 'Vodacom Discipline',
                'compliance-management': 'Vodacom Compliance',
                'attendance-management': 'Vodacom Attendance',
                'leave-management': 'Vodacom Leave',
                'recruitment-management': 'Vodacom Recruitment',
                'performance-management': 'Vodacom Performance',
                'training-management': 'Vodacom Training',
                'system-management': 'Vodacom Systems'
            },
            'airtel': {
                'dashboard': 'Airtel Dashboard',
                'employee-management': 'Airtel Staff Management',
                'add-employee': 'Add Airtel Staff',
                'contracts': 'Airtel Contracts',
                'departments': 'Airtel Departments',
                'payroll-management': 'Airtel Payroll',
                'payroll-history': 'Airtel Payroll History',
                'statutory-deductions': 'Airtel Deductions',
                'payroll-reports': 'Airtel Payroll Reports',
                'discipline-management': 'Airtel Discipline',
                'compliance-management': 'Airtel Compliance',
                'attendance-management': 'Airtel Attendance',
                'leave-management': 'Airtel Leave',
                'recruitment-management': 'Airtel Recruitment',
                'performance-management': 'Airtel Performance',
                'training-management': 'Airtel Training',
                'system-management': 'Airtel Systems'
            },
            'tanesco': {
                'dashboard': 'TANESCO Dashboard',
                'employee-management': 'TANESCO Staff Management',
                'add-employee': 'Add TANESCO Staff',
                'contracts': 'TANESCO Contracts',
                'departments': 'TANESCO Departments',
                'payroll-management': 'TANESCO Payroll',
                'payroll-history': 'TANESCO Payroll History',
                'statutory-deductions': 'TANESCO Deductions',
                'payroll-reports': 'TANESCO Payroll Reports',
                'discipline-management': 'TANESCO Discipline',
                'compliance-management': 'TANESCO Compliance',
                'attendance-management': 'TANESCO Attendance',
                'leave-management': 'TANESCO Leave',
                'recruitment-management': 'TANESCO Recruitment',
                'performance-management': 'TANESCO Performance',
                'training-management': 'TANESCO Training',
                'system-management': 'TANESCO Systems'
            },
            'twiga': {
                'dashboard': 'Twiga Dashboard',
                'employee-management': 'Twiga Staff Management',
                'add-employee': 'Add Twiga Staff',
                'contracts': 'Twiga Contracts',
                'departments': 'Twiga Departments',
                'payroll-management': 'Twiga Payroll',
                'payroll-history': 'Twiga Payroll History',
                'statutory-deductions': 'Twiga Deductions',
                'payroll-reports': 'Twiga Payroll Reports',
                'discipline-management': 'Twiga Discipline',
                'compliance-management': 'Twiga Compliance',
                'attendance-management': 'Twiga Attendance',
                'leave-management': 'Twiga Leave',
                'recruitment-management': 'Twiga Recruitment',
                'performance-management': 'Twiga Performance',
                'training-management': 'Twiga Training',
                'system-management': 'Twiga Systems'
            },
            'azam': {
                'dashboard': 'Azam Dashboard',
                'employee-management': 'Azam Staff Management',
                'add-employee': 'Add Azam Staff',
                'contracts': 'Azam Contracts',
                'departments': 'Azam Departments',
                'payroll-management': 'Azam Payroll',
                'payroll-history': 'Azam Payroll History',
                'statutory-deductions': 'Azam Deductions',
                'payroll-reports': 'Azam Payroll Reports',
                'discipline-management': 'Azam Discipline',
                'compliance-management': 'Azam Compliance',
                'attendance-management': 'Azam Attendance',
                'leave-management': 'Azam Leave',
                'recruitment-management': 'Azam Recruitment',
                'performance-management': 'Azam Performance',
                'training-management': 'Azam Training',
                'system-management': 'Azam Systems'
            },
            'yara': {
                'dashboard': 'Yara Dashboard',
                'employee-management': 'Yara Staff Management',
                'add-employee': 'Add Yara Staff',
                'contracts': 'Yara Contracts',
                'departments': 'Yara Departments',
                'payroll-management': 'Yara Payroll',
                'payroll-history': 'Yara Payroll History',
                'statutory-deductions': 'Yara Deductions',
                'payroll-reports': 'Yara Payroll Reports',
                'discipline-management': 'Yara Discipline',
                'compliance-management': 'Yara Compliance',
                'attendance-management': 'Yara Attendance',
                'leave-management': 'Yara Leave',
                'recruitment-management': 'Yara Recruitment',
                'performance-management': 'Yara Performance',
                'training-management': 'Yara Training',
                'system-management': 'Yara Systems'
            }
        };
        
        const menuTexts = companyMenuTexts[companyId] || companyMenuTexts['hr-system'];
        
        // Update all menu items
        Object.keys(menuTexts).forEach(menuItem => {
            const element = document.querySelector(`[data-menu-item="${menuItem}"]`);
            if (element) {
                element.textContent = menuTexts[menuItem];
            }
        });
        
        console.log(`Updated sidebar menu for ${companyName}`);
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing dropdowns and company switcher...');
        
        // Test profile dropdown functionality
        const profileButton = document.querySelector('[data-profile-btn="true"]');
        const dropdown = document.getElementById('profile-dropdown');
        
        if (profileButton) {
            console.log('Profile button found:', profileButton);
            
            // Add click event listener
            profileButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleProfileDropdown();
            });
            
            // Add keyboard support
            profileButton.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggleProfileDropdown();
                }
            });
        }
        
        if (dropdown) {
            console.log('Profile dropdown found:', dropdown);
            
            // Add hover effects
            dropdown.addEventListener('mouseenter', function() {
                this.classList.remove('scale-95');
                this.classList.add('scale-100');
            });
            
            dropdown.addEventListener('mouseleave', function() {
                this.classList.remove('scale-100');
                this.classList.add('scale-95');
            });
        }
        
        // Initialize company switcher
        const activeCompany = localStorage.getItem('activeCompany') || 'tcc';
        const activeCompanyName = localStorage.getItem('activeCompanyName') || 'Tanzania Cigarette Company (TCC)';
        
        // Update current company display if not already set
        const currentCompanyElement = document.getElementById('current-company-name');
        if (currentCompanyElement && !currentCompanyElement.textContent.includes('TCC')) {
            currentCompanyElement.textContent = activeCompanyName;
        }
        
        // Update sidebar menu for default company
        updateSidebarMenu(activeCompany, activeCompanyName);
        
        // Add escape key support
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const dropdown = document.getElementById('profile-dropdown');
                const button = document.querySelector('[data-profile-btn="true"]');
                
                if (dropdown && !dropdown.classList.contains('hidden')) {
                    toggleProfileDropdown();
                }
                
                // Also close company dropdown
                const companyDropdown = document.getElementById('header-company-dropdown');
                if (companyDropdown && !companyDropdown.classList.contains('hidden')) {
                    companyDropdown.classList.add('hidden');
                }
            }
        });
        
        console.log('Dropdowns and company switcher initialized successfully');
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        // Profile dropdown
        const profileDropdown = document.getElementById('profile-dropdown');
        const profileButton = document.querySelector('[data-profile-btn="true"]');
        
        if (profileDropdown && !profileDropdown.classList.contains('hidden')) {
            if (!profileDropdown.contains(event.target) && (!profileButton || !profileButton.contains(event.target))) {
                toggleProfileDropdown();
            }
        }
        
        // Company dropdown
        const companyDropdown = document.getElementById('header-company-dropdown');
        const companyButton = event.target.closest('[onclick*="toggleHeaderCompanySwitcher"]');
        
        if (companyDropdown && !companyDropdown.classList.contains('hidden')) {
            if (!companyButton && !companyDropdown.contains(event.target)) {
                companyDropdown.classList.add('hidden');
            }
        }
    });
    
    // Add CSS for animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fade-in 0.2s ease-out;
        }
        
        .notification-toast {
            min-width: 300px;
            max-width: 500px;
        }
        
        .translate-x-full {
            transform: translateX(100%);
        }
        
        .translate-x-0 {
            transform: translateX(0);
        }
    `;
    document.head.appendChild(style);
    
    console.log('Enhanced dropdown system loaded');
    </script>
    
    @stack('scripts')
</body>
</html>
