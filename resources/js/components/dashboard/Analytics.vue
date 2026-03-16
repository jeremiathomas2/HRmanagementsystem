<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">Dashboard Analytics</h1>
      <p class="text-gray-600 mt-2">Advanced analytics and insights for HR management</p>
    </div>

    <!-- Analytics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-blue-100 rounded-full">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Employees</p>
            <p class="text-2xl font-semibold text-gray-900">1,234</p>
            <p class="text-sm text-green-600">+12% from last month</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-green-100 rounded-full">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Attendance Rate</p>
            <p class="text-2xl font-semibold text-gray-900">94.5%</p>
            <p class="text-sm text-green-600">+2.3% from last month</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-yellow-100 rounded-full">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Avg Working Hours</p>
            <p class="text-2xl font-semibold text-gray-900">8.2h</p>
            <p class="text-sm text-yellow-600">-0.5h from last month</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-purple-100 rounded-full">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Productivity</p>
            <p class="text-2xl font-semibold text-gray-900">87%</p>
            <p class="text-sm text-green-600">+5% from last month</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Employee Growth Trend</h3>
        <div class="h-64 bg-gray-100 rounded flex items-center justify-center">
          <p class="text-gray-500">Chart placeholder - Employee Growth Over Time</p>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Department Distribution</h3>
        <div class="h-64 bg-gray-100 rounded flex items-center justify-center">
          <p class="text-gray-500">Chart placeholder - Department Distribution</p>
        </div>
      </div>
    </div>

    <!-- Detailed Analytics Table -->
    <div class="bg-white rounded-lg shadow">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Department Performance Metrics</h3>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employees</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attendance</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Productivity</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Satisfaction</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Engineering</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">45</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">96%</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">92%</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4.5/5</td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Sales</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">32</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">94%</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">88%</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4.2/5</td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">HR</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">12</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">98%</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">95%</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4.8/5</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DashboardAnalytics'
}
</script>
