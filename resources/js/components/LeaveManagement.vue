<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center">
            <h1 class="text-xl font-semibold text-gray-900">Leave Management</h1>
            <span class="ml-3 px-2 py-1 text-xs font-medium rounded-full bg-teal-100 text-teal-800">
              {{ currentMonth }}
            </span>
          </div>
          <div class="flex items-center space-x-3">
            <button @click="requestLeave" class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 flex items-center">
              <PlusIcon class="w-5 h-5 mr-2" />
              Request Leave
            </button>
            <button @click="exportReport" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
              <DocumentArrowDownIcon class="w-5 h-5 mr-2" />
              Export Report
            </button>
            <button @click="viewCalendar" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 flex items-center">
              <CalendarIcon class="w-5 h-5 mr-2" />
              Calendar View
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Leave Statistics -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-teal-100 rounded-lg">
              <CalendarIcon class="w-6 h-6 text-teal-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Pending Requests</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.pendingRequests }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
              <CheckCircleIcon class="w-6 h-6 text-green-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Approved Today</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.approvedToday }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
              <ClockIcon class="w-6 h-6 text-yellow-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">On Leave Today</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.onLeaveToday }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-red-100 rounded-lg">
              <XCircleIcon class="w-6 h-6 text-red-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Rejected This Week</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.rejectedThisWeek }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Advanced Filters -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-6">
      <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-medium text-gray-900">Leave Filters</h3>
          <button @click="resetFilters" class="text-sm text-gray-500 hover:text-gray-700">Reset All</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input v-model="filters.search" @input="searchRequests" type="text" placeholder="Search by name, ID..." 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900 placeholder-gray-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Leave Type</label>
            <select v-model="filters.leave_type" @change="loadRequests" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Types</option>
              <option value="annual">Annual Leave</option>
              <option value="sick">Sick Leave</option>
              <option value="maternity">Maternity Leave</option>
              <option value="paternity">Paternity Leave</option>
              <option value="compassionate">Compassionate Leave</option>
              <option value="study">Study Leave</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select v-model="filters.status" @change="loadRequests" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Status</option>
              <option value="pending">Pending</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
            <select v-model="filters.department_id" @change="loadRequests" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Departments</option>
              <option v-for="dept in departments" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
            <select v-model="filters.date_range" @change="loadRequests" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Time</option>
              <option value="today">Today</option>
              <option value="week">This Week</option>
              <option value="month">This Month</option>
              <option value="quarter">This Quarter</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Leave Requests Table -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Leave Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reason</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="request in leaveRequests" :key="request.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center">
                        <span class="text-white font-medium">{{ request.employee_name?.charAt(0) }}</span>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ request.employee_name }}</div>
                      <div class="text-sm text-gray-500">{{ request.employee_number }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getLeaveTypeBadgeClass(request.leave_type)" class="px-2 py-1 text-xs font-medium rounded-full">
                    {{ formatLeaveType(request.leave_type) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ formatDate(request.start_date) }} - {{ formatDate(request.end_date) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ request.days_count }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-600 max-w-xs truncate">{{ request.reason }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getStatusBadgeClass(request.status)" class="px-2 py-1 text-xs font-medium rounded-full">
                    {{ formatStatus(request.status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button @click="viewDetails(request)" class="text-indigo-600 hover:text-indigo-900" title="View Details">
                      <EyeIcon class="w-5 h-5" />
                    </button>
                    <button @click="approveRequest(request)" v-if="request.status === 'pending'" class="text-green-600 hover:text-green-900" title="Approve">
                      <CheckIcon class="w-5 h-5" />
                    </button>
                    <button @click="rejectRequest(request)" v-if="request.status === 'pending'" class="text-red-600 hover:text-red-900" title="Reject">
                      <XMarkIcon class="w-5 h-5" />
                    </button>
                    <button @click="viewHistory(request)" class="text-purple-600 hover:text-purple-900" title="View History">
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
  PlusIcon,
  DocumentArrowDownIcon,
  CalendarIcon,
  CheckCircleIcon,
  ClockIcon,
  XCircleIcon,
  EyeIcon,
  CheckIcon,
  XMarkIcon
} from '@heroicons/vue/24/outline'

export default {
  name: 'LeaveManagement',
  components: {
    PlusIcon,
    DocumentArrowDownIcon,
    CalendarIcon,
    CheckCircleIcon,
    ClockIcon,
    XCircleIcon,
    EyeIcon,
    CheckIcon,
    XMarkIcon
  },
  setup() {
    const leaveRequests = ref([])
    const departments = ref([])
    const showAddModal = ref(false)
    const leaveForm = ref({})
    const filters = ref({
      search: '',
      leave_type: '',
      status: '',
      department_id: '',
      date_range: ''
    })

    // Current date info
    const currentMonth = new Date().toLocaleString('default', { month: 'long', year: 'numeric' })

    // Tanzania-specific leave statistics
    const stats = ref({
      pendingRequests: 8,
      approvedToday: 5,
      onLeaveToday: 12,
      rejectedThisWeek: 3
    })

    // Tanzania-specific leave data
    const loadRequests = async () => {
      try {
        // Mock Tanzania-specific leave data for demonstration
        const mockRequests = [
          {
            id: 1,
            employee_name: 'Grace Kimario',
            employee_number: 'TZ-HR-003',
            leave_type: 'annual',
            start_date: '2024-03-15',
            end_date: '2024-03-19',
            days_count: 5,
            reason: 'Family vacation to Zanzibar',
            status: 'approved',
            requested_date: '2024-03-01',
            department: 'Finance'
          },
          {
            id: 2,
            employee_name: 'Peter Massawe',
            employee_number: 'TZ-HR-004',
            leave_type: 'sick',
            start_date: '2024-03-12',
            end_date: '2024-03-13',
            days_count: 2,
            reason: 'Medical appointment and recovery',
            status: 'pending',
            requested_date: '2024-03-10',
            department: 'Sales & Marketing'
          },
          {
            id: 3,
            employee_name: 'Sarah Kiwanga',
            employee_number: 'TZ-HR-005',
            leave_type: 'maternity',
            start_date: '2024-04-01',
            end_date: '2024-06-30',
            days_count: 90,
            reason: 'Maternity leave as per Tanzania labor law',
            status: 'approved',
            requested_date: '2024-02-15',
            department: 'IT'
          },
          {
            id: 4,
            employee_name: 'Joseph Mgaya',
            employee_number: 'TZ-HR-002',
            leave_type: 'compassionate',
            start_date: '2024-03-08',
            end_date: '2024-03-09',
            days_count: 2,
            reason: 'Family emergency - bereavement',
            status: 'approved',
            requested_date: '2024-03-07',
            department: 'Operations'
          },
          {
            id: 5,
            employee_name: 'Amina Mwangi',
            employee_number: 'TZ-HR-001',
            leave_type: 'study',
            start_date: '2024-05-01',
            end_date: '2024-05-15',
            days_count: 15,
            reason: 'Professional development course',
            status: 'pending',
            requested_date: '2024-03-10',
            department: 'Human Resources'
          }
        ]

        // Apply filters
        let filteredRequests = mockRequests.filter(request => {
          if (filters.value.search && !request.employee_name.toLowerCase().includes(filters.value.search.toLowerCase()) &&
              !request.employee_number.toLowerCase().includes(filters.value.search.toLowerCase())) {
            return false
          }
          if (filters.value.leave_type && request.leave_type !== filters.value.leave_type) {
            return false
          }
          if (filters.value.status && request.status !== filters.value.status) {
            return false
          }
          if (filters.value.department_id && request.department_id != filters.value.department_id) {
            return false
          }
          return true
        })

        leaveRequests.value = filteredRequests

        // Update statistics
        stats.value = {
          pendingRequests: mockRequests.filter(r => r.status === 'pending').length,
          approvedToday: mockRequests.filter(r => r.status === 'approved' && new Date(r.requested_date).toDateString() === new Date().toDateString()).length,
          onLeaveToday: mockRequests.filter(r => r.status === 'approved' && new Date(r.start_date) <= new Date() && new Date(r.end_date) >= new Date()).length,
          rejectedThisWeek: mockRequests.filter(r => r.status === 'rejected' && new Date(r.requested_date) > new Date(Date.now() - 7 * 24 * 60 * 60 * 1000)).length
        }

      } catch (error) {
        console.error('Error loading leave requests:', error)
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

    const searchRequests = () => {
      loadRequests()
    }

    const resetFilters = () => {
      filters.value = {
        search: '',
        leave_type: '',
        status: '',
        department_id: '',
        date_range: ''
      }
      loadRequests()
    }

    const formatDate = (dateString) => {
      return new Date(dateString).toLocaleDateString('en-TZ', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      })
    }

    const formatStatus = (status) => {
      return status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())
    }

    const formatLeaveType = (type) => {
      return type.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())
    }

    const getLeaveTypeBadgeClass = (type) => {
      const classes = {
        annual: 'bg-blue-100 text-blue-800',
        sick: 'bg-green-100 text-green-800',
        maternity: 'bg-pink-100 text-pink-800',
        paternity: 'bg-purple-100 text-purple-800',
        compassionate: 'bg-yellow-100 text-yellow-800',
        study: 'bg-indigo-100 text-indigo-800'
      }
      return classes[type] || 'bg-gray-100 text-gray-800'
    }

    const getStatusBadgeClass = (status) => {
      const classes = {
        pending: 'bg-yellow-100 text-yellow-800',
        approved: 'bg-green-100 text-green-800',
        rejected: 'bg-red-100 text-red-800',
        cancelled: 'bg-gray-100 text-gray-800'
      }
      return classes[status] || 'bg-gray-100 text-gray-800'
    }

    const requestLeave = () => {
      console.log('Opening leave request form...')
    }

    const exportReport = () => {
      console.log('Exporting leave report...')
    }

    const viewCalendar = () => {
      console.log('Opening calendar view...')
    }

    const viewDetails = (request) => {
      console.log('Viewing leave details:', request)
    }

    const approveRequest = (request) => {
      console.log('Approving leave request:', request)
    }

    const rejectRequest = (request) => {
      console.log('Rejecting leave request:', request)
    }

    const viewHistory = (request) => {
      console.log('Viewing leave history for:', request)
    }

    onMounted(() => {
      loadRequests()
      loadDepartments()
    })

    return {
      leaveRequests,
      departments,
      showAddModal,
      leaveForm,
      filters,
      stats,
      currentMonth,
      loadRequests,
      loadDepartments,
      searchRequests,
      resetFilters,
      formatDate,
      formatStatus,
      formatLeaveType,
      getLeaveTypeBadgeClass,
      getStatusBadgeClass,
      requestLeave,
      exportReport,
      viewCalendar,
      viewDetails,
      approveRequest,
      rejectRequest,
      viewHistory
    }
  }
}
</script>
