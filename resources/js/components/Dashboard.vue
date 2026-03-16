<template>
  <div class="space-y-6 p-6">
    <!-- Welcome Section -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
      <div class="flex items-center justify-between">
        <div>
          <h2 class="text-2xl font-bold text-gray-900">Welcome back, {{ user?.full_name || 'Admin User' }}!</h2>
          <p class="text-gray-600 mt-1">Your employees completed 80% of tasks.</p>
          <p class="text-green-600 font-medium">Progress is very good!</p>
        </div>
        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center">
          <span class="text-2xl font-bold text-indigo-600">{{ user?.full_name?.charAt(0) || 'A' }}</span>
        </div>
      </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <!-- Total Employees Card -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Total Employees</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ analytics.total_employees }}</p>
            <div class="flex items-center mt-2">
              <span class="text-sm text-green-600 font-medium">+12%</span>
              <span class="text-sm text-gray-500 ml-1">from last month</span>
            </div>
          </div>
          <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
          </div>
        </div>
      </div>

      <!-- Active Employees Card -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Active Employees</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ analytics.active_employees }}</p>
            <div class="flex items-center mt-2">
              <span class="text-sm text-green-600 font-medium">+8%</span>
              <span class="text-sm text-gray-500 ml-1">from last month</span>
            </div>
          </div>
          <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
        </div>
      </div>

      <!-- Discipline Cases Card -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Discipline Cases</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ analytics.discipline_cases }}</p>
            <div class="flex items-center mt-2">
              <span class="text-sm text-red-600 font-medium">+3%</span>
              <span class="text-sm text-gray-500 ml-1">from last month</span>
            </div>
          </div>
          <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
          </div>
        </div>
      </div>

      <!-- Compliance Issues Card -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm font-medium text-gray-600">Compliance Issues</p>
            <p class="text-3xl font-bold text-gray-900 mt-2">{{ analytics.compliance_issues }}</p>
            <div class="flex items-center mt-2">
              <span class="text-sm text-green-600 font-medium">-15%</span>
              <span class="text-sm text-gray-500 ml-1">from last month</span>
            </div>
          </div>
          <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
        </div>
      </div>
    </div>

    <!-- Working Hours Analytics -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
      <!-- Header Section -->
      <div class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <div>
            <h3 class="text-xl font-bold mb-2 text-white">Working Hours Analytics</h3>
            <p class="text-indigo-100 text-sm text-white">Comprehensive time tracking and productivity analysis</p>
          </div>
          <div class="flex space-x-2">
            <button v-for="period in workingHoursPeriods" :key="period.key" 
                    @click="selectedPeriod = period.key"
                    :class="selectedPeriod === period.key ? 'bg-white text-indigo-600' : 'bg-indigo-500 text-white'"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 hover:scale-105">
              {{ period.label }}
            </button>
          </div>
        </div>
      </div>

      <!-- Key Metrics Dashboard -->
      <div class="p-6 bg-gray-50">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
          <!-- Total Hours Card -->
          <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-start justify-between mb-4">
              <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div>
                  <h4 class="text-lg font-bold text-gray-900">Total Hours</h4>
                  <p class="text-2xl font-semibold text-blue-600 mt-1">{{ workingHours.hours }}</p>
                </div>
              </div>
              <div class="text-right">
                <span class="text-lg font-bold text-green-600">+12%</span>
                <p class="text-xs text-green-600">vs last period</p>
              </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
              <div class="flex justify-between items-center text-sm">
                <span class="text-gray-600 font-medium">Monthly Target</span>
                <span class="text-sm font-bold text-gray-900">160 hours</span>
              </div>
              <div class="mt-3">
                <div class="w-full bg-gray-200 rounded-full h-2">
                  <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-2 rounded-full transition-all duration-500" 
                         :style="{ width: Math.min((workingHours.hours / 160) * 100, 100) + '%' }">
                  </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">{{ Math.round((workingHours.hours / 160) * 100) }}% completed</p>
              </div>
            </div>
          </div>

          <!-- Tasks Completed Card -->
          <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-start justify-between mb-4">
              <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div>
                  <h4 class="text-lg font-bold text-gray-900">Tasks Completed</h4>
                  <p class="text-2xl font-semibold text-green-600 mt-1">{{ workingHours.tasks }}</p>
                </div>
              </div>
              <div class="text-right">
                <span class="text-lg font-bold text-green-600">+15%</span>
                <p class="text-xs text-green-600">productivity gain</p>
              </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
              <div class="flex justify-between items-center text-sm">
                <span class="text-gray-600 font-medium">Daily Average</span>
                <span class="text-sm font-bold text-gray-900">{{ Math.round(workingHours.tasks / 22) }} tasks</span>
              </div>
              <div class="mt-3">
                <div class="w-full bg-gray-200 rounded-full h-2">
                  <div class="bg-gradient-to-r from-green-400 to-green-600 h-2 rounded-full transition-all duration-500" 
                         :style="{ width: Math.min((workingHours.tasks / 50) * 100, 100) + '%' }">
                  </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">{{ Math.round((workingHours.tasks / 50) * 100) }}% of target</p>
              </div>
            </div>
          </div>

          <!-- Efficiency Score Card -->
          <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="text-center mb-4">
              <div class="w-20 h-20 bg-gradient-to-br from-green-400 via-emerald-500 to-green-600 rounded-full flex items-center justify-center mx-auto shadow-lg mb-3">
                <span class="text-3xl font-bold text-white">{{ Math.round((workingHours.tasks / workingHours.hours) * 100) }}%</span>
              </div>
              <h4 class="text-lg font-bold text-gray-900 mb-1">Efficiency Score</h4>
              <p class="text-2xl font-bold text-green-600">{{ getEfficiencyGrade(Math.round((workingHours.tasks / workingHours.hours) * 100)) }}</p>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
              <div class="text-center">
                <span class="text-sm px-3 py-1 bg-green-100 text-green-800 rounded-full font-medium">Excellent Performance</span>
                <p class="text-xs text-gray-500 mt-2">Top 10% this month</p>
              </div>
            </div>
          </div>

          <!-- Overtime Analysis Card -->
          <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-start justify-between mb-4">
              <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center flex-shrink-0">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z" />
                  </svg>
                </div>
                <div>
                  <h4 class="text-lg font-bold text-gray-900">Overtime</h4>
                  <p class="text-2xl font-semibold" :class="workingHours.hours > 160 ? 'text-yellow-600' : 'text-gray-500'">
                    {{ Math.max(0, workingHours.hours - 160) }}
                  </p>
                </div>
              </div>
              <div class="text-right">
                <span class="text-lg font-bold" :class="workingHours.hours > 160 ? 'text-yellow-600' : 'text-gray-500'">
                  {{ workingHours.hours > 160 ? workingHours.hours - 160 : 0 }}h
                </span>
                <p class="text-xs" :class="workingHours.hours > 160 ? 'text-yellow-600' : 'text-gray-500'">this month</p>
              </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
              <div class="flex justify-between items-center text-sm">
                <span class="text-gray-600 font-medium">Status</span>
                <span class="text-sm font-bold" :class="workingHours.hours > 160 ? 'text-yellow-600' : 'text-green-600'">
                  {{ workingHours.hours > 160 ? 'Over Target' : 'Within Limit' }}
                </span>
              </div>
              <div class="mt-3">
                <div class="w-full bg-gray-200 rounded-full h-2">
                  <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 h-2 rounded-full transition-all duration-500" 
                         :style="{ width: Math.min(Math.max((workingHours.hours - 160) / 40 * 100, 0), 100) + '%' }">
                  </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">{{ Math.max(0, workingHours.hours - 160) }} hours overtime</p>
              </div>
            </div>
          </div>

          <!-- Attendance Rate Card -->
          <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 hover:shadow-lg transition-all duration-300 md:col-span-2 xl:col-span-1">
            <div class="flex items-start justify-between mb-4">
              <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                  <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2-2V7a2 2 0 002 2h2a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z" />
                  </svg>
                </div>
                <div>
                  <h4 class="text-lg font-bold text-gray-900">Attendance Rate</h4>
                  <p class="text-2xl font-semibold text-purple-600 mt-1">{{ Math.round((workingHours.hours / 168) * 100) }}%</p>
                </div>
              </div>
              <div class="text-right">
                <span class="text-lg font-bold text-purple-600">{{ Math.round((workingHours.hours / 8) * 22) }}</span>
                <p class="text-xs text-purple-600">days present</p>
              </div>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
              <div class="flex justify-between items-center text-sm">
                <span class="text-gray-600 font-medium">Working Days</span>
                <span class="text-sm font-bold text-gray-900">22 days</span>
              </div>
              <div class="mt-3">
                <div class="w-full bg-gray-200 rounded-full h-2">
                  <div class="bg-gradient-to-r from-purple-400 to-purple-600 h-2 rounded-full transition-all duration-500" 
                         :style="{ width: Math.min((workingHours.hours / 168) * 100, 100) + '%' }">
                  </div>
                </div>
                <p class="text-xs text-gray-500 mt-1">{{ Math.round((workingHours.hours / 168) * 100) }}% attendance</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Employee Progress Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Employee Progress -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Employee Progress</h3>
          <button class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View List</button>
        </div>
        <div class="space-y-4">
          <div v-for="employee in employeeProgress" :key="employee.name" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
            <div class="flex items-center space-x-3">
              <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                <span class="text-xs font-medium text-indigo-600">{{ employee.name.charAt(0) }}</span>
              </div>
              <span class="text-sm font-medium text-gray-900">{{ employee.name }}</span>
              <div class="flex items-center space-x-2">
                <div class="w-24 bg-gray-200 rounded-full h-2">
                  <div class="bg-indigo-600 h-2 rounded-full" :style="{ width: employee.progress + '%' }"></div>
                </div>
                <span class="text-sm text-gray-600">{{ employee.progress }}%</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Todo List -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Todo List</h3>
          <button class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Add New</button>
        </div>
        <div class="space-y-3">
          <div v-for="todo in todoList" :key="todo.id" class="flex items-center space-x-3">
            <input type="checkbox" :checked="todo.completed" class="w-4 h-4 text-indigo-600 rounded focus:ring-indigo-500">
            <div class="flex-1">
              <p class="text-sm font-medium text-gray-900">{{ todo.task }}</p>
              <p class="text-xs text-gray-500">{{ todo.time }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Discipline Cases -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
          <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Recent Cases</h3>
            <button class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View All</button>
          </div>
        </div>
        <div class="p-6">
          <div v-if="recentDisciplines.length === 0" class="text-center text-gray-500 py-8">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <p>No recent discipline cases</p>
          </div>
          <div v-else class="space-y-4">
            <div v-for="disciplineCase in recentDisciplines" :key="disciplineCase.id" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
              <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                  <span class="text-indigo-600 font-medium text-sm">{{ disciplineCase.employee_name?.charAt(0) }}</span>
                </div>
                <div>
                  <p class="text-sm font-medium text-gray-900">{{ disciplineCase.employee_name }}</p>
                  <p class="text-xs text-gray-500">{{ disciplineCase.case_type }} - {{ disciplineCase.severity_level }}</p>
                </div>
              </div>
              <div class="text-right">
                <span :class="getRiskBadgeClass(disciplineCase.risk_score)" class="px-3 py-1 text-xs font-medium rounded-full">
                  {{ disciplineCase.risk_score }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Upcoming Deadlines -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-semibold text-gray-900">Upcoming Deadlines</h3>
          <button class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View All</button>
        </div>
      </div>
      <div class="p-6">
        <div v-if="upcomingDeadlines.length === 0" class="text-center text-gray-500 py-8">
          <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          <p>No upcoming deadlines</p>
        </div>
        <div v-else class="space-y-4">
          <div v-for="deadline in upcomingDeadlines" :key="deadline.id" class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div>
                <p class="text-sm font-medium text-gray-900">{{ deadline.title }}</p>
                <p class="text-xs text-gray-500">{{ deadline.type }}</p>
              </div>
            </div>
            <div class="text-right">
              <p class="text-sm font-medium text-gray-900">{{ formatDate(deadline.due_date) }}</p>
              <p class="text-xs" :class="getDaysClass(deadline.days_until)">
                {{ deadline.days_until }} days
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Employee Distribution Chart -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-lg font-semibold text-gray-900">Employee Distribution</h3>
          <button class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View All</button>
        </div>
        <div class="h-80 flex items-center justify-center bg-gray-50 rounded-lg">
          <div class="text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
            </svg>
            <p class="text-gray-600 font-medium">Employee Distribution Chart</p>
            <p class="text-sm text-gray-500 mt-1">Chart will be displayed here</p>
          </div>
        </div>
      </div>

      <!-- Compliance Status Chart -->
      <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-lg font-semibold text-gray-900">Compliance Status</h3>
          <button class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View All</button>
        </div>
        <div class="h-80 flex items-center justify-center bg-gray-50 rounded-lg">
          <div class="text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <p class="text-gray-600 font-medium">Compliance Status Chart</p>
            <p class="text-sm text-gray-500 mt-1">Chart will be displayed here</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'

export default {
  name: "Dashboard",
  setup() {
    // User data
    const user = ref({ full_name: 'Admin User', id: 1 })
    
    // Analytics data
    const analytics = ref({
      total_employees: 156,
      active_employees: 142,
      discipline_cases: 8,
      compliance_issues: 3
    })

    // Working hours data
    const workingHours = ref({
      hours: 168,
      tasks: 45
    })

    // Working hours periods
    const workingHoursPeriods = ref([
      { key: 'week', label: 'Week' },
      { key: 'month', label: 'Month' },
      { key: 'year', label: 'Year' }
    ])

    const selectedPeriod = ref('month')

    // Employee progress data
    const employeeProgress = ref([
      { name: 'John Smith', progress: 85 },
      { name: 'Sarah Johnson', progress: 92 },
      { name: 'Michael Brown', progress: 78 },
      { name: 'Emily Davis', progress: 88 }
    ])

    // Todo list data
    const todoList = ref([
      { id: 1, task: 'Review payroll submissions', time: '10:30 AM', completed: false },
      { id: 2, task: 'Update compliance documentation', time: '2:00 PM', completed: true },
      { id: 3, task: 'Schedule team meeting', time: '3:30 PM', completed: false }
    ])

    // Recent disciplines data
    const recentDisciplines = ref([
      { id: 1, employee_name: 'John Smith', case_type: 'Attendance', severity_level: 'Medium', risk_score: 'Medium' },
      { id: 2, employee_name: 'Sarah Johnson', case_type: 'Performance', severity_level: 'Low', risk_score: 'Low' }
    ])

    // Upcoming deadlines data
    const upcomingDeadlines = ref([
      { id: 1, title: 'Payroll Processing', type: 'Monthly', due_date: '2024-03-31', days_until: 5 },
      { id: 2, title: 'Compliance Report', type: 'Quarterly', due_date: '2024-04-15', days_until: 20 }
    ])

    // Methods
    const getEfficiencyGrade = (score) => {
      if (score >= 90) return 'A+'
      if (score >= 80) return 'A'
      if (score >= 70) return 'B'
      if (score >= 60) return 'C'
      return 'D'
    }

    const getRiskBadgeClass = (risk) => {
      const classes = {
        'Low': 'bg-green-100 text-green-800',
        'Medium': 'bg-yellow-100 text-yellow-800',
        'High': 'bg-red-100 text-red-800'
      }
      return classes[risk] || 'bg-gray-100 text-gray-800'
    }

    const formatDate = (date) => {
      return new Date(date).toLocaleDateString()
    }

    const getDaysClass = (days) => {
      if (days <= 7) return 'text-red-600 font-medium'
      if (days <= 14) return 'text-yellow-600 font-medium'
      return 'text-green-600 font-medium'
    }

    // Console log for debugging
    onMounted(() => {
      console.log('Dashboard mounted with complete data:', {
        user: user.value,
        analytics: analytics.value,
        workingHours: workingHours.value,
        employeeProgress: employeeProgress.value,
        todoList: todoList.value,
        recentDisciplines: recentDisciplines.value,
        upcomingDeadlines: upcomingDeadlines.value
      })
    })

    return {
      user,
      analytics,
      workingHours,
      workingHoursPeriods,
      selectedPeriod,
      employeeProgress,
      todoList,
      recentDisciplines,
      upcomingDeadlines,
      getEfficiencyGrade,
      getRiskBadgeClass,
      formatDate,
      getDaysClass
    }
  }
}
</script>
