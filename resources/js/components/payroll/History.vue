<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">Payroll History</h1>
      <p class="text-gray-600 mt-2">View historical payroll records and transactions</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Month</label>
          <select v-model="filters.month" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">All Months</option>
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Year</label>
          <select v-model="filters.year" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">All Years</option>
            <option value="2024">2024</option>
            <option value="2023">2023</option>
            <option value="2022">2022</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
          <select v-model="filters.department" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">All Departments</option>
            <option value="engineering">Engineering</option>
            <option value="sales">Sales</option>
            <option value="hr">Human Resources</option>
          </select>
        </div>
        <div class="flex items-end">
          <button @click="applyFilters" class="w-full bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition-colors">
            Apply Filters
          </button>
        </div>
      </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-green-100 rounded-full">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Paid</p>
            <p class="text-2xl font-semibold text-gray-900">TZS 245M</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-blue-100 rounded-full">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Employees Paid</p>
            <p class="text-2xl font-semibold text-gray-900">234</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-yellow-100 rounded-full">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Tax Deducted</p>
            <p class="text-2xl font-semibold text-gray-900">TZS 45M</p>
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
            <p class="text-sm font-medium text-gray-600">Avg Salary</p>
            <p class="text-2xl font-semibold text-gray-900">TZS 1.2M</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Payroll History Table -->
    <div class="bg-white rounded-lg shadow">
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
          <h3 class="text-lg font-semibold text-gray-900">Payroll Records</h3>
          <div class="flex space-x-2">
            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors">
              Export CSV
            </button>
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
              Generate Report
            </button>
          </div>
        </div>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pay Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employees</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gross Pay</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Net Pay</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2024-03-25</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">March 2024</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">234</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">TZS 285M</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">TZS 245M</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button class="text-indigo-600 hover:text-indigo-900 mr-3">View</button>
                <button class="text-gray-600 hover:text-gray-900">Download</button>
              </td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2024-02-25</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">February 2024</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">232</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">TZS 280M</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">TZS 242M</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button class="text-indigo-600 hover:text-indigo-900 mr-3">View</button>
                <button class="text-gray-600 hover:text-gray-900">Download</button>
              </td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2024-01-25</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">January 2024</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">230</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">TZS 275M</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">TZS 238M</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button class="text-indigo-600 hover:text-indigo-900 mr-3">View</button>
                <button class="text-gray-600 hover:text-gray-900">Download</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PayrollHistory',
  data() {
    return {
      filters: {
        month: '',
        year: '',
        department: ''
      }
    }
  },
  methods: {
    applyFilters() {
      console.log('Applying filters:', this.filters)
      // Apply filter logic here
    }
  }
}
</script>
