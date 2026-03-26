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
    </style>
</head>
<body class="bg-gray-50 antialiased">
    @include('partials.notifications')
    
    <div class="min-h-screen bg-gray-100 flex">
        <!-- Sidebar -->
        @include('partials.sidebar')
        
        <!-- Main Content Area (outside sidebar) -->
        <div id="main-content" class="flex-1 transition-all duration-300 ease-in-out bg-gray-50 overflow-hidden lg:ml-64">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 fixed top-0 right-0 z-50 transition-all duration-300 lg:left-64" id="top-header">
                <div class="px-3 sm:px-6 py-3 sm:py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <!-- Mobile Menu Toggle Button -->
                            <button onclick="toggleSidebar()" class="lg:hidden p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors mr-3">
                                <span data-icon="menu" class="h-6 w-6 icon-medium"></span>
                            </button>
                            
                            <!-- Breadcrumb -->
                            <nav class="hidden md:flex space-x-1" aria-label="Breadcrumb">
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
                                                <span class="ml-2 text-sm font-medium text-gray-900">
                                                    {{ ucfirst(request()->segment(1)) }}
                                                </span>
                                            </div>
                                        </li>
                                    @endif
                                </ol>
                            </nav>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <div class="relative">
                                <button onclick="toggleNotifications()" class="p-1 rounded-full text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <span data-icon="notifications" class="h-6 w-6 icon-medium"></span>
                                    
                                    @if(session()->has('unread_notifications'))
                                        <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"></span>
                                    @endif
                                </button>
                                
                                <!-- Notifications Dropdown -->
                                <div id="notifications-dropdown" class="hidden origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <div class="py-1">
                                        <div class="px-4 py-2 border-b border-gray-100">
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
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 118 0z" />
                                                                    </svg>
                                                                @elseif($notification['type'] === 'error')
                                                                    <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2 2m2 2l2 2m7-5a9 9 0 11-18 0 9 9 0 118 0z" />
                                                                    </svg>
                                                                @else
                                                                    <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 118 0z" />
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
                            
                            <!-- Settings -->
                            <a href="{{ route('system.settings') }}" class="p-1 rounded-full text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span data-icon="settings" class="h-6 w-6 icon-medium"></span>
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
    
    @stack('scripts')
</body>
</html>
