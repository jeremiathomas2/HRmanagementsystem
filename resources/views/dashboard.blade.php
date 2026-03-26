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

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Employees -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                        <span data-icon="users" class="h-6 w-6 text-white">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </span>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dt class="text-sm font-medium text-gray-500 truncate">Total Employees</dt>
                        <dd class="text-lg font-medium text-gray-900">156</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Contracts -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <span data-icon="document" class="h-6 w-6 text-white"></span>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dt class="text-sm font-medium text-gray-500 truncate">Active Contracts</dt>
                        <dd class="text-lg font-medium text-gray-900">142</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Leave Requests -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                        <span data-icon="calendar" class="h-6 w-6 text-white"></span>
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
                        <span data-icon="money" class="h-6 w-6 text-white"></span>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dt class="text-sm font-medium text-gray-500 truncate">Monthly Payroll</dt>
                        <dd class="text-lg font-medium text-gray-900">TZS 45.2M</dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Open Disciplinary Cases -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                        <span data-icon="warning" class="h-6 w-6 text-white"></span>
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

    <!-- Recent Activities -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activities</h3>
            <div class="flow-root">
                <ul class="-mb-8">
                    <!-- Placeholder activities for testing -->
                    <li>
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="h-6 w-6 rounded-full bg-gray-300 flex items-center justify-center">
                                    <svg class="h-3 w-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6h6m-9 12l2 2m0 0l2-2m-2 2m7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1 space-y-1">
                                <p class="text-sm text-gray-900">John Doe</p>
                                <p class="text-sm text-gray-500">Created new employee record</p>
                                <p class="text-xs text-gray-400">2 hours ago</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="h-6 w-6 rounded-full bg-blue-600 flex items-center justify-center">
                                    <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v10a2 2 0 002 2h2m2 4h10a2 2 0 002 2v6a2 2 0 00-2-2H8a2 2 0 00-2-2H8a2 2 0 00-2-2h2zm-2 4h6a2 2 0 002-2v6a2 2 0 00-2-2H8a2 2 0 00-2-2h2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1 space-y-1">
                                <p class="text-sm text-gray-900">Jane Smith</p>
                                <p class="text-sm text-gray-500">Updated employee profile</p>
                                <p class="text-xs text-gray-400">4 hours ago</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="h-6 w-6 rounded-full bg-yellow-500 flex items-center justify-center">
                                    <svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1 space-y-1">
                                <p class="text-sm text-gray-900">Admin User</p>
                                <p class="text-sm text-gray-500">Generated monthly report</p>
                                <p class="text-xs text-gray-400">6 hours ago</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
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
