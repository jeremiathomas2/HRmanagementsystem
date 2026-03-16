<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center">
            <h1 class="text-xl font-semibold text-gray-900">Compliance Management</h1>
            <span class="ml-3 px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
              {{ complianceScore }}% Compliant
            </span>
          </div>
          <div class="flex items-center space-x-3">
            <button @click="runAudit" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 flex items-center">
              <ShieldCheckIcon class="w-5 h-5 mr-2" />
              Run Audit
            </button>
            <button @click="exportReport" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
              <DocumentArrowDownIcon class="w-5 h-5 mr-2" />
              Export Report
            </button>
            <button @click="scheduleAudit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center">
              <CalendarIcon class="w-5 h-5 mr-2" />
              Schedule Audit
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Compliance Overview -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg">
              <ShieldCheckIcon class="w-6 h-6 text-purple-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Compliance Score</p>
              <p class="text-2xl font-bold text-gray-900">{{ complianceScore }}%</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
              <CheckCircleIcon class="w-6 h-6 text-green-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Compliant Areas</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.compliantAreas }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
              <ExclamationTriangleIcon class="w-6 h-6 text-yellow-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Issues Found</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.issuesFound }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-red-100 rounded-lg">
              <XCircleIcon class="w-6 h-6 text-red-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Critical Issues</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.criticalIssues }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Compliance Areas -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-6">
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Compliance Areas</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="area in complianceAreas" :key="area.id" class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
            <div class="flex items-center justify-between mb-3">
              <h4 class="text-md font-medium text-gray-900">{{ area.name }}</h4>
              <span :class="getComplianceBadgeClass(area.compliance)" class="px-2 py-1 text-xs font-medium rounded-full">
                {{ area.compliance }}
              </span>
            </div>
            <div class="space-y-2">
              <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600">Status:</span>
                <span :class="getStatusColor(area.status)">{{ formatStatus(area.status) }}</span>
              </div>
              <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600">Last Audit:</span>
                <span class="text-gray-900">{{ formatDate(area.lastAudit) }}</span>
              </div>
              <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600">Issues:</span>
                <span class="text-red-600 font-medium">{{ area.issues }}</span>
              </div>
              <div class="mt-3">
                <div class="w-full bg-gray-200 rounded-full h-2">
                  <div :class="getComplianceBar(area.compliance)" class="h-2 rounded-full transition-all duration-300"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Issues -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-6">
      <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Recent Issues</h3>
          <button @click="loadIssues" class="text-sm text-purple-600 hover:text-purple-700">Refresh</button>
        </div>
        <div class="space-y-4">
          <div v-for="issue in recentIssues" :key="issue.id" class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
            <div class="flex items-start justify-between">
              <div class="flex-1">
                <div class="flex items-center mb-2">
                  <span :class="getSeverityBadgeClass(issue.severity)" class="px-2 py-1 text-xs font-medium rounded-full mr-2">
                    {{ issue.severity }}
                  </span>
                  <h4 class="text-md font-medium text-gray-900">{{ issue.title }}</h4>
                </div>
                <p class="text-sm text-gray-600 mb-2">{{ issue.description }}</p>
                <div class="flex items-center space-x-4 text-sm text-gray-500">
                  <span>Area: {{ issue.area }}</span>
                  <span>Reported: {{ formatDate(issue.reported_date) }}</span>
                </div>
              </div>
              <div class="flex items-center space-x-2">
                <button @click="viewIssue(issue)" class="text-indigo-600 hover:text-indigo-900 text-sm">View</button>
                <button @click="resolveIssue(issue)" class="text-green-600 hover:text-green-900 text-sm">Resolve</button>
                <button @click="assignIssue(issue)" class="text-blue-600 hover:text-blue-900 text-sm">Assign</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue'
import { 
  ShieldCheckIcon,
  DocumentArrowDownIcon,
  CalendarIcon,
  CheckCircleIcon,
  ExclamationTriangleIcon,
  XCircleIcon
} from '@heroicons/vue/24/outline'

export default {
  name: 'ComplianceManagement',
  components: {
    ShieldCheckIcon,
    DocumentArrowDownIcon,
    CalendarIcon,
    CheckCircleIcon,
    ExclamationTriangleIcon,
    XCircleIcon
  },
  setup() {
    const complianceAreas = ref([])
    const recentIssues = ref([])
    const showAddModal = ref(false)
    const issueForm = ref({})

    // Tanzania-specific compliance score
    const complianceScore = computed(() => {
      if (complianceAreas.value.length === 0) return 0
      const totalScore = complianceAreas.value.reduce((sum, area) => {
        const scores = { 'compliant': 100, 'partial': 60, 'non_compliant': 20 }
        return sum + (scores[area.compliance] || 0)
      }, 0)
      return Math.round(totalScore / complianceAreas.value.length)
    })

    // Tanzania-specific compliance statistics
    const stats = ref({
      compliantAreas: 8,
      issuesFound: 12,
      criticalIssues: 3,
      pendingAudits: 2
    })

    // Tanzania-specific compliance areas
    const loadComplianceAreas = async () => {
      try {
        // Mock Tanzania-specific compliance data for demonstration
        complianceAreas.value = [
          {
            id: 1,
            name: 'Labor Law Compliance',
            compliance: 'compliant',
            status: 'active',
            lastAudit: '2024-03-01',
            issues: 0
          },
          {
            id: 2,
            name: 'NSSF Contributions',
            compliance: 'compliant',
            status: 'active',
            lastAudit: '2024-03-01',
            issues: 0
          },
          {
            id: 3,
            name: 'PAYE Tax Filing',
            compliance: 'partial',
            status: 'requires_attention',
            lastAudit: '2024-02-15',
            issues: 2
          },
          {
            id: 4,
            name: 'Work Permit Management',
            compliance: 'non_compliant',
            status: 'critical',
            lastAudit: '2024-02-01',
            issues: 5
          },
          {
            id: 5,
            name: 'Workplace Safety',
            compliance: 'partial',
            status: 'active',
            lastAudit: '2024-03-10',
            issues: 3
          },
          {
            id: 6,
            name: 'Employee Records',
            compliance: 'compliant',
            status: 'active',
            lastAudit: '2024-03-01',
            issues: 0
          }
        ]
      } catch (error) {
        console.error('Error loading compliance areas:', error)
      }
    }

    const loadRecentIssues = async () => {
      try {
        // Mock Tanzania-specific compliance issues
        recentIssues.value = [
          {
            id: 1,
            title: 'Work Permit Expiry',
            description: '3 work permits for expatriates expiring in next 30 days',
            area: 'Work Permit Management',
            severity: 'high',
            reported_date: '2024-03-10',
            status: 'open'
          },
          {
            id: 2,
            title: 'NSSF Contribution Delay',
            description: 'Q1 2024 NSSF contributions not submitted on time',
            area: 'NSSF Contributions',
            severity: 'medium',
            reported_date: '2024-03-05',
            status: 'open'
          },
          {
            id: 3,
            title: 'Safety Training Records',
            description: 'Missing safety training certificates for 5 employees',
            area: 'Workplace Safety',
            severity: 'medium',
            reported_date: '2024-03-08',
            status: 'open'
          },
          {
            id: 4,
            title: 'PAYE Filing Deadline',
            description: 'Monthly PAYE filing deadline approaching in 3 days',
            area: 'PAYE Tax Filing',
            severity: 'high',
            reported_date: '2024-03-12',
            status: 'open'
          }
        ]
      } catch (error) {
        console.error('Error loading recent issues:', error)
      }
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

    const getStatusColor = (status) => {
      const statuses = {
        'active': 'text-green-600',
        'requires_attention': 'text-yellow-600',
        'critical': 'text-red-600',
        'resolved': 'text-gray-600'
      }
      return statuses[status] || 'text-gray-600'
    }

    const getComplianceBadgeClass = (compliance) => {
      const classes = {
        compliant: 'bg-green-100 text-green-800',
        partial: 'bg-yellow-100 text-yellow-800',
        non_compliant: 'bg-red-100 text-red-800'
      }
      return classes[compliance] || 'bg-gray-100 text-gray-800'
    }

    const getComplianceBar = (compliance) => {
      const widths = {
        compliant: 'bg-green-500',
        partial: 'bg-yellow-500',
        non_compliant: 'bg-red-500'
      }
      return widths[compliance] || 'bg-gray-500'
    }

    const getSeverityBadgeClass = (severity) => {
      const classes = {
        low: 'bg-blue-100 text-blue-800',
        medium: 'bg-yellow-100 text-yellow-800',
        high: 'bg-orange-100 text-orange-800',
        critical: 'bg-red-100 text-red-800'
      }
      return classes[severity] || 'bg-gray-100 text-gray-800'
    }

    const runAudit = () => {
      console.log('Running compliance audit...')
      // Implement audit logic
    }

    const exportReport = () => {
      console.log('Exporting compliance report...')
      // Implement export functionality
    }

    const scheduleAudit = () => {
      console.log('Scheduling compliance audit...')
      // Implement scheduling logic
    }

    const viewIssue = (issue) => {
      console.log('Viewing issue details:', issue)
    }

    const resolveIssue = (issue) => {
      console.log('Resolving issue:', issue)
      // Implement resolution logic
    }

    const assignIssue = (issue) => {
      console.log('Assigning issue:', issue)
      // Implement assignment logic
    }

    onMounted(() => {
      loadComplianceAreas()
      loadRecentIssues()
    })

    return {
      complianceAreas,
      recentIssues,
      showAddModal,
      issueForm,
      complianceScore,
      stats,
      loadComplianceAreas,
      loadRecentIssues,
      formatDate,
      formatStatus,
      getStatusColor,
      getComplianceBadgeClass,
      getComplianceBar,
      getSeverityBadgeClass,
      runAudit,
      exportReport,
      scheduleAudit,
      viewIssue,
      resolveIssue,
      assignIssue
    }
  }
}
</script>
