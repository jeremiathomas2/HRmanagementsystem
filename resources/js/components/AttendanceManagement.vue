<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center">
            <h1 class="text-xl font-semibold text-gray-900">Attendance Management</h1>
            <span class="ml-3 px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
              {{ currentDate }}
            </span>
          </div>
          <div class="flex items-center space-x-3">
            <button @click="markAttendance" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center">
              <CheckCircleIcon class="w-5 h-5 mr-2" />
              Mark Attendance
            </button>
            <button @click="exportReport" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
              <DocumentArrowDownIcon class="w-5 h-5 mr-2" />
              Export Report
            </button>
            <button @click="importAttendance" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 flex items-center">
              <ArrowDownTrayIcon class="w-5 h-5 mr-2" />
              Import
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Attendance Statistics -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
              <UserGroupIcon class="w-6 h-6 text-green-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Present Today</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.presentToday }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
              <ClockIcon class="w-6 h-6 text-yellow-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Late Arrivals</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.lateArrivals }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-red-100 rounded-lg">
              <XCircleIcon class="w-6 h-6 text-red-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Absent</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.absent }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
              <CalendarIcon class="w-6 h-6 text-blue-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">On Leave</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.onLeave }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Advanced Filters -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-6">
      <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-medium text-gray-900">Attendance Filters</h3>
          <button @click="resetFilters" class="text-sm text-gray-500 hover:text-gray-700">Reset All</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input v-model="filters.search" @input="searchAttendance" type="text" placeholder="Search by name, ID..." 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900 placeholder-gray-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
            <select v-model="filters.department_id" @change="loadAttendance" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Departments</option>
              <option v-for="dept in departments" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select v-model="filters.status" @change="loadAttendance" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Status</option>
              <option value="present">Present</option>
              <option value="late">Late</option>
              <option value="absent">Absent</option>
              <option value="on_leave">On Leave</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
            <select v-model="filters.date_range" @change="loadAttendance" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Time</option>
              <option value="today">Today</option>
              <option value="week">This Week</option>
              <option value="month">This Month</option>
              <option value="quarter">This Quarter</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Shift</label>
            <select v-model="filters.shift" @change="loadAttendance" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Shifts</option>
              <option value="morning">Morning</option>
              <option value="afternoon">Afternoon</option>
              <option value="night">Night</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Attendance Table -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shift</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hours Worked</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="record in attendanceRecords" :key="record.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center">
                        <span class="text-white font-medium">{{ record.employee_name?.charAt(0) }}</span>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ record.employee_name }}</div>
                      <div class="text-sm text-gray-500">{{ record.employee_number }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ record.department || 'N/A' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getShiftBadgeClass(record.shift)" class="px-2 py-1 text-xs font-medium rounded-full">
                    {{ record.shift }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ record.check_in_time || '--:--' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ record.check_out_time || '--:--' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ record.hours_worked || '--' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getStatusBadgeClass(record.status)" class="px-2 py-1 text-xs font-medium rounded-full">
                    {{ formatStatus(record.status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button @click="viewDetails(record)" class="text-indigo-600 hover:text-indigo-900" title="View Details">
                      <EyeIcon class="w-5 h-5" />
                    </button>
                    <button @click="editRecord(record)" class="text-blue-600 hover:text-blue-900" title="Edit">
                      <PencilIcon class="w-5 h-5" />
                    </button>
                    <button @click="viewHistory(record)" class="text-green-600 hover:text-green-900" title="View History">
                      <ClockIcon class="w-5 h-5" />
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { 
  CheckCircleIcon,
  DocumentArrowDownIcon,
  ArrowDownTrayIcon,
  UserGroupIcon,
  ClockIcon,
  XCircleIcon,
  CalendarIcon,
  EyeIcon,
  PencilIcon
} from '@heroicons/vue/24/outline'

export default {
  name: 'AttendanceManagement',
  components: {
    CheckCircleIcon,
    DocumentArrowDownIcon,
    ArrowDownTrayIcon,
    UserGroupIcon,
    ClockIcon,
    XCircleIcon,
    CalendarIcon,
    EyeIcon,
    PencilIcon
  },
  setup() {
    const attendanceRecords = ref([])
    const departments = ref([])
    const showAddModal = ref(false)
    const attendanceForm = ref({})
    const filters = ref({
      search: '',
      department_id: '',
      status: '',
      date_range: '',
      shift: ''
    })

    // Current date info
    const currentDate = new Date().toLocaleDateString('en-TZ', {
      weekday: 'long',
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    })

    // Tanzania-specific attendance statistics
    const stats = ref({
      presentToday: 285,
      lateArrivals: 12,
      absent: 8,
      onLeave: 6
    })

    // Tanzania-specific attendance data
    const loadAttendance = async () => {
      try {
        // Mock Tanzania-specific attendance data for demonstration
        const mockRecords = [
          {
            id: 1,
            employee_name: 'Amina Mwangi',
            employee_number: 'TZ-HR-001',
            department: 'Human Resources',
            shift: 'morning',
            check_in_time: '08:15',
            check_out_time: '17:30',
            hours_worked: '9.25',
            status: 'late',
            date: '2024-03-12'
          },
          {
            id: 2,
            employee_name: 'Joseph Mgaya',
            employee_number: 'TZ-HR-002',
            department: 'Operations',
            shift: 'morning',
            check_in_time: '07:45',
            check_out_time: '17:00',
            hours_worked: '9.25',
            status: 'present',
            date: '2024-03-12'
          },
          {
            id: 3,
            employee_name: 'Grace Kimario',
            employee_number: 'TZ-HR-003',
            department: 'Finance',
            shift: 'morning',
            check_in_time: '08:00',
            check_out_time: null,
            hours_worked: null,
            status: 'present',
            date: '2024-03-12'
          },
          {
            id: 4,
            employee_name: 'Peter Massawe',
            employee_number: 'TZ-HR-004',
            department: 'Sales & Marketing',
            shift: 'afternoon',
            check_in_time: null,
            check_out_time: null,
            hours_worked: null,
            status: 'absent',
            date: '2024-03-12'
          },
          {
            id: 5,
            employee_name: 'Sarah Kiwanga',
            employee_number: 'TZ-HR-005',
            department: 'IT',
            shift: 'night',
            check_in_time: '19:00',
            check_out_time: '03:00',
            hours_worked: '8.00',
            status: 'present',
            date: '2024-03-12'
          }
        ]

        // Apply filters
        let filteredRecords = mockRecords.filter(record => {
          if (filters.value.search && !record.employee_name.toLowerCase().includes(filters.value.search.toLowerCase()) &&
              !record.employee_number.toLowerCase().includes(filters.value.search.toLowerCase())) {
            return false
          }
          if (filters.value.department_id && record.department_id != filters.value.department_id) {
            return false
          }
          if (filters.value.status && record.status !== filters.value.status) {
            return false
          }
          if (filters.value.shift && record.shift !== filters.value.shift) {
            return false
          }
          return true
        })

        attendanceRecords.value = filteredRecords

        // Update statistics
        stats.value = {
          presentToday: mockRecords.filter(r => r.status === 'present').length,
          lateArrivals: mockRecords.filter(r => r.status === 'late').length,
          absent: mockRecords.filter(r => r.status === 'absent').length,
          onLeave: mockRecords.filter(r => r.status === 'on_leave').length
        }

      } catch (error) {
        console.error('Error loading attendance data:', error)
      }
    }

    const loadDepartments = async () => {
      try {
        // Mock Tanzania-specific departments
        departments.value = [
          { id: 1, name: 'Human Resources' },
          { id: 2, name: 'Operations' },
          { id: 3, name: 'Finance' },
          { id: 4, name: 'Sales & Marketing' },
          { id: 5, name: 'IT' },
          { id: 6, name: 'Logistics' }
        ]
      } catch (error) {
        console.error('Error loading departments:', error)
      }
    }

    const searchAttendance = () => {
      loadAttendance()
    }

    const resetFilters = () => {
      filters.value = {
        search: '',
        department_id: '',
        status: '',
        date_range: '',
        shift: ''
      }
      loadAttendance()
    }

    const formatStatus = (status) => {
      return status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())
    }

    const getShiftBadgeClass = (shift) => {
      const classes = {
        morning: 'bg-blue-100 text-blue-800',
        afternoon: 'bg-orange-100 text-orange-800',
        night: 'bg-purple-100 text-purple-800'
      }
      return classes[shift] || 'bg-gray-100 text-gray-800'
    }

    const getStatusBadgeClass = (status) => {
      const classes = {
        present: 'bg-green-100 text-green-800',
        late: 'bg-yellow-100 text-yellow-800',
        absent: 'bg-red-100 text-red-800',
        on_leave: 'bg-blue-100 text-blue-800'
      }
      return classes[status] || 'bg-gray-100 text-gray-800'
    }

    const markAttendance = () => {
      console.log('Opening attendance marking interface...')
    }

    const exportReport = () => {
      console.log('Exporting attendance report...')
    }

    const importAttendance = () => {
      console.log('Importing attendance data...')
    }

    const viewDetails = (record) => {
      console.log('Viewing attendance details:', record)
    }

    const editRecord = (record) => {
      console.log('Editing attendance record:', record)
    }

    const viewHistory = (record) => {
      console.log('Viewing attendance history for:', record)
    }

    onMounted(() => {
      loadAttendance()
      loadDepartments()
    })

    return {
      attendanceRecords,
      departments,
      showAddModal,
      attendanceForm,
      filters,
      stats,
      currentDate,
      loadAttendance,
      loadDepartments,
      searchAttendance,
      resetFilters,
      formatStatus,
      getShiftBadgeClass,
      getStatusBadgeClass,
      markAttendance,
      exportReport,
      importAttendance,
      viewDetails,
      editRecord,
      viewHistory
    }
  }
}
</script>
