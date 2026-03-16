<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">Statutory Deductions</h1>
      <p class="text-gray-600 mt-2">Manage Tanzanian statutory contributions and deductions</p>
    </div>

    <!-- Statutory Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-blue-100 rounded-full">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">PAYE Tax</p>
            <p class="text-2xl font-semibold text-gray-900">TZS 45M</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-green-100 rounded-full">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">NSSF</p>
            <p class="text-2xl font-semibold text-gray-900">TZS 12M</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-yellow-100 rounded-full">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">WCF</p>
            <p class="text-2xl font-semibold text-gray-900">TZS 2.8M</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-purple-100 rounded-full">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">SDL</p>
            <p class="text-2xl font-semibold text-gray-900">TZS 1.5M</p>
          </div>
        </div>
      </div>
    </div>

    <!-- PAYE Tax Bands -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">PAYE Tax Bands (2024)</h3>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monthly Income (TZS)</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tax Rate</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tax Amount</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cumulative</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">0 - 270,000</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">0%</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">0</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">0</td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">270,001 - 520,000</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">8%</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">20,000</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">20,000</td>
            </tr>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">520,001 - 780,000</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">20%</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">52,000</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">72,000</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- NSSF Contributions -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">NSSF Contributions</h3>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <h4 class="text-md font-medium text-gray-900 mb-3">Tier 1 (Monthly Income ≤ TZS 270,000)</h4>
            <div class="space-y-2">
              <div class="flex justify-between">
                <span class="text-sm text-gray-600">Employee Contribution (5%)</span>
                <span class="text-sm font-medium text-gray-900">TZS 13,500</span>
              </div>
              <div class="flex justify-between">
                <span class="text-sm text-gray-600">Employer Contribution (5%)</span>
                <span class="text-sm font-medium text-gray-900">TZS 13,500</span>
              </div>
              <div class="flex justify-between border-t pt-2">
                <span class="text-sm font-medium text-gray-900">Total Contribution</span>
                <span class="text-sm font-medium text-gray-900">TZS 27,000</span>
              </div>
            </div>
          </div>
          <div>
            <h4 class="text-md font-medium text-gray-900 mb-3">Tier 2 (Monthly Income > TZS 270,000)</h4>
            <div class="space-y-2">
              <div class="flex justify-between">
                <span class="text-sm text-gray-600">Employee Contribution (5%)</span>
                <span class="text-sm font-medium text-gray-900">Variable</span>
              </div>
              <div class="flex justify-between">
                <span class="text-sm text-gray-600">Employer Contribution (10%)</span>
                <span class="text-sm font-medium text-gray-900">Variable</span>
              </div>
              <div class="flex justify-between border-t pt-2">
                <span class="text-sm font-medium text-gray-900">Total Contribution</span>
                <span class="text-sm font-medium text-gray-900">Variable</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Deductions -->
    <div class="bg-white rounded-lg shadow">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Recent Deductions</h3>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PAYE</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NSSF</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">WCF</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">John Doe</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">TZS 245,000</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">TZS 65,000</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">TZS 12,000</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">TZS 322,000</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PayrollStatutory'
}
</script>
