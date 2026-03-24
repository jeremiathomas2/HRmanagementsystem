<template>
  <div class="p-6">
    <div class="mb-6 flex justify-between items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Backup & Recovery</h1>
        <p class="text-gray-600 mt-2">Advanced system backup and data recovery management</p>
      </div>
      <div class="flex space-x-2">
        <button @click="createBackup" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
          Create Backup
        </button>
        <button @click="scheduleBackup" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors">
          Schedule Backup
        </button>
      </div>
    </div>

    <!-- Backup Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-blue-100 rounded-full">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Backups</p>
            <p class="text-2xl font-semibold text-gray-900">24</p>
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
            <p class="text-sm font-medium text-gray-600">Successful</p>
            <p class="text-2xl font-semibold text-gray-900">22</p>
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
            <p class="text-sm font-medium text-gray-600">In Progress</p>
            <p class="text-2xl font-semibold text-gray-900">1</p>
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
            <p class="text-sm font-medium text-gray-600">Failed</p>
            <p class="text-2xl font-semibold text-gray-900">1</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Storage Usage -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Storage Usage</h3>
      <div class="mb-4">
        <div class="flex justify-between text-sm mb-2">
          <span class="text-gray-600">Used: 8.5 GB of 20 GB</span>
          <span class="text-gray-600">42.5%</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2">
          <div class="bg-blue-600 h-2 rounded-full" style="width: 42.5%"></div>
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
        <div class="flex justify-between">
          <span class="text-gray-600">Database:</span>
          <span class="font-medium text-gray-900">3.2 GB</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-600">Files:</span>
          <span class="font-medium text-gray-900">4.8 GB</span>
        </div>
        <div class="flex justify-between">
          <span class="text-gray-600">Logs:</span>
          <span class="font-medium text-gray-900">0.5 GB</span>
        </div>
      </div>
    </div>

    <!-- Backup Configuration -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Backup Configuration</h3>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Backup Type</label>
          <select v-model="backupConfig.type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option value="full">Full Backup</option>
            <option value="incremental">Incremental Backup</option>
            <option value="differential">Differential Backup</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Compression</label>
          <select v-model="backupConfig.compression" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option value="none">No Compression</option>
            <option value="gzip">Gzip</option>
            <option value="zip">ZIP</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Retention Period</label>
          <select v-model="backupConfig.retention" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option value="7">7 Days</option>
            <option value="30">30 Days</option>
            <option value="90">90 Days</option>
            <option value="365">1 Year</option>
          </select>
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Backup Location</label>
          <select v-model="backupConfig.location" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <option value="local">Local Storage</option>
            <option value="cloud">Cloud Storage</option>
            <option value="both">Local + Cloud</option>
          </select>
        </div>
      </div>
      <div class="mt-4">
        <label class="flex items-center">
          <input type="checkbox" v-model="backupConfig.encrypt" class="mr-2">
          <span class="text-sm text-gray-700">Encrypt backups with password</span>
        </label>
      </div>
    </div>

    <!-- Scheduled Backups -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
      <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Scheduled Backups</h3>
        <button @click="addSchedule" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition-colors text-sm">
          Add Schedule
        </button>
      </div>
      <div class="space-y-4">
        <div v-for="schedule in scheduledBackups" :key="schedule.id" class="border rounded-lg p-4">
          <div class="flex justify-between items-start">
            <div class="flex-1">
              <div class="flex items-center mb-2">
                <div class="p-2 bg-blue-100 rounded-lg mr-3">
                  <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
                <h4 class="font-medium text-gray-900">{{ schedule.name }}</h4>
              </div>
              <p class="text-sm text-gray-600 mb-3 ml-10">{{ schedule.description }}</p>
              <div class="flex flex-wrap gap-4 ml-10">
                <div class="flex items-center text-sm text-gray-500">
                  <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  {{ schedule.frequency }}
                </div>
                <div class="flex items-center text-sm text-gray-500">
                  <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  {{ schedule.time }}
                </div>
                <div class="flex items-center text-sm text-gray-500">
                  <svg class="w-4 h-4 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4 8 4m0-8l-8 4 8 4m-8-4v10m0 0l8 4m-8-4l-8-4m0 0v10m0 0l8 4m-8-4l-8-4" />
                  </svg>
                  {{ schedule.type }}
                </div>
                <div class="flex items-center text-sm text-gray-500">
                  <svg class="w-4 h-4 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                  </svg>
                  Next run: {{ schedule.nextRun || 'In 2 hours' }}
                </div>
                <div class="flex items-center text-sm text-gray-500">
                  <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                  </svg>
                  {{ schedule.location || 'Local + Cloud' }}
                </div>
              </div>
            </div>
            <div class="flex items-center space-x-2">
              <button @click="editSchedule(schedule)" class="text-blue-600 hover:text-blue-900 text-sm flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
              </button>
              <button @click="runNow(schedule)" class="text-green-600 hover:text-green-900 text-sm flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Run Now
              </button>
              <button @click="toggleSchedule(schedule)" class="text-yellow-600 hover:text-yellow-900 text-sm flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                {{ schedule.status === 'Active' ? 'Disable' : 'Enable' }}
              </button>
              <button @click="deleteSchedule(schedule.id)" class="text-red-600 hover:text-red-900 text-sm flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete
              </button>
            </div>
          </div>
          <div class="mt-3 flex items-center justify-between">
            <div class="flex items-center space-x-4">
              <span :class="getScheduleStatusClass(schedule.status)" class="px-2 py-1 text-xs font-semibold rounded-full flex items-center">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ schedule.status }}
              </span>
              <div class="text-xs text-gray-500">
                Last run: {{ schedule.lastRun || '2 days ago' }}
              </div>
            </div>
            <div class="flex items-center space-x-2">
              <div class="text-xs text-gray-500">
                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ schedule.duration || '12 min 34 sec' }}
              </div>
              <div class="text-xs text-gray-500">
                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h10l2 2m-2-2v10a2 2 0 01-2 2H9a2 2 0 01-2-2V9l2-2z" />
                </svg>
                {{ schedule.size || '2.3 GB' }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Backup History -->
    <div class="bg-white rounded-lg shadow">
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
          <h3 class="text-lg font-semibold text-gray-900">Backup History</h3>
          <div class="flex space-x-2">
            <input type="text" v-model="searchQuery" placeholder="Search backups..." class="px-3 py-2 border border-gray-300 rounded-md text-sm">
            <select v-model="filterStatus" class="px-3 py-2 border border-gray-300 rounded-md text-sm">
              <option value="">All Status</option>
              <option value="completed">Completed</option>
              <option value="failed">Failed</option>
              <option value="in-progress">In Progress</option>
            </select>
          </div>
        </div>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="backup in filteredBackups" :key="backup.id">
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ backup.date }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ backup.type }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ backup.size }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ backup.duration }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getStatusClass(backup.status)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                  {{ backup.status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ backup.location }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button @click="downloadBackup(backup)" class="text-indigo-600 hover:text-indigo-900 mr-3">Download</button>
                <button @click="restoreBackup(backup)" class="text-green-600 hover:text-green-900 mr-3">Restore</button>
                <button @click="deleteBackup(backup.id)" class="text-red-600 hover:text-red-900">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Backup Modal -->
    <div v-if="showBackupModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" @click="closeBackupModal">
      <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white" @click.stop>
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Create New Backup</h3>
          <button @click="closeBackupModal" class="text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Backup Name</label>
            <input type="text" v-model="newBackup.name" placeholder="Enter backup name" class="w-full px-3 py-2 border border-gray-300 rounded-md">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea v-model="newBackup.description" placeholder="Enter backup description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Include</label>
            <div class="space-y-2">
              <label class="flex items-center">
                <input type="checkbox" v-model="newBackup.include.database" class="mr-2">
                <span class="text-sm text-gray-700">Database</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" v-model="newBackup.include.files" class="mr-2">
                <span class="text-sm text-gray-700">Files and Documents</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" v-model="newBackup.include.logs" class="mr-2">
                <span class="text-sm text-gray-700">System Logs</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" v-model="newBackup.include.config" class="mr-2">
                <span class="text-sm text-gray-700">Configuration Files</span>
              </label>
            </div>
          </div>
          <div class="flex justify-end space-x-2">
            <button @click="closeBackupModal" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition-colors">
              Cancel
            </button>
            <button @click="startBackup" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
              Start Backup
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import notification from '../../utils/notification.js'

export default {
  name: 'SystemBackup',
  data() {
    return {
      showBackupModal: false,
      searchQuery: '',
      filterStatus: '',
      backupConfig: {
        type: 'full',
        compression: 'gzip',
        retention: '30',
        location: 'both',
        encrypt: true
      },
      newBackup: {
        name: '',
        description: '',
        include: {
          database: true,
          files: true,
          logs: false,
          config: true
        }
      },
      scheduledBackups: [
        {
          id: 1,
          name: 'Daily Full Backup',
          description: 'Complete system backup every day at 2 AM',
          frequency: 'Daily',
          time: '02:00',
          type: 'Full',
          status: 'Active',
          nextRun: 'In 2 hours',
          location: 'Local + Cloud',
          lastRun: '2 days ago',
          duration: '12 min 34 sec',
          size: '2.3 GB'
        },
        {
          id: 2,
          name: 'Weekly Incremental',
          description: 'Incremental backup every Sunday at 1 AM',
          frequency: 'Weekly',
          time: '01:00',
          type: 'Incremental',
          status: 'Active',
          nextRun: 'In 3 days',
          location: 'Cloud',
          lastRun: '5 days ago',
          duration: '2 min 12 sec',
          size: '156 MB'
        },
        {
          id: 3,
          name: 'Monthly Archive',
          description: 'Monthly full backup with long-term retention',
          frequency: 'Monthly',
          time: '03:00',
          type: 'Full',
          status: 'Active',
          nextRun: 'In 14 days',
          location: 'Local + Cloud',
          lastRun: '12 days ago',
          duration: '15 min 45 sec',
          size: '3.1 GB'
        }
      ],
      backups: [
        {
          id: 1,
          date: '2024-03-16 06:00:00',
          type: 'Full',
          size: '2.3 GB',
          duration: '12 min 34 sec',
          status: 'completed',
          location: 'Local + Cloud'
        },
        {
          id: 2,
          date: '2024-03-15 06:00:00',
          type: 'Full',
          size: '2.2 GB',
          duration: '11 min 45 sec',
          status: 'completed',
          location: 'Local + Cloud'
        },
        {
          id: 3,
          date: '2024-03-14 06:00:00',
          type: 'Incremental',
          size: '156 MB',
          duration: '2 min 12 sec',
          status: 'completed',
          location: 'Cloud'
        },
        {
          id: 4,
          date: '2024-03-13 06:00:00',
          type: 'Full',
          size: '2.1 GB',
          duration: '13 min 20 sec',
          status: 'failed',
          location: 'Local'
        }
      ]
    }
  },
  computed: {
    filteredBackups() {
      let filtered = this.backups
      
      if (this.filterStatus) {
        filtered = filtered.filter(backup => backup.status === this.filterStatus)
      }
      
      if (this.searchQuery) {
        filtered = filtered.filter(backup => 
          backup.type.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          backup.location.toLowerCase().includes(this.searchQuery.toLowerCase())
        )
      }
      
      return filtered
    }
  },
  methods: {
    getStatusClass(status) {
      const classes = {
        completed: 'bg-green-100 text-green-800',
        failed: 'bg-red-100 text-red-800',
        'in-progress': 'bg-yellow-100 text-yellow-800'
      }
      return classes[status] || 'bg-gray-100 text-gray-800'
    },
    getScheduleStatusClass(status) {
      const classes = {
        Active: 'bg-green-100 text-green-800',
        Inactive: 'bg-gray-100 text-gray-800',
        Failed: 'bg-red-100 text-red-800'
      }
      return classes[status] || 'bg-gray-100 text-gray-800'
    },
    createBackup() {
      this.showBackupModal = true
      this.newBackup.name = `Backup_${new Date().toISOString().slice(0, 19).replace(/:/g, '-')}`
    },
    closeBackupModal() {
      this.showBackupModal = false
      this.newBackup = {
        name: '',
        description: '',
        include: {
          database: true,
          files: true,
          logs: false,
          config: true
        }
      }
    },
    startBackup() {
      console.log('Starting backup:', this.newBackup)
      notification.success('Backup Started', `Backup "${this.newBackup.name || 'System Backup'}" has been initiated successfully.`)
      this.showBackupModal = false
      // In a real application, this would start the backup process
    },
    scheduleBackup() {
      console.log('Opening backup schedule configuration')
      // In a real application, this would open a schedule configuration modal
    },
    addSchedule() {
      console.log('Adding new backup schedule')
      // In a real application, this would open a schedule creation modal
    },
    editSchedule(schedule) {
      console.log('Editing schedule:', schedule)
      // In a real application, this would open an edit modal
    },
    runNow(schedule) {
      if (confirm(`Are you sure you want to run backup "${schedule.name}" now?`)) {
        console.log('Running backup now:', schedule)
        notification.info('Backup Running', `Scheduled backup "${schedule.name}" is now running.`)
        // In a real application, this would initiate immediate backup
        setTimeout(() => {
          notification.success('Backup Completed', `Backup "${schedule.name}" completed successfully!`)
        }, 2000)
      }
    },
    toggleSchedule(schedule) {
      const newStatus = schedule.status === 'Active' ? 'Inactive' : 'Active'
      const index = this.scheduledBackups.findIndex(s => s.id === schedule.id)
      if (index !== -1) {
        this.scheduledBackups[index].status = newStatus
        console.log(`Schedule ${schedule.id} ${newStatus.toLowerCase()}`)
        notification.success('Schedule Updated', `Backup schedule "${schedule.name}" has been ${newStatus.toLowerCase()}.`)
      }
    },
    deleteSchedule(scheduleId) {
      if (confirm('Are you sure you want to delete this backup schedule?')) {
        const schedule = this.scheduledBackups.find(s => s.id === scheduleId)
        this.scheduledBackups = this.scheduledBackups.filter(s => s.id !== scheduleId)
        console.log('Schedule deleted:', scheduleId)
        notification.warning('Schedule Deleted', `Backup schedule "${schedule.name}" has been deleted.`)
      }
    },
    downloadBackup(backup) {
      console.log('Downloading backup:', backup)
      notification.success('Download Started', `Backup "${backup.date}" is being downloaded.`)
      // In a real application, this would initiate download
    },
    restoreBackup(backup) {
      if (confirm(`Are you sure you want to restore backup from ${backup.date}? This will overwrite current data.`)) {
        console.log('Restoring backup:', backup)
        notification.warning('Restore Started', `System restore from backup "${backup.date}" has been initiated.`)
        // In a real application, this would initiate restore process
      }
    },
    deleteBackup(backupId) {
      if (confirm('Are you sure you want to delete this backup? This action cannot be undone.')) {
        const backup = this.backups.find(b => b.id === backupId)
        this.backups = this.backups.filter(b => b.id !== backupId)
        console.log('Backup deleted:', backupId)
        notification.error('Backup Deleted', `Backup "${backup.date}" has been permanently deleted.`)
      }
    },
  }
}
</script>
