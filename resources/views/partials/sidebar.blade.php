<!-- Sidebar -->
<aside id="sidebar" class="fixed top-0 left-0 z-50 w-64 h-screen shadow-lg transform transition-transform duration-300 ease-in-out translate-x-0 overflow-y-auto" style="background-color: #070029;">
    <div class="flex items-center justify-center h-14 sm:h-16 shrink-0 px-4" style="background-color: #040017;">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center shadow-sm">
                <img src="{{ asset('images/logos/orvion-logo.png') }}" alt="Orvion" class="w-8 h-8 object-contain">
            </div>
            <h1 class="text-lg sm:text-xl font-bold text-white">HR System</h1>
        </div>
    </div>
    
    <nav class="mt-4 sm:mt-5 px-2">
        <!-- Dashboard -->
        <div class="mb-2">
            <a href="{{ route('dashboard') }}" onclick="navigateTo('dashboard')" class="group flex items-center px-2 py-2.5 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('dashboard') ? 'bg-gray-100 text-gray-900' : 'text-white hover:bg-gray-50 hover:text-gray-900' }}">
                <svg class="mr-3 h-5 w-5 group-hover:stroke-gray-900" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7m-7-7v8m0 0l-7 7m7 7v8m0 0a9 9 0 00-9 9 9 9 0 0118 0z"></path>
                </svg>
                <span data-menu-item="dashboard" class="text-sm">Dashboard</span>
            </a>
        </div>
        
        <!-- Employee Management -->
        <div class="mb-2">
            <button onclick="toggleDropdown('employees')" class="w-full group flex items-center px-2 py-2.5 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 text-white hover:bg-gray-100 hover:text-gray-900">
                <svg class="mr-3 h-5 w-5 group-hover:stroke-gray-900" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span data-menu-item="employee-management" class="text-sm">Employee Management</span>
                <svg class="ml-auto h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            
            <!-- Employee Submenu -->
            <div id="employees-dropdown" class="hidden mt-2 space-y-1">
                <a href="{{ route('employees.add') }}" onclick="navigateTo('employees', 'add-employee')" class="block pl-8 pr-2 py-2 text-sm text-white hover:text-gray-900 hover:bg-gray-50 group">
                    <svg class="mr-2 h-4 w-4 inline group-hover:stroke-gray-900" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span data-menu-item="add-employee" class="text-sm">Add Employee</span>
                </a>
                <a href="{{ route('employees.contracts') }}" onclick="navigateTo('employees', 'contracts')" class="block pl-8 pr-2 py-2 text-sm text-white hover:text-gray-900 hover:bg-gray-50 group">
                    <svg class="mr-2 h-4 w-4 inline group-hover:stroke-gray-900" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 0h6m2 4h10a2 2 0 002-2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2V9a2 2 0 00-2-2H9a2 2 0 00-2-2v6a2 2 0 00-2-2H9a2 2 0 00-2-2h2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span data-menu-item="contracts" class="text-sm">Contracts</span>
                </a>
                <a href="{{ route('employees.departments') }}" onclick="navigateTo('employees', 'departments')" class="block pl-8 pr-2 py-2 text-sm text-white hover:text-gray-900 hover:bg-gray-50 group">
                    <svg class="mr-2 h-4 w-4 inline group-hover:stroke-gray-900" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span data-menu-item="departments" class="text-sm">Departments</span>
                </a>
            </div>
        </div>
        
        <!-- Payroll Management -->
        <div class="mb-2">
            <button onclick="toggleDropdown('payroll')" class="w-full group flex items-center px-2 py-2.5 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 text-white hover:bg-gray-100 hover:text-gray-900">
                <svg class="mr-3 h-5 w-5 group-hover:stroke-gray-900" fill="none" stroke="white" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2V7a2 2 0 00-2-2H9a2 2 0 00-2-2h2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span data-menu-item="payroll-management" class="text-sm">Payroll Management</span>
                <svg class="ml-auto h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            
            <!-- Payroll Submenu -->
            <div id="payroll-dropdown" class="hidden mt-2 space-y-1">
                <a href="{{ route('payroll.history') }}" onclick="navigateTo('payroll', 'payroll-history')" class="block pl-8 pr-2 py-2 text-sm text-white hover:text-gray-900 hover:bg-gray-50 group">
                    <svg class="mr-2 h-4 w-4 inline group-hover:stroke-gray-900" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span data-menu-item="payroll-history" class="text-sm">Payroll History</span>
                </a>
                <a href="{{ route('payroll.statutory') }}" onclick="navigateTo('payroll', 'statutory-deductions')" class="block pl-8 pr-2 py-2 text-sm text-white hover:text-gray-900 hover:bg-gray-50 group">
                    <svg class="mr-2 h-4 w-4 inline group-hover:stroke-gray-900" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <span data-menu-item="statutory-deductions" class="text-sm">Statutory Deductions</span>
                </a>
                <a href="{{ route('payroll.reports') }}" onclick="navigateTo('payroll', 'payroll-reports')" class="block pl-8 pr-2 py-2 text-sm text-white hover:text-gray-900 hover:bg-gray-50 group">
                    <svg class="mr-2 h-4 w-4 inline group-hover:stroke-gray-900" fill="none" stroke="white" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span data-menu-item="payroll-reports" class="text-sm">Payroll Reports</span>
                </a>
            </div>
        </div>
        
        <!-- Other Menu Items -->
        <a href="{{ route('discipline') }}" onclick="navigateTo('discipline')" class="group flex items-center px-2 py-2.5 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('discipline') ? 'bg-gray-100 text-gray-900' : 'text-white hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="mr-3 h-5 w-5 group-hover:stroke-gray-900" fill="none" stroke="white" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2 2m2 2l2 2m7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span data-menu-item="discipline-management" class="text-sm">Discipline Management</span>
        </a>
        
        <a href="{{ route('compliance') }}" onclick="navigateTo('compliance')" class="group flex items-center px-2 py-2.5 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('compliance') ? 'bg-gray-100 text-gray-900' : 'text-white hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="mr-3 h-5 w-5 group-hover:stroke-gray-900" fill="none" stroke="white" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
            <span data-menu-item="compliance-management" class="text-sm">Compliance Management</span>
        </a>
        
        <a href="{{ route('attendance') }}" onclick="navigateTo('attendance')" class="group flex items-center px-2 py-2.5 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('attendance') ? 'bg-gray-100 text-gray-900' : 'text-white hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="mr-3 h-5 w-5 group-hover:stroke-gray-900" fill="none" stroke="white" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span data-menu-item="attendance-management" class="text-sm">Attendance Management</span>
        </a>
        
        <a href="{{ route('leave') }}" onclick="navigateTo('leave')" class="group flex items-center px-2 py-2.5 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('leave') ? 'bg-gray-100 text-gray-900' : 'text-white hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="mr-3 h-5 w-5 group-hover:stroke-gray-900" fill="none" stroke="white" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span data-menu-item="leave-management" class="text-sm">Leave Management</span>
        </a>
        
        <a href="{{ route('recruitment') }}" onclick="navigateTo('recruitment')" class="group flex items-center px-2 py-2.5 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('recruitment') ? 'bg-gray-100 text-gray-900' : 'text-white hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="mr-3 h-5 w-5 group-hover:stroke-gray-900" fill="none" stroke="white" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span data-menu-item="recruitment-management" class="text-sm">Recruitment Management</span>
        </a>
        
        <a href="{{ route('performance') }}" onclick="navigateTo('performance')" class="group flex items-center px-2 py-2.5 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('performance') ? 'bg-gray-100 text-gray-900' : 'text-white hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="mr-3 h-5 w-5 group-hover:stroke-gray-900" fill="none" stroke="white" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <span data-menu-item="performance-management" class="text-sm">Performance Management</span>
        </a>
        
        <a href="{{ route('training') }}" onclick="navigateTo('training')" class="group flex items-center px-2 py-2.5 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('training') ? 'bg-gray-100 text-gray-900' : 'text-white hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="mr-3 h-5 w-5 group-hover:stroke-gray-900" fill="none" stroke="white" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253m0-13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <span data-menu-item="training-management" class="text-sm">Training Management</span>
        </a>
        
        <a href="{{ route('system') }}" onclick="navigateTo('system')" class="group flex items-center px-2 py-2.5 text-sm font-medium rounded-md hover:bg-gray-100 hover:text-gray-900 {{ request()->routeIs('system') ? 'bg-gray-100 text-gray-900' : 'text-white hover:bg-gray-50 hover:text-gray-900' }}">
            <svg class="mr-3 h-5 w-5 group-hover:stroke-gray-900" fill="none" stroke="white" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 1.756-1.756H11.175v-2.236c0-1.18.91-2.175 2.175-2.175H8.25c0-1.18.91-2.175 2.175-2.175v13.53c0 1.473.31 2.175 2.175 2.175h1.354l3.417 3.417c.426 1.756 1.756 1.756h-1.354v-2.236c0-1.18.91-2.175 2.175-2.175H8.25c0-1.18.91-2.175 2.175-2.175v13.53c0 1.473.31 2.175 2.175 2.175h1.354z"></path>
            </svg>
            <span data-menu-item="system-management" class="text-sm">System Management</span>
        </a>
    </nav>
</aside>
