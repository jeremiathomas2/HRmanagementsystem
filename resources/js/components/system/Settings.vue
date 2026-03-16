<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">System Settings</h1>
      <p class="text-gray-600 mt-2">Configure system-wide settings and preferences</p>
    </div>

    <!-- General Settings -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">General Settings</h3>
      </div>
      <div class="p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
            <input type="text" v-model="settings.companyName" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Company Email</label>
            <input type="email" v-model="settings.companyEmail" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Timezone</label>
            <select v-model="settings.timezone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              <option value="Africa/Dar_es_Salaam">Dar es Salaam (EAT)</option>
              <option value="Africa/Nairobi">Nairobi (EAT)</option>
              <option value="UTC">UTC</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Date Format</label>
            <select v-model="settings.dateFormat" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              <option value="DD/MM/YYYY">DD/MM/YYYY</option>
              <option value="MM/DD/YYYY">MM/DD/YYYY</option>
              <option value="YYYY-MM-DD">YYYY-MM-DD</option>
            </select>
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Company Address</label>
          <textarea v-model="settings.companyAddress" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
        </div>
      </div>
    </div>

    <!-- HR Settings -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">HR Settings</h3>
      </div>
      <div class="p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Working Hours Per Day</label>
            <input type="number" v-model="settings.workingHours" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Working Days Per Week</label>
            <input type="number" v-model="settings.workingDays" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Probation Period (Days)</label>
            <input type="number" v-model="settings.probationPeriod" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Leave Accrual Frequency</label>
            <select v-model="settings.leaveAccrual" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              <option value="monthly">Monthly</option>
              <option value="quarterly">Quarterly</option>
              <option value="annually">Annually</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Payroll Settings -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Payroll Settings</h3>
      </div>
      <div class="p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Payroll Processing Day</label>
            <select v-model="settings.payrollDay" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              <option value="25">25th of Month</option>
              <option value="last">Last Day of Month</option>
              <option value="custom">Custom Day</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Currency</label>
            <select v-model="settings.currency" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
              <option value="TZS">Tanzanian Shilling (TZS)</option>
              <option value="USD">US Dollar (USD)</option>
              <option value="EUR">Euro (EUR)</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Notification Settings -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Notification Settings</h3>
      </div>
      <div class="p-6 space-y-4">
        <label class="flex items-center">
          <input type="checkbox" v-model="settings.emailNotifications" class="mr-2">
          <span class="text-sm text-gray-700">Enable Email Notifications</span>
        </label>
        <label class="flex items-center">
          <input type="checkbox" v-model="settings.birthdayReminders" class="mr-2">
          <span class="text-sm text-gray-700">Birthday Reminders</span>
        </label>
        <label class="flex items-center">
          <input type="checkbox" v-model="settings.contractExpiryAlerts" class="mr-2">
          <span class="text-sm text-gray-700">Contract Expiry Alerts</span>
        </label>
        <label class="flex items-center">
          <input type="checkbox" v-model="settings.leaveBalanceAlerts" class="mr-2">
          <span class="text-sm text-gray-700">Leave Balance Alerts</span>
        </label>
      </div>
    </div>

    <!-- Save Button -->
    <div class="flex justify-end">
      <button @click="saveSettings" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition-colors">
        Save Settings
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SystemSettings',
  data() {
    return {
      settings: {
        companyName: 'Tanzania HR Solutions Ltd',
        companyEmail: 'hr@tanzaniahr.com',
        timezone: 'Africa/Dar_es_Salaam',
        dateFormat: 'DD/MM/YYYY',
        companyAddress: 'Dar es Salaam, Tanzania',
        workingHours: 8,
        workingDays: 5,
        probationPeriod: 90,
        leaveAccrual: 'monthly',
        payrollDay: '25',
        currency: 'TZS',
        emailNotifications: true,
        birthdayReminders: true,
        contractExpiryAlerts: true,
        leaveBalanceAlerts: true
      }
    }
  },
  methods: {
    saveSettings() {
      // Save settings logic here
      alert('Settings saved successfully!')
    }
  }
}
</script>
