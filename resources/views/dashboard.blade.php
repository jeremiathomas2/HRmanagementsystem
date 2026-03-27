@extends('layouts.app')

@section('title', 'Dashboard - Tanzania HR Management System')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
            <p class="mt-2 text-sm text-gray-600">Overview of your HR management system</p>
        </div>
    </div>

    <!-- Advanced Quick Actions -->
    <div class="max-w-7xl mx-auto mb-8">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-medium text-gray-900">Quick Actions</h2>
                <button onclick="toggleQuickActionsView()" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                    <span id="quick-actions-toggle-text">Show More</span>
                    <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
            
            <!-- Primary Actions -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                <!-- Add Employee -->
                <button onclick="quickAction('add-employee')" class="group relative bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg p-3 sm:p-4 text-left transition-all duration-200 hover:shadow-md">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-1.5 sm:p-2 group-hover:bg-blue-600 transition-colors">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <div class="ml-2 sm:ml-3 min-w-0 flex-1">
                            <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Add Employee</p>
                            <p class="text-xs text-gray-500 hidden sm:block">Create new record</p>
                        </div>
                    </div>
                </button>

                <!-- View Payroll -->
                <button onclick="quickAction('view-payroll')" class="group relative bg-green-50 hover:bg-green-100 border border-green-200 rounded-lg p-3 sm:p-4 text-left transition-all duration-200 hover:shadow-md">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-1.5 sm:p-2 group-hover:bg-green-600 transition-colors">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div class="ml-2 sm:ml-3 min-w-0 flex-1">
                            <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">View Payroll</p>
                            <p class="text-xs text-gray-500 hidden sm:block">View payroll records</p>
                        </div>
                    </div>
                </button>

                <!-- Approve Leave -->
                <button onclick="quickAction('approve-leave')" class="group relative bg-yellow-50 hover:bg-yellow-100 border border-yellow-200 rounded-lg p-3 sm:p-4 text-left transition-all duration-200 hover:shadow-md">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-500 rounded-md p-1.5 sm:p-2 group-hover:bg-yellow-600 transition-colors">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-2 sm:ml-3 min-w-0 flex-1">
                            <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Approve Leave</p>
                            <p class="text-xs text-gray-500 hidden sm:block">8 pending requests</p>
                        </div>
                    </div>
                </button>

                <!-- Generate Report -->
                <button onclick="quickAction('generate-report')" class="group relative bg-purple-50 hover:bg-purple-100 border border-purple-200 rounded-lg p-3 sm:p-4 text-left transition-all duration-200 hover:shadow-md">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-1.5 sm:p-2 group-hover:bg-purple-600 transition-colors">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div class="ml-2 sm:ml-3 min-w-0 flex-1">
                            <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Generate Report</p>
                            <p class="text-xs text-gray-500 hidden sm:block">Monthly analytics</p>
                        </div>
                    </div>
                </button>
            </div>

            <!-- Extended Actions (Hidden by default) -->
            <div id="extended-quick-actions" class="hidden">
                <div class="border-t border-gray-200 pt-3 sm:pt-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                        <!-- Schedule Interview -->
                        <button onclick="quickAction('schedule-interview')" class="group relative bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-lg p-3 sm:p-4 text-left transition-all duration-200 hover:shadow-md">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-indigo-500 rounded-md p-1.5 sm:p-2 group-hover:bg-indigo-600 transition-colors">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-2 sm:ml-3 min-w-0 flex-1">
                                    <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Schedule Interview</p>
                                    <p class="text-xs text-gray-500 hidden sm:block">3 candidates</p>
                                </div>
                            </div>
                        </button>

                        <!-- Performance Review -->
                        <button onclick="quickAction('performance-review')" class="group relative bg-pink-50 hover:bg-pink-100 border border-pink-200 rounded-lg p-3 sm:p-4 text-left transition-all duration-200 hover:shadow-md">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-pink-500 rounded-md p-1.5 sm:p-2 group-hover:bg-pink-600 transition-colors">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                <div class="ml-2 sm:ml-3 min-w-0 flex-1">
                                    <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Performance Review</p>
                                    <p class="text-xs text-gray-500 hidden sm:block">Q1 evaluations</p>
                                </div>
                            </div>
                        </button>

                        <!-- Compliance Check -->
                        <button onclick="quickAction('compliance-check')" class="group relative bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg p-3 sm:p-4 text-left transition-all duration-200 hover:shadow-md">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-red-500 rounded-md p-1.5 sm:p-2 group-hover:bg-red-600 transition-colors">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div class="ml-2 sm:ml-3 min-w-0 flex-1">
                                    <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Compliance Check</p>
                                    <p class="text-xs text-gray-500 hidden sm:block">Run audit</p>
                                </div>
                            </div>
                        </button>

                        <!-- Training Session -->
                        <button onclick="quickAction('training-session')" class="group relative bg-teal-50 hover:bg-teal-100 border border-teal-200 rounded-lg p-3 sm:p-4 text-left transition-all duration-200 hover:shadow-md">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-teal-500 rounded-md p-1.5 sm:p-2 group-hover:bg-teal-600 transition-colors">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    </svg>
                                </div>
                                <div class="ml-2 sm:ml-3 min-w-0 flex-1">
                                    <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Training Session</p>
                                    <p class="text-xs text-gray-500 hidden sm:block">Schedule training</p>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- System Actions -->
                <div class="border-t border-gray-200 pt-3 sm:pt-4 mt-3 sm:mt-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                        <!-- Backup System -->
                        <button onclick="quickAction('backup-system')" class="group relative bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg p-3 sm:p-4 text-left transition-all duration-200 hover:shadow-md">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-gray-500 rounded-md p-1.5 sm:p-2 group-hover:bg-gray-600 transition-colors">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                    </svg>
                                </div>
                                <div class="ml-2 sm:ml-3 min-w-0 flex-1">
                                    <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Backup System</p>
                                    <p class="text-xs text-gray-500 hidden sm:block">Data backup</p>
                                </div>
                            </div>
                        </button>

                        <!-- System Settings -->
                        <button onclick="quickAction('system-settings')" class="group relative bg-orange-50 hover:bg-orange-100 border border-orange-200 rounded-lg p-3 sm:p-4 text-left transition-all duration-200 hover:shadow-md">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-orange-500 rounded-md p-1.5 sm:p-2 group-hover:bg-orange-600 transition-colors">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 1.756-1.756H11.175v-2.236c0-1.18.91-2.175 2.175-2.175H8.25c0-1.18.91-2.175 2.175-2.175v13.53c0 1.473.31 2.175 2.175 2.175h1.354l3.417 3.417c.426 1.756 1.756 1.756h-1.354v-2.236c0-1.18.91-2.175 2.175-2.175H8.25c0-1.18.91-2.175 2.175-2.175v13.53c0 1.473.31 2.175 2.175 2.175h1.354z" />
                                    </svg>
                                </div>
                                <div class="ml-2 sm:ml-3 min-w-0 flex-1">
                                    <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">System Settings</p>
                                    <p class="text-xs text-gray-500 hidden sm:block">Configuration</p>
                                </div>
                            </div>
                        </button>

                        <!-- Help & Support -->
                        <button onclick="quickAction('help-support')" class="group relative bg-cyan-50 hover:bg-cyan-100 border border-cyan-200 rounded-lg p-3 sm:p-4 text-left transition-all duration-200 hover:shadow-md">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-cyan-500 rounded-md p-1.5 sm:p-2 group-hover:bg-cyan-600 transition-colors">
                                    <svg class="h-4 w-4 sm:h-5 sm:w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.651 2.034-3 3.772-3s3.223 1.349 3.772 3c.549 1.651 2.034 3 3.772 3s3.223-1.349 3.772-3M12 3v18m0 0c-2.738 0-5.223 1.349-5.772 3s1.034 3 3.772 3 3.223-1.349 3.772-3c.549-1.651 2.034-3 3.772-3s3.223 1.349 3.772 3c.549 1.651 2.034 3 3.772 3s3.223-1.349 3.772-3" />
                                    </svg>
                                </div>
                                <div class="ml-2 sm:ml-3 min-w-0 flex-1">
                                    <p class="text-xs sm:text-sm font-medium text-gray-900 truncate">Help & Support</p>
                                    <p class="text-xs text-gray-500 hidden sm:block">Documentation</p>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Employees -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="white" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Employees</dt>
                        <dd class="text-lg font-medium text-gray-900" data-stat="employees">156</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Contracts -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="white" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 0h6m2 4h10a2 2 0 002-2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2V9a2 2 0 00-2-2H9a2 2 0 00-2-2v6a2 2 0 00-2-2H9a2 2 0 00-2-2h2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dt class="text-sm font-medium text-gray-500 truncate">Active Contracts</dt>
                        <dd class="text-lg font-medium text-gray-900" data-stat="contracts">142</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Leave Requests -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="white" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dt class="text-sm font-medium text-gray-500 truncate">Pending Leave</dt>
                        <dd class="text-lg font-medium text-gray-900">8</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Payroll -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="white" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2V7a2 2 0 00-2-2H9a2 2 0 00-2-2h2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dt class="text-sm font-medium text-gray-500 truncate">Monthly Payroll</dt>
                        <dd class="text-lg font-medium text-gray-900" data-stat="payroll">TZS 45.2M</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Open Disciplinary Cases -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="white" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2 2m2 2l2 2m7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dt class="text-sm font-medium text-gray-500 truncate">Open Cases</dt>
                        <dd class="text-lg font-medium text-gray-900">3</dd>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Employee Growth Chart -->
        <div class="bg-white p-6 shadow rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Employee Growth</h3>
            <div class="h-64">
                <canvas id="employeeGrowthChart"></canvas>
            </div>
        </div>

        <!-- Department Distribution -->
        <div class="bg-white p-6 shadow rounded-lg">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Department Distribution</h3>
            <div class="h-64">
                <canvas id="departmentChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Advanced Recent Activities -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <!-- Header with Controls -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Recent Activities</h3>
                    <p class="text-sm text-gray-500 mt-1">Real-time system activities and updates</p>
                </div>
                <div class="flex items-center space-x-3">
                    <!-- Filter Dropdown -->
                    <div class="relative">
                        <select id="activity-filter" onchange="filterActivities(this.value)" class="text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="all">All Activities</option>
                            <option value="employees">Employee Management</option>
                            <option value="payroll">Payroll</option>
                            <option value="leave">Leave Management</option>
                            <option value="system">System</option>
                            <option value="compliance">Compliance</option>
                        </select>
                    </div>
                    <!-- Refresh Button -->
                    <button onclick="refreshActivities()" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Refresh
                    </button>
                </div>
            </div>

            <!-- Live Status Indicator -->
            <div class="flex items-center mb-4">
                <div class="flex items-center">
                    <span class="flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    <span class="ml-2 text-sm text-gray-600">Live updates</span>
                </div>
                <div class="ml-auto text-sm text-gray-500">
                    <span id="activity-count">12</span> activities in last 24 hours
                </div>
            </div>

            <!-- Activities Container -->
            <div class="flow-root">
                <div id="activities-container" class="space-y-4 max-h-96 overflow-y-auto">
                    <!-- Activities will be dynamically loaded here -->
                </div>
            </div>

            <!-- Load More / Pagination -->
            <div class="mt-6 flex items-center justify-between">
                <div class="text-sm text-gray-500">
                    Showing <span id="showing-count">1-5</span> of <span id="total-count">12</span> activities
                </div>
                <div class="flex space-x-2">
                    <button onclick="loadMoreActivities()" id="load-more-btn" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Load More
                    </button>
                    <button onclick="viewAllActivities()" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        View All
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Advanced Recent Activities System
class ActivityManager {
    constructor() {
        this.activities = [];
        this.filteredActivities = [];
        this.currentPage = 1;
        this.itemsPerPage = 5;
        this.currentFilter = 'all';
        this.isLoading = false;
        
        this.initializeActivities();
        this.renderActivities();
        this.startRealTimeUpdates();
    }

    initializeActivities() {
        // Sample comprehensive activity data
        this.activities = [
            {
                id: 1,
                user: 'John Doe',
                avatar: '/images/avatars/john.jpg',
                action: 'Created new employee record',
                details: 'Added Michael Johnson as Senior Software Developer',
                type: 'employees',
                priority: 'high',
                timestamp: new Date(Date.now() - 2 * 60 * 60 * 1000), // 2 hours ago
                icon: 'user-plus',
                color: 'green',
                department: 'IT'
            },
            {
                id: 2,
                user: 'Jane Smith',
                avatar: '/images/avatars/jane.jpg',
                action: 'Updated employee profile',
                details: 'Updated contact information for Sarah Williams',
                type: 'employees',
                priority: 'medium',
                timestamp: new Date(Date.now() - 4 * 60 * 60 * 1000), // 4 hours ago
                icon: 'user-edit',
                color: 'blue',
                department: 'HR'
            },
            {
                id: 3,
                user: 'Admin User',
                avatar: '/images/avatars/admin.jpg',
                action: 'Generated monthly report',
                details: 'Payroll report for March 2026 - 156 employees',
                type: 'payroll',
                priority: 'high',
                timestamp: new Date(Date.now() - 6 * 60 * 60 * 1000), // 6 hours ago
                icon: 'file-alt',
                color: 'purple',
                department: 'Finance'
            },
            {
                id: 4,
                user: 'Robert Kim',
                avatar: '/images/avatars/robert.jpg',
                action: 'Approved leave request',
                details: 'Annual leave approved for David Chen (5 days)',
                type: 'leave',
                priority: 'medium',
                timestamp: new Date(Date.now() - 8 * 60 * 60 * 1000), // 8 hours ago
                icon: 'calendar-check',
                color: 'yellow',
                department: 'Operations'
            },
            {
                id: 5,
                user: 'Maria Garcia',
                avatar: '/images/avatars/maria.jpg',
                action: 'System backup completed',
                details: 'Automated backup completed successfully',
                type: 'system',
                priority: 'low',
                timestamp: new Date(Date.now() - 10 * 60 * 60 * 1000), // 10 hours ago
                icon: 'server',
                color: 'gray',
                department: 'IT'
            },
            {
                id: 6,
                user: 'James Wilson',
                avatar: '/images/avatars/james.jpg',
                action: 'Contract renewal',
                details: 'Contract renewed for Emma Thompson - 12 months',
                type: 'employees',
                priority: 'high',
                timestamp: new Date(Date.now() - 12 * 60 * 60 * 1000), // 12 hours ago
                icon: 'file-contract',
                color: 'indigo',
                department: 'Legal'
            },
            {
                id: 7,
                user: 'Lisa Anderson',
                avatar: '/images/avatars/lisa.jpg',
                action: 'Compliance audit passed',
                details: 'Q1 2026 compliance audit successfully completed',
                type: 'compliance',
                priority: 'high',
                timestamp: new Date(Date.now() - 14 * 60 * 60 * 1000), // 14 hours ago
                icon: 'shield-check',
                color: 'green',
                department: 'Compliance'
            },
            {
                id: 8,
                user: 'Thomas Brown',
                avatar: '/images/avatars/thomas.jpg',
                action: 'Training session completed',
                details: 'Safety training completed by 45 employees',
                type: 'system',
                priority: 'medium',
                timestamp: new Date(Date.now() - 16 * 60 * 60 * 1000), // 16 hours ago
                icon: 'graduation-cap',
                color: 'blue',
                department: 'Training'
            },
            {
                id: 9,
                user: 'Nina Patel',
                avatar: '/images/avatars/nina.jpg',
                action: 'Payroll processed',
                details: 'March 2026 payroll processed - TZS 45.2M',
                type: 'payroll',
                priority: 'high',
                timestamp: new Date(Date.now() - 18 * 60 * 60 * 1000), // 18 hours ago
                icon: 'dollar-sign',
                color: 'green',
                department: 'Finance'
            },
            {
                id: 10,
                user: 'Ahmed Hassan',
                avatar: '/images/avatars/ahmed.jpg',
                action: 'Disciplinary case resolved',
                details: 'Case #DC-2026-015 resolved with warning',
                type: 'compliance',
                priority: 'medium',
                timestamp: new Date(Date.now() - 20 * 60 * 60 * 1000), // 20 hours ago
                icon: 'gavel',
                color: 'yellow',
                department: 'HR'
            },
            {
                id: 11,
                user: 'Grace Mwangi',
                avatar: '/images/avatars/grace.jpg',
                action: 'Department transfer',
                details: 'Michael Johnson transferred to IT Department',
                type: 'employees',
                priority: 'medium',
                timestamp: new Date(Date.now() - 22 * 60 * 60 * 1000), // 22 hours ago
                icon: 'exchange-alt',
                color: 'purple',
                department: 'HR'
            },
            {
                id: 12,
                user: 'Peter Okonkwo',
                avatar: '/images/avatars/peter.jpg',
                action: 'Performance review completed',
                details: 'Q1 performance reviews completed - 156 employees',
                type: 'system',
                priority: 'medium',
                timestamp: new Date(Date.now() - 24 * 60 * 60 * 1000), // 24 hours ago
                icon: 'chart-line',
                color: 'blue',
                department: 'Management'
            }
        ];

        this.filteredActivities = [...this.activities];
        this.updateCounts();
    }

    renderActivities() {
        const container = document.getElementById('activities-container');
        if (!container) return;

        const startIndex = (this.currentPage - 1) * this.itemsPerPage;
        const endIndex = startIndex + this.itemsPerPage;
        const pageActivities = this.filteredActivities.slice(startIndex, endIndex);

        container.innerHTML = pageActivities.map(activity => this.createActivityHTML(activity)).join('');
        this.updatePaginationInfo();
    }

    createActivityHTML(activity) {
        const timeAgo = this.getTimeAgo(activity.timestamp);
        const priorityBadge = this.getPriorityBadge(activity.priority);
        
        return `
            <div class="flex items-start space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors activity-item" data-type="${activity.type}">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-full bg-${activity.color}-100 flex items-center justify-center">
                        ${this.getActivityIcon(activity.icon, activity.color)}
                    </div>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2">
                                <p class="text-sm font-medium text-gray-900">${activity.user}</p>
                                ${priorityBadge}
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                    ${activity.department}
                                </span>
                            </div>
                            <p class="text-sm text-gray-900 mt-1">${activity.action}</p>
                            <p class="text-xs text-gray-500 mt-1">${activity.details}</p>
                            <div class="flex items-center mt-2 text-xs text-gray-400">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" />
                                </svg>
                                ${timeAgo}
                            </div>
                        </div>
                        <div class="flex-shrink-0 ml-2">
                            <button onclick="viewActivityDetails(${activity.id})" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    getActivityIcon(iconName, color) {
        const icons = {
            'user-plus': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />',
            'user-edit': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />',
            'file-alt': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />',
            'calendar-check': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />',
            'server': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />',
            'file-contract': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />',
            'shield-check': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />',
            'graduation-cap': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />',
            'dollar-sign': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
            'gavel': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />',
            'exchange-alt': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />',
            'chart-line': '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />'
        };
        
        return `<svg class="h-5 w-5 text-${color}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">${icons[iconName] || icons['file-alt']}</svg>`;
    }

    getPriorityBadge(priority) {
        const badges = {
            high: '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">High Priority</span>',
            medium: '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">Medium</span>',
            low: '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">Low</span>'
        };
        
        return badges[priority] || '';
    }

    getTimeAgo(timestamp) {
        const now = new Date();
        const diff = now - timestamp;
        const hours = Math.floor(diff / (1000 * 60 * 60));
        const days = Math.floor(hours / 24);
        
        if (days > 0) {
            return `${days} day${days > 1 ? 's' : ''} ago`;
        } else if (hours > 0) {
            return `${hours} hour${hours > 1 ? 's' : ''} ago`;
        } else {
            const minutes = Math.floor(diff / (1000 * 60));
            return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
        }
    }

    filterActivities(type) {
        this.currentFilter = type;
        this.currentPage = 1;
        
        if (type === 'all') {
            this.filteredActivities = [...this.activities];
        } else {
            this.filteredActivities = this.activities.filter(activity => activity.type === type);
        }
        
        this.renderActivities();
        this.updateCounts();
    }

    updateCounts() {
        const totalCount = document.getElementById('total-count');
        const activityCount = document.getElementById('activity-count');
        
        if (totalCount) totalCount.textContent = this.filteredActivities.length;
        if (activityCount) activityCount.textContent = this.filteredActivities.length;
    }

    updatePaginationInfo() {
        const showingCount = document.getElementById('showing-count');
        const startIndex = (this.currentPage - 1) * this.itemsPerPage + 1;
        const endIndex = Math.min(this.currentPage * this.itemsPerPage, this.filteredActivities.length);
        
        if (showingCount) {
            showingCount.textContent = `${startIndex}-${endIndex}`;
        }
        
        // Update load more button
        const loadMoreBtn = document.getElementById('load-more-btn');
        if (loadMoreBtn) {
            loadMoreBtn.style.display = endIndex >= this.filteredActivities.length ? 'none' : 'inline-flex';
        }
    }

    loadMore() {
        this.currentPage++;
        this.renderActivities();
    }

    refresh() {
        this.isLoading = true;
        // Simulate loading new activities
        setTimeout(() => {
            this.initializeActivities();
            this.renderActivities();
            this.isLoading = false;
            showNotification('success', 'Activities Refreshed', 'Latest activities have been loaded');
        }, 1000);
    }

    startRealTimeUpdates() {
        // Simulate real-time updates every 30 seconds
        setInterval(() => {
            this.addRandomActivity();
        }, 30000);
    }

    addRandomActivity() {
        const randomActivities = [
            { user: 'System Bot', action: 'Automated backup completed', type: 'system', icon: 'server', color: 'gray' },
            { user: 'HR Assistant', action: 'New leave request submitted', type: 'leave', icon: 'calendar', color: 'yellow' },
            { user: 'Finance Team', action: 'Expense report approved', type: 'payroll', icon: 'dollar-sign', color: 'green' }
        ];
        
        const random = randomActivities[Math.floor(Math.random() * randomActivities.length)];
        const newActivity = {
            id: this.activities.length + 1,
            ...random,
            details: `Automated activity at ${new Date().toLocaleTimeString()}`,
            priority: 'medium',
            timestamp: new Date(),
            department: 'System',
            avatar: '/images/avatars/system.jpg'
        };
        
        this.activities.unshift(newActivity);
        this.filteredActivities.unshift(newActivity);
        this.renderActivities();
        this.updateCounts();
    }
}

// Initialize Activity Manager
let activityManager;

// Global functions for event handlers
window.filterActivities = function(type) {
    if (activityManager) activityManager.filterActivities(type);
};

window.refreshActivities = function() {
    if (activityManager) activityManager.refresh();
};

window.loadMoreActivities = function() {
    if (activityManager) activityManager.loadMore();
};

window.viewAllActivities = function() {
    // Redirect to full activities page or open modal
    showNotification('info', 'Activities', 'Viewing all activities in full screen mode');
};

window.viewActivityDetails = function(activityId) {
    if (activityManager) {
        const activity = activityManager.activities.find(a => a.id === activityId);
        if (activity) {
            showNotification('info', 'Activity Details', `${activity.user}: ${activity.details}`);
        }
    }
};

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    activityManager = new ActivityManager();
});

// Quick Actions functionality
window.toggleQuickActionsView = function() {
    const extendedActions = document.getElementById('extended-quick-actions');
    const toggleText = document.getElementById('quick-actions-toggle-text');
    
    if (extendedActions.classList.contains('hidden')) {
        extendedActions.classList.remove('hidden');
        toggleText.textContent = 'Show Less';
    } else {
        extendedActions.classList.add('hidden');
        toggleText.textContent = 'Show More';
    }
};

window.quickAction = function(action) {
    // Show loading state
    const button = event.target.closest('button');
    const originalContent = button.innerHTML;
    
    // Add loading spinner
    button.disabled = true;
    button.innerHTML = `
        <div class="flex items-center">
            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-current mr-2"></div>
            Processing...
        </div>
    `;
    
    // Simulate processing time
    setTimeout(() => {
        // Handle different actions
        handleQuickAction(action);
        
        // Restore button
        button.disabled = false;
        button.innerHTML = originalContent;
        
        // Show success notification
        showNotification('success', 'Action Completed', getActionMessage(action));
        
        // Log action for analytics
        console.log(`Quick action executed: ${action}`);
    }, 1500);
};

function handleQuickAction(action) {
    switch(action) {
        case 'add-employee':
            // Redirect to employee creation form
            window.location.href = '/employees/add';
            break;
            
        case 'view-payroll':
            // Redirect to payroll view page
            window.location.href = '/payroll';
            break;
            
        case 'approve-leave':
            // Redirect to leave approval page
            window.location.href = '/leave';
            break;
            
        case 'generate-report':
            // Generate and download report
            generateMonthlyReport();
            break;
            
        case 'schedule-interview':
            // Open interview scheduling modal
            openInterviewModal();
            break;
            
        case 'performance-review':
            // Redirect to performance review page
            window.location.href = '/performance';
            break;
            
        case 'compliance-check':
            // Run compliance check
            runComplianceCheck();
            break;
            
        case 'training-session':
            // Open training scheduling modal
            openTrainingModal();
            break;
            
        case 'backup-system':
            // Initiate system backup
            initiateSystemBackup();
            break;
            
        case 'system-settings':
            // Redirect to system settings
            window.location.href = '/system/settings';
            break;
            
        case 'help-support':
            // Open help documentation
            openHelpDocumentation();
            break;
            
        default:
            console.log('Unknown action:', action);
    }
}

function getActionMessage(action) {
    const messages = {
        'add-employee': 'Employee creation form opened',
        'view-payroll': 'Payroll records page opened',
        'approve-leave': 'Redirected to leave approval page',
        'generate-report': 'Monthly report generated and downloaded',
        'schedule-interview': 'Interview scheduling modal opened',
        'performance-review': 'Performance review dashboard loaded',
        'compliance-check': 'Compliance audit completed successfully',
        'training-session': 'Training scheduling modal opened',
        'backup-system': 'System backup initiated successfully',
        'system-settings': 'System settings page loaded',
        'help-support': 'Help documentation opened'
    };
    
    return messages[action] || 'Action completed successfully';
}

function openPayrollModal() {
    // Create modal content
    const modal = createModal('Process Payroll', `
        <div class="p-6">
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Payroll Processing Options</h3>
                <p class="text-sm text-gray-600">Select payroll period and processing options</p>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payroll Period</label>
                    <select class="w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        <option>March 2026</option>
                        <option>February 2026</option>
                        <option>January 2026</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Processing Options</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" checked class="mr-2">
                            <span class="text-sm">Calculate taxes and deductions</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" checked class="mr-2">
                            <span class="text-sm">Generate payslips</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2">
                            <span class="text-sm">Send email notifications</span>
                        </label>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button onclick="processPayroll()" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Process Payroll
                    </button>
                </div>
            </div>
        </div>
    `);
    
    document.body.appendChild(modal);
}

function openInterviewModal() {
    const modal = createModal('Schedule Interview', `
        <div class="p-6">
            <div class="mb-4">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Schedule Interview</h3>
                <p class="text-sm text-gray-600">3 candidates waiting for interview scheduling</p>
            </div>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Candidate</label>
                    <select class="w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                        <option>John Michael - Software Developer</option>
                        <option>Sarah Johnson - HR Manager</option>
                        <option>David Chen - Finance Analyst</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Interview Date</label>
                    <input type="date" class="w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Interview Time</label>
                    <input type="time" class="w-full border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button onclick="scheduleInterview()" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Schedule Interview
                    </button>
                </div>
            </div>
        </div>
    `);
    
    document.body.appendChild(modal);
}

function generateMonthlyReport() {
    // Simulate report generation
    showNotification('info', 'Generating Report', 'Monthly report is being generated...');
    
    setTimeout(() => {
        // Create a sample report download
        const reportData = {
            month: 'March 2026',
            totalEmployees: 156,
            activeContracts: 142,
            payrollAmount: 'TZS 45.2M',
            generatedAt: new Date().toISOString()
        };
        
        // Create download link
        const blob = new Blob([JSON.stringify(reportData, null, 2)], { type: 'application/json' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `monthly-report-${new Date().toISOString().split('T')[0]}.json`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
        
        showNotification('success', 'Report Generated', 'Monthly report downloaded successfully');
    }, 2000);
}

function runComplianceCheck() {
    showNotification('info', 'Running Compliance Check', 'Performing system compliance audit...');
    
    setTimeout(() => {
        const complianceResults = {
            status: 'PASS',
            checks: 45,
            passed: 43,
            failed: 2,
            warnings: 3,
            lastRun: new Date().toLocaleString()
        };
        
        showNotification('success', 'Compliance Check Complete', 
            `Status: ${complianceResults.status}\nPassed: ${complianceResults.passed}/${complianceResults.checks}\nWarnings: ${complianceResults.warnings}`);
    }, 3000);
}

function initiateSystemBackup() {
    showNotification('info', 'Starting Backup', 'System backup is being initiated...');
    
    setTimeout(() => {
        showNotification('success', 'Backup Completed', 'System backup completed successfully');
        
        // Update last backup time
        const backupButton = document.querySelector('[onclick*="backup-system"]');
        if (backupButton) {
            const timeElement = backupButton.querySelector('.text-xs');
            if (timeElement) {
                timeElement.textContent = 'Last: Just now';
            }
        }
    }, 2500);
}

function openHelpDocumentation() {
    // Open help documentation in new tab
    window.open('/help', '_blank');
}

function createModal(title, content) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50';
    modal.innerHTML = `
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">${title}</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                ${content}
            </div>
        </div>
    `;
    
    return modal;
}

window.closeModal = function() {
    const modal = document.querySelector('.fixed.inset-0');
    if (modal) {
        modal.remove();
    }
};

window.processPayroll = function() {
    showNotification('success', 'Payroll Processed', 'Payroll has been processed successfully');
    closeModal();
};

window.scheduleInterview = function() {
    showNotification('success', 'Interview Scheduled', 'Interview has been scheduled successfully');
    closeModal();
};

// Comprehensive menu functionality
window.quickAction = function(action) {
    switch(action) {
        case 'add-employee':
            window.location.href = '/employees/add';
            break;
        case 'view-payroll':
            window.location.href = '/payroll';
            break;
        case 'approve-leave':
            window.location.href = '/leave';
            break;
        case 'generate-report':
            showNotification('info', 'Report Generation', 'Opening report generation interface...');
            setTimeout(() => {
                window.location.href = '/payroll/reports';
            }, 1000);
            break;
        case 'schedule-interview':
            window.location.href = '/recruitment/interviews';
            break;
        case 'performance-review':
            window.location.href = '/performance';
            break;
        case 'compliance-check':
            window.location.href = '/compliance';
            break;
        case 'training-session':
            window.location.href = '/training';
            break;
        case 'backup-system':
            showNotification('info', 'System Backup', 'Starting backup process...');
            setTimeout(() => {
                window.location.href = '/system/backup';
            }, 1000);
            break;
        case 'system-settings':
            window.location.href = '/system/settings';
            break;
        case 'help-support':
            showNotification('info', 'Help & Support', 'Opening help documentation...');
            setTimeout(() => {
                window.open('/help', '_blank');
            }, 1000);
            break;
        default:
            showNotification('warning', 'Unknown Action', 'The requested action is not available');
    }
};

// Menu navigation functionality
window.navigateTo = function(section, subsection = null) {
    const routes = {
        'dashboard': '/dashboard',
        'employees': '/employees',
        'add-employee': '/employees/add',
        'contracts': '/employees/contracts',
        'departments': '/employees/departments',
        'payroll': '/payroll',
        'payroll-history': '/payroll/history',
        'statutory-deductions': '/payroll/statutory',
        'payroll-reports': '/payroll/reports',
        'discipline': '/discipline',
        'compliance': '/compliance',
        'attendance': '/attendance',
        'leave': '/leave',
        'recruitment': '/recruitment',
        'performance': '/performance',
        'training': '/training',
        'system': '/system',
        'system-settings': '/system/settings',
        'system-users': '/system/users',
        'system-roles': '/system/roles',
        'system-backup': '/system/backup',
        'system-logs': '/system/logs',
        'system-maintenance': '/system/maintenance',
        'system-integrations': '/system/integrations',
        'system-security': '/system/security',
        'employee-transfers': '/employee-transfers',
        'legal-cases': '/legal-cases',
        'compliance-monitoring': '/compliance-monitoring',
        'risk-assessments': '/risk-assessments'
    };
    
    const url = subsection && routes[subsection] ? routes[subsection] : routes[section];
    
    if (url) {
        showNotification('info', 'Navigation', `Navigating to ${subsection || section}...`);
        setTimeout(() => {
            window.location.href = url;
        }, 500);
    } else {
        showNotification('error', 'Navigation Error', `Route not found for ${subsection || section}`);
    }
};

// Enhanced dropdown functionality
window.toggleDropdown = function(menuId) {
    const dropdown = document.getElementById(menuId + '-dropdown');
    const allDropdowns = document.querySelectorAll('[id$="-dropdown"]');
    
    // Close all other dropdowns
    allDropdowns.forEach(d => {
        if (d.id !== menuId + '-dropdown') {
            d.classList.add('hidden');
        }
    });
    
    // Toggle current dropdown
    if (dropdown) {
        dropdown.classList.toggle('hidden');
    }
};

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('button[onclick*="toggleDropdown"]') && !event.target.closest('[id$="-dropdown"]')) {
        const allDropdowns = document.querySelectorAll('[id$="-dropdown"]');
        allDropdowns.forEach(d => d.classList.add('hidden'));
    }
});

// Initialize company switcher on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard loaded - initializing company switcher...');
    
    // Initialize company switcher
    if (typeof window.initializeCompanySwitcher === 'function') {
        window.initializeCompanySwitcher();
    }
    
    // Test company switcher functionality
    console.log('Company switcher initialized');
    console.log('Available companies:', Object.keys(window.quickCompanySwitch || {}));
    
    // Add visual indicator for active company
    const activeCompany = localStorage.getItem('activeCompany') || 'tcc';
    console.log('Active company:', activeCompany);
    
    // Show notification for current company
    setTimeout(() => {
        const companyNames = {
            'tcc': 'Tanzania Cigarette Company (TCC)',
            'tbl': 'Tanzania Breweries Limited (TBL)',
            'nmb': 'NMB Bank Plc',
            'crdb': 'CRDB Bank Plc',
            'tigo': 'Tigo Tanzania',
            'vodacom': 'Vodacom Tanzania',
            'airtel': 'Airtel Tanzania',
            'tanesco': 'TANESCO',
            'twiga': 'Twiga Cement',
            'azam': 'Azam Tanzania',
            'yara': 'Yara Tanzania',
            'hr-system': 'HR Management System'
        };
        
        if (activeCompany && companyNames[activeCompany]) {
            showNotification('info', 'Current Company', `Currently active: ${companyNames[activeCompany]}`);
        }
    }, 2000);
});

// Quick action shortcuts
window.quickActionShortcuts = {
    'Ctrl+N': () => window.navigateTo('add-employee'),
    'Ctrl+P': () => window.navigateTo('payroll'),
    'Ctrl+L': () => window.navigateTo('leave'),
    'Ctrl+R': () => window.navigateTo('recruitment'),
    'Ctrl+D': () => window.navigateTo('dashboard'),
    'Ctrl+S': () => window.navigateTo('system-settings'),
    'Ctrl+H': () => window.navigateTo('help-support')
};

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    const key = e.ctrlKey ? `Ctrl+${e.key.toUpperCase()}` : null;
    
    if (key && window.quickActionShortcuts[key]) {
        e.preventDefault();
        window.quickActionShortcuts[key]();
    }
});

// Enhanced sidebar toggle
window.toggleSidebar = function(event) {
    event.preventDefault();
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const topHeader = document.getElementById('top-header');
    
    if (sidebar.classList.contains('translate-x-0')) {
        // Close sidebar
        sidebar.classList.remove('translate-x-0');
        sidebar.classList.add('-translate-x-full');
        mainContent.classList.remove('ml-64');
        mainContent.classList.add('ml-0');
        if (topHeader) {
            topHeader.classList.remove('left-64');
            topHeader.classList.add('left-0');
        }
    } else {
        // Open sidebar
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        mainContent.classList.remove('ml-0');
        mainContent.classList.add('ml-64');
        if (topHeader) {
            topHeader.classList.remove('left-0');
            topHeader.classList.add('left-64');
        }
    }
};

// Company switcher functionality
window.switchCompany = function(companyId) {
    showNotification('info', 'Switching Company', 'Switching to selected company...');
    
    // Simulate company switch (in real app, this would make an API call)
    setTimeout(() => {
        showNotification('success', 'Company Switched', `Successfully switched to company ${companyId}`);
        
        // Update UI elements
        const currentCompanyElement = document.getElementById('current-company-name');
        if (currentCompanyElement) {
            const companyNames = {
                'tcc': 'Tanzania Cigarette Company (TCC)',
                'tbl': 'Tanzania Breweries Limited (TBL)',
                'nmb': 'NMB Bank Plc',
                'crdb': 'CRDB Bank Plc',
                'tigo': 'Tigo Tanzania',
                'vodacom': 'Vodacom Tanzania',
                'airtel': 'Airtel Tanzania',
                'tanesco': 'TANESCO',
                'twiga': 'Twiga Cement',
                'azam': 'Azam Tanzania',
                'yara': 'Yara Tanzania',
                'hr-system': 'HR Management System'
            };
            
            currentCompanyElement.textContent = companyNames[companyId] || 'HR Management System';
        }
        
        // Update page title
        document.title = `${companyNames[companyId] || 'HR Management System'} - HR Management System`;
        
        // Store preference
        localStorage.setItem('activeCompany', companyId);
        localStorage.setItem('activeCompanyName', companyNames[companyId] || 'HR Management System');
        
        // Trigger company changed event
        window.dispatchEvent(new CustomEvent('companyChanged', {
            detail: { 
                companyId: companyId, 
                companyName: companyNames[companyId] || 'HR Management System',
                timestamp: new Date().toISOString()
            }
        }));
        
        // Optional: Reload page after a short delay to refresh data
        setTimeout(() => {
            window.location.reload();
        }, 1500);
    }, 1000);
};

// Enhanced company switcher with auto-detection
window.initializeCompanySwitcher = function() {
    const activeCompany = localStorage.getItem('activeCompany') || 'tcc';
    const activeCompanyName = localStorage.getItem('activeCompanyName') || 'Tanzania Cigarette Company (TCC)';
    
    // Update current company display
    const currentCompanyElement = document.getElementById('current-company-name');
    if (currentCompanyElement) {
        currentCompanyElement.textContent = activeCompanyName;
    }
    
    // Update page title
    document.title = `${activeCompanyName} - HR Management System`;
    
    // Update sidebar menu
    if (typeof updateSidebarMenu === 'function') {
        updateSidebarMenu(activeCompany, activeCompanyName);
    }
    
    // Add company change listener
    window.addEventListener('companyChanged', function(event) {
        const { companyId, companyName } = event.detail;
        console.log(`Company changed to: ${companyName} (${companyId})`);
        
        // Update any UI elements that depend on company
        const companyIndicators = document.querySelectorAll('[data-company-indicator]');
        companyIndicators.forEach(indicator => {
            indicator.setAttribute('data-company-indicator', companyId);
        });
    });
};

// Quick company switching shortcuts
window.quickCompanySwitch = {
    'Ctrl+1': () => switchCompany('tcc'),
    'Ctrl+2': () => switchCompany('tbl'),
    'Ctrl+3': () => switchCompany('nmb'),
    'Ctrl+4': () => switchCompany('crdb'),
    'Ctrl+5': () => switchCompany('tigo'),
    'Ctrl+6': () => switchCompany('vodacom'),
    'Ctrl+7': () => switchCompany('airtel'),
    'Ctrl+8': () => switchCompany('tanesco'),
    'Ctrl+9': () => switchCompany('twiga'),
    'Ctrl+0': () => switchCompany('azam'),
    'Alt+1': () => switchCompany('yara'),
    'Alt+2': () => switchCompany('hr-system')
};

// Enhanced keyboard shortcuts for company switching
document.addEventListener('keydown', function(e) {
    const key = e.ctrlKey ? `Ctrl+${e.key}` : e.altKey ? `Alt+${e.key}` : null;
    
    if (key && window.quickCompanySwitch[key]) {
        e.preventDefault();
        window.quickCompanySwitch[key]();
    }
});

// Enhanced quick actions view toggle
window.toggleQuickActionsView = function() {
    const extendedActions = document.getElementById('extended-quick-actions');
    const toggleText = document.getElementById('quick-actions-toggle-text');
    const toggleIcon = document.querySelector('[onclick*="toggleQuickActionsView"] svg');
    
    if (extendedActions.classList.contains('hidden')) {
        extendedActions.classList.remove('hidden');
        toggleText.textContent = 'Show Less';
        if (toggleIcon) {
            toggleIcon.style.transform = 'rotate(180deg)';
        }
    } else {
        extendedActions.classList.add('hidden');
        toggleText.textContent = 'Show More';
        if (toggleIcon) {
            toggleIcon.style.transform = 'rotate(0deg)';
        }
    }
};

// Search functionality
window.searchSystem = function(query) {
    if (!query || query.length < 2) {
        showNotification('warning', 'Search', 'Please enter at least 2 characters to search');
        return;
    }
    
    showNotification('info', 'Searching', `Searching for "${query}"...`);
    
    // Simulate search (in real app, this would make an API call)
    setTimeout(() => {
        showNotification('success', 'Search Complete', `Found 5 results for "${query}"`);
    }, 1000);
};

// Notification preferences
window.updateNotificationSettings = function(settings) {
    localStorage.setItem('notificationSettings', JSON.stringify(settings));
    showNotification('success', 'Settings Updated', 'Notification preferences have been saved');
};

// Theme toggle
window.toggleTheme = function() {
    const body = document.body;
    const currentTheme = body.classList.contains('dark') ? 'dark' : 'light';
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    body.classList.remove(currentTheme);
    body.classList.add(newTheme);
    
    localStorage.setItem('theme', newTheme);
    showNotification('success', 'Theme Changed', `Switched to ${newTheme} mode`);
};
// Employee Growth Chart
const employeeGrowthCtx = document.getElementById('employeeGrowthChart').getContext('2d');
const employeeGrowthChart = new Chart(employeeGrowthCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Employees',
            data: [12, 19, 23, 25, 32, 38],
            borderColor: 'rgb(99, 102, 241)',
            backgroundColor: 'rgba(99, 102, 241, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Department Distribution Chart
const departmentCtx = document.getElementById('departmentChart').getContext('2d');
const departmentChart = new Chart(departmentCtx, {
    type: 'doughnut',
    data: {
        labels: ['HR', 'IT', 'Finance', 'Operations'],
        datasets: [{
            data: [15, 25, 30, 20],
            backgroundColor: [
                'rgba(99, 102, 241, 0.8)',
                'rgba(34, 197, 94, 0.8)',
                'rgba(251, 146, 60, 0.8)',
                'rgba(147, 51, 234, 0.8)'
            ],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endsection
