<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">Payroll Reports</h1>
      <p class="text-gray-600 mt-2">Generate and analyze payroll reports</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Payroll Reporting Dashboard</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="border rounded-lg p-4">
          <h4 class="font-medium text-gray-900 mb-2">Monthly Payroll Summary</h4>
          <p class="text-gray-600 text-sm mb-4">Comprehensive monthly payroll analysis</p>
          <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors text-sm">
            Generate Report
          </button>
        </div>
        <div class="border rounded-lg p-4">
          <h4 class="font-medium text-gray-900 mb-2">Tax Compliance Report</h4>
          <p class="text-gray-600 text-sm mb-4">PAYE and statutory deductions analysis</p>
          <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors text-sm">
            Generate Report
          </button>
        </div>
        <div class="border rounded-lg p-4">
          <h4 class="font-medium text-gray-900 mb-2">Year-to-Date Summary</h4>
          <p class="text-gray-600 text-sm mb-4">Cumulative payroll data for current year</p>
          <button class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition-colors text-sm">
            Generate Report
          </button>
        </div>
        <div class="border rounded-lg p-4">
          <h4 class="font-medium text-gray-900 mb-2">Department Cost Analysis</h4>
          <p class="text-gray-600 text-sm mb-4">Payroll costs by department</p>
          <button class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700 transition-colors text-sm">
            Generate Report
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PayrollReports'
}
</script>
