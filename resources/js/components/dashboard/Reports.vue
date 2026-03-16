<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">Dashboard Reports</h1>
      <p class="text-gray-600 mt-2">Comprehensive HR reports and documentation</p>
    </div>

    <!-- Report Categories -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
      <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow cursor-pointer">
        <div class="flex items-center mb-4">
          <div class="p-3 bg-blue-100 rounded-full">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v1a3 3 0 003 3h0a3 3 0 003-3v-1m3-10V4a2 2 0 00-2-2H8a2 2 0 00-2 2v3m0 0h12M5 7h14" />
            </svg>
          </div>
          <h3 class="ml-3 text-lg font-semibold text-gray-900">Monthly Reports</h3>
        </div>
        <p class="text-gray-600 mb-4">Comprehensive monthly HR analytics and metrics</p>
        <button class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors">
          Generate Report
        </button>
      </div>

      <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow cursor-pointer">
        <div class="flex items-center mb-4">
          <div class="p-3 bg-green-100 rounded-full">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <h3 class="ml-3 text-lg font-semibold text-gray-900">Payroll Reports</h3>
        </div>
        <p class="text-gray-600 mb-4">Detailed payroll and compensation analysis</p>
        <button class="w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition-colors">
          Generate Report
        </button>
      </div>

      <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow cursor-pointer">
        <div class="flex items-center mb-4">
          <div class="p-3 bg-purple-100 rounded-full">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
          <h3 class="ml-3 text-lg font-semibold text-gray-900">Compliance Reports</h3>
        </div>
        <p class="text-gray-600 mb-4">Regulatory compliance and audit reports</p>
        <button class="w-full bg-purple-600 text-white py-2 px-4 rounded hover:bg-purple-700 transition-colors">
          Generate Report
        </button>
      </div>
    </div>

    <!-- Recent Reports -->
    <div class="bg-white rounded-lg shadow">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Recent Reports</h3>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Report Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Generated</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Monthly HR Summary</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Monthly</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-03-15</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button class="text-indigo-600 hover:text-indigo-900 mr-3">View</button>
                <button class="text-gray-600 hover:text-gray-900">Download</button>
              </td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Payroll Analysis Q1</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Payroll</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-03-14</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button class="text-indigo-600 hover:text-indigo-900 mr-3">View</button>
                <button class="text-gray-600 hover:text-gray-900">Download</button>
              </td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Compliance Audit Report</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Compliance</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-03-13</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Processing</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button class="text-indigo-600 hover:text-indigo-900 mr-3">View</button>
                <button class="text-gray-400 cursor-not-allowed">Download</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Schedule New Report -->
    <div class="mt-8 bg-white rounded-lg shadow p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Schedule New Report</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Report Type</label>
          <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option>Monthly HR Summary</option>
            <option>Payroll Analysis</option>
            <option>Compliance Report</option>
            <option>Attendance Report</option>
            <option>Performance Review</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Schedule</label>
          <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option>Immediately</option>
            <option>Daily</option>
            <option>Weekly</option>
            <option>Monthly</option>
            <option>Quarterly</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Email Recipients</label>
          <input type="email" placeholder="hr@company.com" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div class="flex items-end">
          <button class="w-full bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 transition-colors">
            Schedule Report
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DashboardReports'
}
</script>
