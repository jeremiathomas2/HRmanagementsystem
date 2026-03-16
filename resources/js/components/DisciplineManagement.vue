<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center">
            <h1 class="text-xl font-semibold text-gray-900">Discipline Management</h1>
            <span class="ml-3 px-2 py-1 text-xs font-medium rounded-full bg-orange-100 text-orange-800">
              {{ cases.length }} Cases
            </span>
          </div>
          <div class="flex items-center space-x-3">
            <button @click="showAddModal = true" class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 flex items-center">
              <PlusIcon class="w-5 h-5 mr-2" />
              New Case
            </button>
            <button @click="exportCases" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
              <DocumentArrowDownIcon class="w-5 h-5 mr-2" />
              Export
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Statistics Cards -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-orange-100 rounded-lg">
              <ExclamationTriangleIcon class="w-6 h-6 text-orange-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Cases</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.totalCases }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-red-100 rounded-lg">
              <FireIcon class="w-6 h-6 text-red-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Critical Cases</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.criticalCases }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
              <ClockIcon class="w-6 h-6 text-yellow-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Pending Review</p>
              <p class="text-text-2xl font-bold text-gray-900">{{ stats.pendingReview }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
              <CheckCircleIcon class="w-6 h-6 text-green-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Resolved</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.resolved }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Advanced Filters -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-6">
      <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-medium text-gray-900">Case Filters</h3>
          <button @click="resetFilters" class="text-sm text-gray-500 hover:text-gray-700">Reset All</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input v-model="filters.search" @input="searchCases" type="text" placeholder="Search by name, case ID..." 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900 placeholder-gray-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Severity</label>
            <select v-model="filters.severity" @change="loadCases" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Severities</option>
              <option value="minor">Minor</option>
              <option value="moderate">Moderate</option>
              <option value="major">Major</option>
              <option value="critical">Critical</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select v-model="filters.status" @change="loadCases" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Status</option>
              <option value="open">Open</option>
              <option value="under_review">Under Review</option>
              <option value="closed">Closed</option>
              <option value="resolved">Resolved</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
            <select v-model="filters.type" @change="loadCases" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Types</option>
              <option value="misconduct">Misconduct</option>
              <option value="performance">Performance</option>
              <option value="absenteeism">Absenteeism</option>
              <option value="policy_violation">Policy Violation</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Date Range</label>
            <select v-model="filters.date_range" @change="loadCases" 
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

    <!-- Cases Table -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Case ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Severity</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Reported</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Risk Score</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="caseItem in cases" :key="caseItem.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ caseItem.case_id }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center">
                        <span class="text-white font-medium">{{ caseItem.employee_name?.charAt(0) }}</span>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ caseItem.employee_name }}</div>
                      <div class="text-sm text-gray-500">{{ caseItem.employee_number }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getTypeBadgeClass(caseItem.type)" class="px-2 py-1 text-xs font-medium rounded-full">
                    {{ formatType(caseItem.type) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getSeverityBadgeClass(caseItem.severity)" class="px-2 py-1 text-xs font-medium rounded-full">
                    {{ caseItem.severity }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ formatDate(caseItem.date_reported) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getStatusBadgeClass(caseItem.status)" class="px-2 py-1 text-xs font-medium rounded-full">
                    {{ formatStatus(caseItem.status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="text-sm font-medium" :class="getRiskScoreColor(caseItem.risk_score)">
                      {{ caseItem.risk_score }}
                    </div>
                    <div class="ml-2 w-12 bg-gray-200 rounded-full h-2">
                      <div :class="getRiskScoreBar(caseItem.risk_score)" class="h-2 rounded-full"></div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button @click="viewCase(caseItem)" class="text-indigo-600 hover:text-indigo-900" title="View Details">
                      <EyeIcon class="w-5 h-5" />
                    </button>
                    <button @click="editCase(caseItem)" class="text-blue-600 hover:text-blue-900" title="Edit">
                      <PencilIcon class="w-5 h-5" />
                    </button>
                    <button @click="viewDocuments(caseItem)" class="text-green-600 hover:text-green-900" title="Documents">
                      <DocumentIcon class="w-5 h-5" />
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
  EyeIcon, 
  PencilIcon,
  ExclamationTriangleIcon,
  FireIcon,
  ClockIcon,
  CheckCircleIcon,
  DocumentIcon
} from '@heroicons/vue/24/outline'

export default {
  name: 'DisciplineManagement',
  components: {
    PlusIcon,
    DocumentArrowDownIcon,
    EyeIcon,
    PencilIcon,
    ExclamationTriangleIcon,
    FireIcon,
    ClockIcon,
    CheckCircleIcon,
    DocumentIcon
  },
  setup() {
    const cases = ref([])
    const showAddModal = ref(false)
    const showEditModal = ref(false)
    const caseForm = ref({})
    const filters = ref({
      search: '',
      severity: '',
      status: '',
      type: '',
      date_range: ''
    })

    // Tanzania-specific discipline statistics
    const stats = ref({
      totalCases: 12,
      criticalCases: 2,
      pendingReview: 4,
      resolved: 6
    })

    // Tanzania-specific discipline data
    const loadCases = async () => {
      try {
        // Mock Tanzania-specific discipline data for demonstration
        const mockCases = [
          {
            id: 1,
            case_id: 'DIS-2024-001',
            employee_name: 'Peter Massawe',
            employee_number: 'TZ-HR-004',
            type: 'misconduct',
            severity: 'critical',
            date_reported: '2024-03-10',
            status: 'open',
            risk_score: 95,
            description: 'Repeated unauthorized absence without proper notification'
          },
          {
            id: 2,
            case_id: 'DIS-2024-002',
            employee_name: 'Joseph Mgaya',
            employee_number: 'TZ-HR-002',
            type: 'policy_violation',
            severity: 'major',
            date_reported: '2024-03-08',
            status: 'under_review',
            risk_score: 75,
            description: 'Violation of company safety protocols'
          },
          {
            id: 3,
            id: 3,
            case_id: 'DIS-2024-003',
            employee_name: 'Grace Kimario',
            employee_number: 'TZ-HR-003',
            type: 'performance',
            severity: 'moderate',
            date_reported: '2024-03-05',
            status: 'closed',
            risk_score: 45,
            description: 'Consistent underperformance in key duties'
          },
          {
            id: 4,
            case_id: 'DIS-2024-004',
            employee_name: 'Amina Mwangi',
            employee_number: 'TZ-HR-001',
            type: 'absenteeism',
            severity: 'minor',
            date_reported: '2024-03-03',
            status: 'resolved',
            risk_score: 25,
            description: 'Occasional tardiness with valid reasons'
          },
          {
            id: 5,
            case_id: 'DIS-2024-005',
            employee_name: 'Sarah Kiwanga',
            employee_number: 'TZ-HR-005',
            type: 'misconduct',
            severity: 'moderate',
            date_reported: '2024-03-01',
            status: 'open',
            risk_score: 60,
            description: 'Improper use of company equipment'
          }
        ]

        // Apply filters
        let filteredCases = mockCases.filter(caseItem => {
          if (filters.value.search && !caseItem.employee_name.toLowerCase().includes(filters.value.search.toLowerCase()) &&
              !caseItem.case_id.toLowerCase().includes(filters.value.search.toLowerCase())) {
            return false
          }
          if (filters.value.severity && caseItem.severity !== filters.value.severity) {
            return false
          }
          if (filters.value.status && caseItem.status !== filters.value.status) {
            return false
          }
          if (filters.value.type && caseItem.type !== filters.value.type) {
            return false
          }
          return true
        })

        cases.value = filteredCases

        // Update statistics
        stats.value = {
          totalCases: mockCases.length,
          criticalCases: mockCases.filter(c => c.severity === 'critical').length,
          pendingReview: mockCases.filter(c => c.status === 'under_review').length,
          resolved: mockCases.filter(c => c.status === 'resolved').length
        }

      } catch (error) {
        console.error('Error loading discipline cases:', error)
      }
    }

    const searchCases = () => {
      loadCases()
    }

    const resetFilters = () => {
      filters.value = {
        search: '',
        severity: '',
        status: '',
        type: '',
        date_range: ''
      }
      loadCases()
    }

    const formatDate = (dateString) => {
      return new Date(dateString).toLocaleDateString('en-TZ', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      })
    }

    const formatType = (type) => {
      return type.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())
    }

    const formatStatus = (status) => {
      return status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())
    }

    const getTypeBadgeClass = (type) => {
      const classes = {
        misconduct: 'bg-red-100 text-red-800',
        performance: 'bg-purple-100 text-purple-800',
        absenteeism: 'bg-yellow-100 text-yellow-800',
        policy_violation: 'bg-orange-100 text-orange-800'
      }
      return classes[type] || 'bg-gray-100 text-gray-800'
    }

    const getSeverityBadgeClass = (severity) => {
      const classes = {
        minor: 'bg-green-100 text-green-800',
        moderate: 'bg-yellow-100 text-yellow-800',
        major: 'bg-orange-100 text-orange-800',
        critical: 'bg-red-100 text-red-800'
      }
      return classes[severity] || 'bg-gray-100 text-gray-800'
    }

    const getStatusBadgeClass = (status) => {
      const classes = {
        open: 'bg-red-100 text-red-800',
        under_review: 'bg-yellow-100 text-yellow-800',
        closed: 'bg-gray-100 text-gray-800',
        resolved: 'bg-green-100 text-green-800'
      }
      return classes[status] || 'bg-gray-100 text-gray-800'
    }

    const getRiskScoreColor = (score) => {
      if (score >= 80) return 'text-red-600'
      if (score >= 60) return 'text-orange-600'
      if (score >= 40) return 'text-yellow-600'
      return 'text-green-600'
    }

    const getRiskScoreBar = (score) => {
      if (score >= 80) return 'bg-red-500'
      if (score >= 60) return 'bg-orange-500'
      if (score >= 40) return 'bg-yellow-500'
      return 'bg-green-500'
    }

    const viewCase = (caseItem) => {
      console.log('Viewing case details:', caseItem)
    }

    const editCase = (caseItem) => {
      console.log('Editing case:', caseItem)
    }

    const viewDocuments = (caseItem) => {
      console.log('Viewing documents for:', caseItem)
    }

    const exportCases = () => {
      console.log('Exporting discipline cases...')
    }

    onMounted(() => {
      loadCases()
    })

    return {
      cases,
      showAddModal,
      showEditModal,
      caseForm,
      filters,
      stats,
      loadCases,
      searchCases,
      resetFilters,
      formatDate,
      formatType,
      formatStatus,
      getTypeBadgeClass,
      getSeverityBadgeClass,
      getStatusBadgeClass,
      getRiskScoreColor,
      getRiskScoreBar,
      viewCase,
      editCase,
      viewDocuments,
      exportCases
    }
  }
}
</script>
