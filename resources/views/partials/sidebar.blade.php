<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 z-50 w-64 h-screen bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 overflow-y-auto">
    <div class="flex items-center justify-center h-16 shrink-0 px-4 bg-gradient-to-r from-indigo-600 to-purple-600">
        <h1 class="text-xl font-bold text-white">HR System</h1>
    </div>
    
    <nav class="mt-5 px-2">
        <!-- Dashboard -->
        <div class="mb-2">
            <a href="{{ route('dashboard') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <span data-icon="home" class="mr-3 icon-medium"></span>
                Dashboard
            </a>
        </div>
        
        <!-- Employee Management -->
        <div class="mb-2">
            <button onclick="toggleDropdown('employees')" class="w-full group flex items-center px-2 py-2 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                <span data-icon="users" class="mr-3 icon-medium"></span>
                Employee Management
                <svg class="ml-auto h-4 w-4 icon-small transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            
            <!-- Employee Submenu -->
            <div id="employees-dropdown" class="hidden mt-2 space-y-1">
                <a href="{{ route('employees.add') }}" class="block pl-8 pr-2 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50">
                    <span data-icon="user" class="mr-2 icon-small"></span>
                    Add Employee
                </a>
                <a href="{{ route('employees.contracts') }}" class="block pl-8 pr-2 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50">
                    <span data-icon="document" class="mr-2 icon-small"></span>
                    Contracts
                </a>
                <a href="{{ route('employees.departments') }}" class="block pl-8 pr-2 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50">
                    <span data-icon="building" class="mr-2 icon-small"></span>
                    Departments
                </a>
            </div>
        </div>
        
        <!-- Payroll Management -->
        <div class="mb-2">
            <button onclick="toggleDropdown('payroll')" class="w-full group flex items-center px-2 py-2 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                <span data-icon="money" class="mr-3 icon-medium"></span>
                Payroll Management
                <svg class="ml-auto h-4 w-4 icon-small transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            
            <!-- Payroll Submenu -->
            <div id="payroll-dropdown" class="hidden mt-2 space-y-1">
                <a href="{{ route('payroll.history') }}" class="block pl-8 pr-2 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50">
                    <span data-icon="clock" class="mr-2 icon-small"></span>
                    Payroll History
                </a>
                <a href="{{ route('payroll.statutory') }}" class="block pl-8 pr-2 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50">
                    <span data-icon="shield" class="mr-2 icon-small"></span>
                    Statutory Deductions
                </a>
                <a href="{{ route('payroll.reports') }}" class="block pl-8 pr-2 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50">
                    <span data-icon="chart" class="mr-2 icon-small"></span>
                    Payroll Reports
                </a>
            </div>
        </div>
        
        <!-- Discipline Management -->
        <a href="{{ route('discipline') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('discipline') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <span data-icon="warning" class="mr-3 icon-medium"></span>
            Discipline Management
        </a>
        
        <!-- Compliance Management -->
        <a href="{{ route('compliance') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('compliance') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <span data-icon="shield" class="mr-3 icon-medium"></span>
            Compliance Management
        </a>
        
        <!-- Attendance Management -->
        <a href="{{ route('attendance') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('attendance') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <span data-icon="clock" class="mr-3 icon-medium"></span>
            Attendance Management
        </a>
        
        <!-- Leave Management -->
        <a href="{{ route('leave') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('leave') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <span data-icon="calendar" class="mr-3 icon-medium"></span>
            Leave Management
        </a>
        
        <!-- Recruitment Management -->
        <a href="{{ route('recruitment') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('recruitment') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <span data-icon="users" class="mr-3 icon-medium"></span>
            Recruitment Management
        </a>
        
        <!-- Performance Management -->
        <a href="{{ route('performance') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('performance') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <span data-icon="chart" class="mr-3 icon-medium"></span>
            Performance Management
        </a>
        
        <!-- Training Management -->
        <a href="{{ route('training') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('training') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <span data-icon="book" class="mr-3 icon-medium"></span>
            Training Management
        </a>
        
        <!-- System Management -->
        <a href="{{ route('system') }}" class="group flex items-center px-2 py-2 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('system') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <span data-icon="cog" class="mr-3 icon-medium"></span>
            </svg>
            System Management
        </a>
    </nav>
    
    <!-- User Profile -->
    <div class="absolute bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <img class="h-8 w-8 rounded-full" src="{{ Auth::user()->profile_photo ?? asset('images/default-avatar.png') }}" alt="{{ Auth::user()->name }}">
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="ml-auto">
                @csrf
                <button type="submit" class="flex items-center text-gray-600 hover:text-gray-900">
                    <svg class="h-4 w-4 icon-small" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4v6m0 0a9 9 0 00-9 9 9 0 0118 0z" />
                    </svg>
                    <span class="ml-2 text-sm">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
