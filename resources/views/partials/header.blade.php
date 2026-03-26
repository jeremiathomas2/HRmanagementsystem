<!-- Top Header -->
<header class="bg-white shadow-sm border-b border-gray-200 fixed top-0 right-0 z-50 transition-all duration-300 lg:left-64" id="top-header">
    <div class="px-3 sm:px-6 py-3 sm:py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <!-- Mobile Menu Toggle Button -->
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors mr-3">
                    <svg class="h-6 w-6 icon-medium" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7m0 6h7m0 6h7" />
                    </svg>
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7" />
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
                        <svg class="h-6 w-6 icon-medium" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0v1a3 3 0 016 0v-1m-6 0v1a3 3 0 00-6 0v-1" />
                        </svg>
                        
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
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2 2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 118 0z" />
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
                    <svg class="h-6 w-6 icon-medium" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 1.756-1.756H11.175v-2.236c0-1.18.91-2.175 2.175-2.175H8.25c0-1.18.91-2.175 2.175-2.175v13.53c0 1.473.31 2.175 2.175 2.175h1.354l3.417 3.417c.426 1.756 1.756 1.756h-1.354v-2.236c0-1.18.91-2.175 2.175-2.175H8.25c0-1.18.91-2.175 2.175-2.175v13.53c0 1.473.31 2.175 2.175 2.175h1.354z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</header>
