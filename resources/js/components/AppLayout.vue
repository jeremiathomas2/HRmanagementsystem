<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside :class="['fixed left-0 top-0 z-40 h-screen bg-gray-900 shadow-lg transition-all duration-300 overflow-hidden flex flex-col', sidebarOpen ? 'w-64' : 'w-0', 'lg:translate-x-0', !sidebarOpen && '-translate-x-full']">
      <div class="flex items-center justify-center h-16 bg-gray-800 flex-shrink-0">
        <div class="flex items-center">
          <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
            </svg>
          </div>
          <span class="ml-3 text-white font-semibold text-lg hidden sm:block">HR Management system</span>
          <span class="ml-3 text-white font-semibold text-sm sm:hidden">HR</span>
        </div>
      </div>
      
      <nav class="flex-1 overflow-y-auto">
        <div class="px-2 sm:px-4 space-y-2 py-4">
          <!-- Dashboard -->
          <div>
            <button @click="toggleDropdown('dashboard')" class="w-full flex items-center px-3 sm:px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors" :class="{ 'bg-gray-800 text-white': $route.name === 'dashboard' }">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              <span class="hidden sm:inline">Dashboard</span>
              <span class="sm:hidden">Dash</span>
              <svg class="ml-auto w-4 h-4 transition-transform" :class="dropdowns.dashboard ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div v-show="dropdowns.dashboard" class="ml-8 mt-1 space-y-1">
              <router-link to="/dashboard" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Overview
              </router-link>
              <router-link to="/dashboard/analytics" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Analytics
              </router-link>
              <router-link to="/dashboard/reports" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Reports
              </router-link>
            </div>
          </div>
          
          <!-- Employees -->
          <div>
            <button @click="toggleDropdown('employees')" class="w-full flex items-center px-3 sm:px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors" :class="{ 'bg-gray-800 text-white': $route.name === 'employees' }">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
              <span class="hidden sm:inline">Employees</span>
              <span class="sm:hidden">Staff</span>
              <svg class="ml-auto w-4 h-4 transition-transform" :class="dropdowns.employees ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div v-show="dropdowns.employees" class="ml-8 mt-1 space-y-1">
              <router-link to="/employees" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                All Employees
              </router-link>
              <router-link to="/employees/add" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Add Employee
              </router-link>
              <router-link to="/employees/contracts" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Contracts
              </router-link>
              <router-link to="/employees/departments" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Departments
              </router-link>
            </div>
          </div>
          
          <!-- Payroll -->
          <div>
            <button @click="toggleDropdown('payroll')" class="w-full flex items-center px-3 sm:px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors" :class="{ 'bg-gray-800 text-white': $route.name === 'payroll' }">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span class="hidden sm:inline">Payroll</span>
              <span class="sm:hidden">Pay</span>
              <svg class="ml-auto w-4 h-4 transition-transform" :class="dropdowns.payroll ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div v-show="dropdowns.payroll" class="ml-8 mt-1 space-y-1">
              <router-link to="/payroll" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Process Payroll
              </router-link>
              <router-link to="/payroll/history" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Payroll History
              </router-link>
              <router-link to="/payroll/statutory" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Statutory Deductions
              </router-link>
              <router-link to="/payroll/reports" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Payroll Reports
              </router-link>
            </div>
          </div>
          
          <!-- Discipline -->
          <div>
            <button @click="toggleDropdown('discipline')" class="w-full flex items-center px-3 sm:px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors" :class="{ 'bg-gray-800 text-white': $route.name === 'discipline' }">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              <span class="hidden sm:inline">Discipline</span>
              <span class="sm:hidden">Disc</span>
              <svg class="ml-auto w-4 h-4 transition-transform" :class="dropdowns.discipline ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div v-show="dropdowns.discipline" class="ml-8 mt-1 space-y-1">
              <router-link to="/discipline" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Cases
              </router-link>
              <router-link to="/discipline/new" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                New Case
              </router-link>
              <router-link to="/discipline/hearings" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Hearings
              </router-link>
              <router-link to="/discipline/actions" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Actions
              </router-link>
            </div>
          </div>
          
          <!-- Compliance -->
          <div>
            <button @click="toggleDropdown('compliance')" class="w-full flex items-center px-3 sm:px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors" :class="{ 'bg-gray-800 text-white': $route.name === 'compliance' }">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
              <span class="hidden sm:inline">Compliance</span>
              <span class="sm:hidden">Comp</span>
              <svg class="ml-auto w-4 h-4 transition-transform" :class="dropdowns.compliance ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div v-show="dropdowns.compliance" class="ml-8 mt-1 space-y-1">
              <router-link to="/compliance" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Overview
              </router-link>
              <router-link to="/compliance/inspections" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Inspections
              </router-link>
              <router-link to="/compliance/licenses" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Licenses
              </router-link>
              <router-link to="/compliance/audits" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Audits
              </router-link>
            </div>
          </div>
          
          <!-- Attendance -->
          <div>
            <button @click="toggleDropdown('attendance')" class="w-full flex items-center px-3 sm:px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors" :class="{ 'bg-gray-800 text-white': $route.name === 'attendance' }">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span class="hidden sm:inline">Attendance</span>
              <span class="sm:hidden">Attend</span>
              <svg class="ml-auto w-4 h-4 transition-transform" :class="dropdowns.attendance ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div v-show="dropdowns.attendance" class="ml-8 mt-1 space-y-1">
              <router-link to="/attendance" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Time Tracking
              </router-link>
              <router-link to="/attendance/schedule" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Schedules
              </router-link>
              <router-link to="/attendance/overtime" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Overtime
              </router-link>
              <router-link to="/attendance/reports" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Attendance Reports
              </router-link>
            </div>
          </div>
          
          <!-- Leave -->
          <div>
            <button @click="toggleDropdown('leave')" class="w-full flex items-center px-3 sm:px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors" :class="{ 'bg-gray-800 text-white': $route.name === 'leave' }">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <span class="hidden sm:inline">Leave</span>
              <span class="sm:hidden">Leave</span>
              <svg class="ml-auto w-4 h-4 transition-transform" :class="dropdowns.leave ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div v-show="dropdowns.leave" class="ml-8 mt-1 space-y-1">
              <router-link to="/leave" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Leave Requests
              </router-link>
              <router-link to="/leave/balances" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Leave Balances
              </router-link>
              <router-link to="/leave/policy" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Leave Policy
              </router-link>
              <router-link to="/leave/calendar" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Leave Calendar
              </router-link>
            </div>
          </div>
          
          <!-- Recruitment -->
          <div>
            <button @click="toggleDropdown('recruitment')" class="w-full flex items-center px-3 sm:px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors" :class="{ 'bg-gray-800 text-white': $route.name === 'recruitment' }">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
              <span class="hidden sm:inline">Recruitment</span>
              <span class="sm:hidden">Recruit</span>
              <svg class="ml-auto w-4 h-4 transition-transform" :class="dropdowns.recruitment ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div v-show="dropdowns.recruitment" class="ml-8 mt-1 space-y-1">
              <router-link to="/recruitment" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Job Postings
              </router-link>
              <router-link to="/recruitment/applications" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Applications
              </router-link>
              <router-link to="/recruitment/interviews" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Interviews
              </router-link>
              <router-link to="/recruitment/onboarding" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Onboarding
              </router-link>
            </div>
          </div>
          
          <!-- Performance -->
          <div>
            <button @click="toggleDropdown('performance')" class="w-full flex items-center px-3 sm:px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors" :class="{ 'bg-gray-800 text-white': $route.name === 'performance' }">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
              <span class="hidden sm:inline">Performance</span>
              <span class="sm:hidden">Perf</span>
              <svg class="ml-auto w-4 h-4 transition-transform" :class="dropdowns.performance ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div v-show="dropdowns.performance" class="ml-8 mt-1 space-y-1">
              <router-link to="/performance" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Reviews
              </router-link>
              <router-link to="/performance/goals" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Goals
              </router-link>
              <router-link to="/performance/feedback" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Feedback
              </router-link>
              <router-link to="/performance/analytics" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Performance Analytics
              </router-link>
            </div>
          </div>
          
          <!-- Training -->
          <div>
            <button @click="toggleDropdown('training')" class="w-full flex items-center px-3 sm:px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors" :class="{ 'bg-gray-800 text-white': $route.name === 'training' }">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
              </svg>
              <span class="hidden sm:inline">Training</span>
              <span class="sm:hidden">Train</span>
              <svg class="ml-auto w-4 h-4 transition-transform" :class="dropdowns.training ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div v-show="dropdowns.training" class="ml-8 mt-1 space-y-1">
              <router-link to="/training" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Training Programs
              </router-link>
              <router-link to="/training/courses" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Courses
              </router-link>
              <router-link to="/training/enrollments" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Enrollments
              </router-link>
              <router-link to="/training/certificates" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Certificates
              </router-link>
            </div>
          </div>

          <!-- System -->
          <div>
            <button @click="toggleDropdown('system')" class="w-full flex items-center px-3 sm:px-4 py-3 text-gray-300 hover:bg-gray-800 hover:text-white rounded-lg transition-colors" :class="{ 'bg-gray-800 text-white': $route.name === 'system' }">
              <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span class="hidden sm:inline">System</span>
              <span class="sm:hidden">Sys</span>
              <svg class="ml-auto w-4 h-4 transition-transform" :class="dropdowns.system ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div v-show="dropdowns.system" class="ml-8 mt-1 space-y-1">
              <router-link to="/system/settings" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                System Settings
              </router-link>
              <router-link to="/system/users" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                User Management
              </router-link>
              <router-link to="/system/roles" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Roles & Permissions
              </router-link>
              <router-link to="/system/backup" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Backup & Recovery
              </router-link>
              <router-link to="/system/logs" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                System Logs
              </router-link>
              <router-link to="/system/maintenance" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Maintenance
              </router-link>
              <router-link to="/system/integrations" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Integrations
              </router-link>
              <router-link to="/system/security" class="block px-3 py-2 text-sm text-gray-400 hover:text-gray-300 hover:bg-gray-700 rounded">
                Security Center
              </router-link>
            </div>
          </div>
        </div>
      </nav>
      
      <!-- Logout Button -->
      <div class="p-2 sm:p-4 border-t border-gray-800 flex-shrink-0">
        <button @click="logout" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 sm:py-3 px-2 sm:px-4 rounded-lg transition-colors flex items-center justify-center">
          <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>
          <span class="hidden sm:inline">Logout</span>
          <span class="sm:hidden">Exit</span>
        </button>
      </div>
    </aside>

    <!-- Mobile Sidebar Overlay -->
    <div v-if="sidebarOpen" @click="toggleSidebar" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden"></div>

    <!-- Advanced Notification Component -->
    <AdvancedNotification />

    <!-- Idle Warning Modal -->
    <div v-if="showIdleWarning" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
      <div class="bg-white rounded-lg shadow-2xl p-6 max-w-md mx-4 transform transition-all duration-300 scale-100">
        <div class="text-center">
          <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100 mb-4">
            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
          </div>
          <h3 class="text-lg font-medium text-gray-900 mb-2">Session Expiring</h3>
          <p class="text-sm text-gray-600 mb-4">
            Your session will expire in <span class="font-bold text-yellow-600">{{ countdownSeconds }}</span> seconds due to inactivity.
          </p>
          <p class="text-sm text-gray-500 mb-6">
            Click "Continue Session" to extend your session, or you will be automatically logged out.
          </p>
          <div class="flex gap-3">
            <button
              @click="extendSession"
              class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors"
            >
              Continue Session
            </button>
            <button
              @click="performIdleLogout"
              class="flex-1 bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors"
            >
              Logout Now
            </button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Main Content -->
    <div :class="['transition-all duration-300', sidebarOpen ? 'lg:ml-64' : 'lg:ml-0', 'ml-0']">
      <!-- Top Header -->
      <header class="bg-white shadow-sm border-b border-gray-200 fixed top-0 right-0 z-50 transition-all duration-300 lg:left-64" :class="sidebarOpen ? 'left-64' : 'left-0'">
        <div class="px-3 sm:px-6 py-3 sm:py-4">
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <!-- Mobile Menu Toggle Button -->
              <button @click="toggleSidebar" class="lg:hidden p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors mr-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
              </button>
              <div>
                <h1 class="text-lg sm:text-2xl font-bold text-gray-900">{{ pageTitle }}</h1>
                <p class="text-xs sm:text-sm text-gray-600 mt-1 hidden sm:block">{{ pageSubtitle }}</p>
              </div>
            </div>
            
            <div class="flex items-center space-x-2 sm:space-x-4">
              <!-- Search Bar -->
              <div class="relative hidden sm:block">
                <input 
                  type="text" 
                  placeholder="Search anything..." 
                  class="w-32 sm:w-48 md:w-64 pl-8 sm:pl-10 pr-2 sm:pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-900 placeholder-gray-500 text-sm"
                >
                <svg class="absolute left-2 sm:left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
              
              <!-- Mobile Search Button -->
              <button class="sm:hidden p-2 text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </button>
              
              <!-- Notifications -->
              <div class="relative">
                <button class="relative p-2 text-gray-600 hover:text-gray-900">
                  <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                  </svg>
                  <span v-if="unreadNotifications > 0" class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
              </div>
              
              <!-- Settings -->
              <button @click="openSettings" class="p-2 text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
              </button>
              
              <!-- Advanced User Profile Dropdown -->
              <div class="relative" @click="profileDropdownOpen = !profileDropdownOpen">
                <button class="flex items-center space-x-2 sm:space-x-3 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                  <div class="text-right hidden sm:block">
                    <p class="text-xs sm:text-sm font-medium text-gray-900">{{ user?.full_name || 'Admin' }}</p>
                    <p class="text-xs text-gray-500 hidden lg:block">{{ user?.roles?.[0]?.display_name || 'Administrator' }}</p>
                  </div>
                  <div class="relative">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-indigo-600 rounded-full flex items-center justify-center">
                      <span class="text-white font-medium text-xs sm:text-sm">{{ user?.full_name?.charAt(0) || 'A' }}</span>
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                  </div>
                  <svg class="w-4 h-4 text-gray-400 hidden sm:block" :class="profileDropdownOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>

                <!-- Dropdown Menu -->
                <div v-if="profileDropdownOpen" 
                     class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-xl border border-gray-200 z-50 overflow-hidden"
                     @click.stop>
                  <!-- Profile Header -->
                  <div class="bg-gradient-to-r from-indigo-600 to-blue-600 p-4 text-white">
                    <div class="flex items-center space-x-3">
                      <div class="relative">
                        <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                          <span class="text-2xl font-bold text-white">{{ user?.full_name?.charAt(0) || 'A' }}</span>
                        </div>
                        <div class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></div>
                      </div>
                      <div class="flex-1">
                        <h3 class="text-lg font-semibold">{{ user?.full_name || 'Admin User' }}</h3>
                        <p class="text-indigo-100 text-sm">{{ user?.email || 'admin@tanzaniahr.com' }}</p>
                        <p class="text-indigo-200 text-xs mt-1">{{ user?.roles?.[0]?.display_name || 'Administrator' }}</p>
                      </div>
                    </div>
                  </div>

                  <!-- Quick Stats -->
                  <div class="p-4 border-b border-gray-100 bg-gray-50">
                    <div class="grid grid-cols-3 gap-4 text-center">
                      <div>
                        <p class="text-2xl font-bold text-gray-900">156</p>
                        <p class="text-xs text-gray-500">Employees</p>
                      </div>
                      <div>
                        <p class="text-2xl font-bold text-gray-900">8</p>
                        <p class="text-xs text-gray-500">Projects</p>
                      </div>
                      <div>
                        <p class="text-2xl font-bold text-gray-900">92%</p>
                        <p class="text-xs text-gray-500">Complete</p>
                      </div>
                    </div>
                  </div>

                  <!-- Menu Items -->
                  <div class="py-2">
                    <!-- Profile Section -->
                    <div class="px-3 py-2">
                      <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Profile</p>
                      <a href="#" class="flex items-center space-x-3 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>My Profile</span>
                      </a>
                      <a href="#" class="flex items-center space-x-3 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        </svg>
                        <span>Account Settings</span>
                      </a>
                      <a href="#" class="flex items-center space-x-3 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span>Notifications</span>
                        <span v-if="unreadNotifications > 0" class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ unreadNotifications }}</span>
                      </a>
                    </div>

                    <!-- System Section -->
                    <div class="px-3 py-2 border-t border-gray-100">
                      <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">System</p>
                      <a href="#" class="flex items-center space-x-3 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        <span>System Settings</span>
                      </a>
                      <a href="#" class="flex items-center space-x-3 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Help & Documentation</span>
                      </a>
                      <a href="#" class="flex items-center space-x-3 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>About</span>
                      </a>
                    </div>

                    <!-- Actions Section -->
                    <div class="px-3 py-2 border-t border-gray-100">
                      <button @click="toggleDarkMode" class="w-full flex items-center space-x-3 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 006.354-2.646zM12 7a5 5 0 100 10 5 5 0 000-10z" />
                        </svg>
                        <span>Dark Mode</span>
                        <div class="ml-auto w-10 h-6 bg-gray-200 rounded-full relative">
                          <div class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full shadow-sm transition-transform" :class="darkMode ? 'translate-x-4' : ''"></div>
                        </div>
                      </button>
                      <button @click="logout" class="w-full flex items-center space-x-3 px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Sign Out</span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>

      <!-- Page Content -->
      <main class="p-3 sm:p-4 md:p-6 mt-16 sm:mt-20 lg:mt-24">
        <slot />
      </main>
    </div>
  </div>
</template>

<script>
import { computed, onMounted, onUnmounted, ref } from 'vue'
import { useStore } from 'vuex'
import { useRouter, useRoute } from 'vue-router'
import AdvancedNotification from './AdvancedNotification.vue'
import notification from '../utils/notification.js'
import { idleConfig, shouldExcludeIdleDetection, getIdleTimeoutMs, getLogoutTimeoutMs, getWarningDurationMs } from '../config/idleConfig.js'

export default {
  name: 'AppLayout',
  components: {
    AdvancedNotification
  },
  setup() {
    const store = useStore()
    const router = useRouter()
    const route = useRoute()
    
    // Idle detection variables
    let idleTimer = null
    let warningTimer = null
    let lastActivity = Date.now()
    const showIdleWarning = ref(false)
    const countdownSeconds = ref(getWarningDurationMs() / 1000)
    
    // Use configuration values
    const idleTimeout = getIdleTimeoutMs()
    const logoutTimeout = getLogoutTimeoutMs()
    const warningTimeout = getWarningDurationMs()

    // Activity tracking
    const updateLastActivity = () => {
      lastActivity = Date.now()
      showIdleWarning.value = false
      resetIdleTimer()
    }

    const resetIdleTimer = () => {
      clearTimeout(idleTimer)
      clearTimeout(warningTimer)
      
      idleTimer = setTimeout(() => {
        displayIdleWarning()
      }, idleTimeout - warningTimeout)
    }

    const displayIdleWarning = () => {
      showIdleWarning.value = true
      countdownSeconds.value = getWarningDurationMs() / 1000
      
      // Start countdown
      warningTimer = setInterval(() => {
        countdownSeconds.value--
        if (countdownSeconds.value <= 0) {
          clearInterval(warningTimer)
          performIdleLogout()
        }
      }, 1000)
      
      // Show warning notification
      notification.warning('Session Expiring', `Your session will expire in ${countdownSeconds.value} seconds due to inactivity.`)
    }

    const performIdleLogout = async () => {
      showIdleWarning.value = false
      notification.info('Session Expired', 'You have been logged out due to inactivity.')
      
      try {
        await store.dispatch('logout')
        setTimeout(() => {
          window.location.href = '/login?logout=true&reason=idle'
        }, 2000)
      } catch (error) {
        window.location.href = '/login?logout=true&reason=idle'
      }
    }

    const extendSession = () => {
      updateLastActivity()
      notification.success('Session Extended', 'Your session has been extended for another 5 minutes.')
    }

    // Sidebar state
    const sidebarOpen = ref(true)
    const profileDropdownOpen = ref(false)
    const darkMode = ref(false)
    const dropdowns = ref({
      dashboard: false,
      employees: false,
      payroll: false,
      discipline: false,
      leave: false,
      recruitment: false,
      performance: false,
      training: false,
      attendance: false,
      compliance: false,
      reports: false,
      settings: false
    })

    const toggleSidebar = () => {
      sidebarOpen.value = !sidebarOpen.value
    }

    const toggleDropdown = (menu) => {
      // Close all other dropdowns
      Object.keys(dropdowns.value).forEach(key => {
        if (key !== menu) {
          dropdowns.value[key] = false
        }
      })
      // Toggle the current dropdown
      dropdowns.value[menu] = !dropdowns.value[menu]
    }

    const closeAllDropdowns = () => {
      Object.keys(dropdowns.value).forEach(key => {
        dropdowns.value[key] = false
      })
    }

    const toggleDarkMode = () => {
      darkMode.value = !darkMode.value
      // Apply dark mode to document
      if (darkMode.value) {
        document.documentElement.classList.add('dark')
      } else {
        document.documentElement.classList.remove('dark')
      }
    }

    // Close dropdown when clicking outside
    const handleClickOutside = (event) => {
      if (!event.target.closest('.relative')) {
        profileDropdownOpen.value = false
      }
      // Close all sidebar dropdowns when clicking outside sidebar
      if (!event.target.closest('aside')) {
        Object.keys(dropdowns.value).forEach(key => {
          dropdowns.value[key] = false
        })
      }
    }

    onMounted(() => {
      if (!store.state.user) {
        store.dispatch('fetchUser')
      }
      // Add click outside listener
      document.addEventListener('click', handleClickOutside)
    })

    onUnmounted(() => {
      // Remove click outside listener
      document.removeEventListener('click', handleClickOutside)
    })

    const user = computed(() => store.state.user)
    const unreadNotifications = computed(() => store.state.notifications?.filter(n => !n.read).length || 0)

    const pageTitle = computed(() => {
      const titles = {
        'dashboard': 'Dashboard',
        'employees': 'Employee Management',
        'payroll': 'Payroll Management',
        'discipline': 'Discipline Management',
        'compliance': 'Compliance Management',
        'attendance': 'Attendance Management',
        'leave': 'Leave Management',
        'recruitment': 'Recruitment Management',
        'performance': 'Performance Management',
        'training': 'Training Management'
      }
      return titles[route.name] || 'Dashboard'
    })

    const pageSubtitle = computed(() => {
      const subtitles = {
        'dashboard': 'Welcome to Tanzania HR Management System',
        'employees': 'Manage employee records and information',
        'payroll': 'Process payroll and manage statutory deductions',
        'discipline': 'Handle disciplinary cases and compliance',
        'compliance': 'Monitor compliance and legal requirements',
        'attendance': 'Track employee attendance and timesheets',
        'leave': 'Manage leave requests and balances',
        'recruitment': 'Handle recruitment and onboarding',
        'performance': 'Manage performance reviews and appraisals',
        'training': 'Coordinate training and development'
      }
      return subtitles[route.name] || 'System Overview'
    })

    const logout = async () => {
      try {
        // Set logout flag to skip splash screen on next login page load
        sessionStorage.setItem('isLoggingOut', 'true')
        
        await store.dispatch('logout')
        notification.success('Logged Out', 'You have been successfully logged out.')
        setTimeout(() => {
          window.location.href = '/login?logout=true'
        }, 1500)
      } catch (error) {
        notification.error('Logout Failed', 'There was an error logging out. Please try again.')
      }
    }

    const openSettings = () => {
      // Navigate to settings page or open settings modal
      router.push('/settings')
    }

    onMounted(() => {
      if (!store.state.user) {
        store.dispatch('fetchUser')
      }
      
      // Only set up idle detection if enabled and not on excluded page
      if (idleConfig.enabled && !shouldExcludeIdleDetection(route.path)) {
        // Set up activity event listeners for idle detection
        const handleActivity = () => {
          updateLastActivity()
        }
        
        idleConfig.activityEvents.forEach(event => {
          document.addEventListener(event, handleActivity, true)
        })
        
        // Initialize idle timer
        resetIdleTimer()
        
        // Store event listener references for cleanup
        window._activityEvents = idleConfig.activityEvents
        window._handleActivity = handleActivity
        
        if (idleConfig.debug) {
          console.log('Idle detection enabled on:', route.path)
        }
      }
    })

    onUnmounted(() => {
      // Clean up event listeners
      if (window._activityEvents && window._handleActivity) {
        window._activityEvents.forEach(event => {
          document.removeEventListener(event, window._handleActivity, true)
        })
        delete window._activityEvents
        delete window._handleActivity
      }
      
      // Clear timers
      clearTimeout(idleTimer)
      clearTimeout(warningTimer)
    })

    return {
      user,
      unreadNotifications,
      pageTitle,
      pageSubtitle,
      logout,
      openSettings,
      route,
      sidebarOpen,
      toggleSidebar,
      toggleDropdown,
      closeAllDropdowns,
      dropdowns,
      profileDropdownOpen,
      darkMode,
      toggleDarkMode,
      handleClickOutside,
      // Idle detection
      showIdleWarning,
      countdownSeconds,
      extendSession,
      performIdleLogout
    }
  }
}
</script>
