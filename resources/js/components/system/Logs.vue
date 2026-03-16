<template>
  <div class="p-6">
    <div class="mb-6 flex justify-between items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">System Logs</h1>
        <p class="text-gray-600 mt-2">Advanced system activity and audit log monitoring</p>
      </div>
      <div class="flex space-x-2">
        <button @click="refreshLogs" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
          Refresh
        </button>
        <button @click="exportLogs" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors">
          Export
        </button>
        <button @click="clearLogs" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">
          Clear Logs
        </button>
      </div>
    </div>

    <!-- Log Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-blue-100 rounded-full">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Logs</p>
            <p class="text-2xl font-semibold text-gray-900">15,234</p>
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
            <p class="text-sm font-medium text-gray-600">Info Logs</p>
            <p class="text-2xl font-semibold text-gray-900">8,456</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-yellow-100 rounded-full">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.502 0L4.316 16.5c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Warnings</p>
            <p class="text-2xl font-semibold text-gray-900">1,234</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-red-100 rounded-full">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Errors</p>
            <p class="text-2xl font-semibold text-gray-900">89</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Log Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Log Filters</h3>
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Log Level</label>
          <select v-model="filters.level" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">All Levels</option>
            <option value="debug">Debug</option>
            <option value="info">Info</option>
            <option value="warning">Warning</option>
            <option value="error">Error</option>
            <option value="critical">Critical</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
          <select v-model="filters.dateRange" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="week">Last 7 Days</option>
            <option value="month">Last 30 Days</option>
            <option value="all">All Time</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Module</label>
          <select v-model="filters.module" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option value="">All Modules</option>
            <option value="auth">Authentication</option>
            <option value="payroll">Payroll</option>
            <option value="employees">Employees</option>
            <option value="system">System</option>
            <option value="api">API</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
          <input type="text" v-model="filters.search" placeholder="Search logs..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>
      </div>
      <div class="mt-4 flex justify-end space-x-2">
        <button @click="applyFilters" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition-colors">
          Apply Filters
        </button>
        <button @click="resetFilters" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition-colors">
          Reset
        </button>
      </div>
    </div>

    <!-- Logs Table -->
    <div class="bg-white rounded-lg shadow">
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
          <h3 class="text-lg font-semibold text-gray-900">Recent Logs</h3>
          <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-500">Auto-refresh:</span>
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" v-model="autoRefresh" class="sr-only peer">
              <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
          </div>
        </div>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timestamp</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Level</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Module</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Message</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="log in filteredLogs" :key="log.id">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ log.timestamp }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getLogLevelClass(log.level)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                  {{ log.level.toUpperCase() }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ log.module }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ log.user }}</td>
              <td class="px-6 py-4 text-sm text-gray-900">
                <div class="max-w-xs truncate" :title="log.message">{{ log.message }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ log.ipAddress }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button @click="viewLogDetails(log)" class="text-indigo-600 hover:text-indigo-900 mr-3">View</button>
                <button @click="deleteLog(log.id)" class="text-red-600 hover:text-red-900">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="px-6 py-4 border-t border-gray-200">
        <div class="flex justify-between items-center">
          <span class="text-sm text-gray-700">
            Showing {{ filteredLogs.length }} of {{ logs.length }} logs
          </span>
          <div class="flex space-x-2">
            <button @click="previousPage" :disabled="currentPage === 1" class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50 disabled:opacity-50">
              Previous
            </button>
            <span class="px-3 py-1 text-sm">Page {{ currentPage }}</span>
            <button @click="nextPage" :disabled="currentPage * pageSize >= logs.length" class="px-3 py-1 border border-gray-300 rounded text-sm hover:bg-gray-50 disabled:opacity-50">
              Next
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Log Details Modal -->
    <div v-if="selectedLog" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" @click="closeLogDetails">
      <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white" @click.stop>
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Log Details</h3>
          <button @click="closeLogDetails" class="text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Timestamp</label>
            <p class="text-sm text-gray-900">{{ selectedLog.timestamp }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Level</label>
            <span :class="getLogLevelClass(selectedLog.level)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
              {{ selectedLog.level.toUpperCase() }}
            </span>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Module</label>
            <p class="text-sm text-gray-900">{{ selectedLog.module }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">User</label>
            <p class="text-sm text-gray-900">{{ selectedLog.user }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Message</label>
            <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ selectedLog.message }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">IP Address</label>
            <p class="text-sm text-gray-900">{{ selectedLog.ipAddress }}</p>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">User Agent</label>
            <p class="text-sm text-gray-900">{{ selectedLog.userAgent }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SystemLogs',
  data() {
    return {
      autoRefresh: false,
      refreshInterval: null,
      currentPage: 1,
      pageSize: 50,
      selectedLog: null,
      filters: {
        level: '',
        dateRange: 'today',
        module: '',
        search: ''
      },
      logs: [
        {
          id: 1,
          timestamp: '2024-03-16 19:03:45',
          level: 'info',
          module: 'auth',
          user: 'admin@tanzaniahr.com',
          message: 'User login successful',
          ipAddress: '127.0.0.1',
          userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        },
        {
          id: 2,
          timestamp: '2024-03-16 19:02:30',
          level: 'warning',
          module: 'payroll',
          user: 'jane@tanzaniahr.com',
          message: 'Payroll calculation completed with warnings for employee ID: EMP001',
          ipAddress: '127.0.0.1',
          userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        },
        {
          id: 3,
          timestamp: '2024-03-16 19:01:15',
          level: 'error',
          module: 'api',
          user: 'system',
          message: 'Database connection timeout while processing employee data',
          ipAddress: '127.0.0.1',
          userAgent: 'Internal API Call'
        },
        {
          id: 4,
          timestamp: '2024-03-16 19:00:00',
          level: 'info',
          module: 'system',
          user: 'system',
          message: 'Scheduled backup completed successfully',
          ipAddress: '127.0.0.1',
          userAgent: 'System Process'
        },
        {
          id: 5,
          timestamp: '2024-03-16 18:58:45',
          level: 'debug',
          module: 'employees',
          user: 'john@tanzaniahr.com',
          message: 'Employee record updated: John Doe - Department changed to Engineering',
          ipAddress: '127.0.0.1',
          userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
        }
      ]
    }
  },
  computed: {
    filteredLogs() {
      let filtered = this.logs
      
      if (this.filters.level) {
        filtered = filtered.filter(log => log.level === this.filters.level)
      }
      
      if (this.filters.module) {
        filtered = filtered.filter(log => log.module === this.filters.module)
      }
      
      if (this.filters.search) {
        filtered = filtered.filter(log => 
          log.message.toLowerCase().includes(this.filters.search.toLowerCase()) ||
          log.user.toLowerCase().includes(this.filters.search.toLowerCase())
        )
      }
      
      return filtered
    }
  },
  watch: {
    autoRefresh(newVal) {
      if (newVal) {
        this.refreshInterval = setInterval(() => {
          this.refreshLogs()
        }, 30000) // Refresh every 30 seconds
      } else {
        clearInterval(this.refreshInterval)
      }
    }
  },
  methods: {
    getLogLevelClass(level) {
      const classes = {
        debug: 'bg-gray-100 text-gray-800',
        info: 'bg-blue-100 text-blue-800',
        warning: 'bg-yellow-100 text-yellow-800',
        error: 'bg-red-100 text-red-800',
        critical: 'bg-purple-100 text-purple-800'
      }
      return classes[level] || 'bg-gray-100 text-gray-800'
    },
    refreshLogs() {
      console.log('Refreshing logs...')
      // In a real application, this would fetch fresh logs from the API
    },
    exportLogs() {
      console.log('Exporting logs...')
      // In a real application, this would export logs to CSV/JSON
    },
    clearLogs() {
      if (confirm('Are you sure you want to clear all logs? This action cannot be undone.')) {
        this.logs = []
        console.log('Logs cleared')
      }
    },
    applyFilters() {
      console.log('Applying filters:', this.filters)
      this.currentPage = 1
    },
    resetFilters() {
      this.filters = {
        level: '',
        dateRange: 'today',
        module: '',
        search: ''
      }
      this.currentPage = 1
    },
    viewLogDetails(log) {
      this.selectedLog = log
    },
    closeLogDetails() {
      this.selectedLog = null
    },
    deleteLog(logId) {
      if (confirm('Are you sure you want to delete this log entry?')) {
        this.logs = this.logs.filter(log => log.id !== logId)
        console.log('Log deleted:', logId)
      }
    },
    previousPage() {
      if (this.currentPage > 1) {
        this.currentPage--
      }
    },
    nextPage() {
      if (this.currentPage * this.pageSize < this.logs.length) {
        this.currentPage++
      }
    }
  },
  beforeUnmount() {
    if (this.refreshInterval) {
      clearInterval(this.refreshInterval)
    }
  }
}
</script>
