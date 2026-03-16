<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center">
            <h1 class="text-xl font-semibold text-gray-900">Recruitment Management</h1>
            <span class="ml-3 px-2 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800">
              {{ openPositions }} Open Positions
            </span>
          </div>
          <div class="flex items-center space-x-3">
            <button @click="postJob" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 flex items-center">
              <PlusIcon class="w-5 h-5 mr-2" />
              Post Job
            </button>
            <button @click="importCandidates" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 flex items-center">
              <ArrowDownTrayIcon class="w-5 h-5 mr-2" />
              Import Candidates
            </button>
            <button @click="exportReport" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
              <DocumentArrowDownIcon class="w-5 h-5 mr-2" />
              Export Report
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Recruitment Statistics -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-indigo-100 rounded-lg">
              <BriefcaseIcon class="w-6 h-6 text-indigo-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Open Positions</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.openPositions }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
              <UserGroupIcon class="w-6 h-6 text-blue-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Candidates</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.totalCandidates }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
              <ClockIcon class="w-6 h-6 text-yellow-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">In Progress</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.inProgress }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
              <CheckCircleIcon class="w-6 h-6 text-green-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Hired This Month</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.hiredThisMonth }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Advanced Filters -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-6">
      <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-medium text-gray-900">Recruitment Filters</h3>
          <button @click="resetFilters" class="text-sm text-gray-500 hover:text-gray-700">Reset All</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input v-model="filters.search" @input="searchCandidates" type="text" placeholder="Search by name, position..." 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900 placeholder-gray-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Position</label>
            <select v-model="filters.position_id" @change="loadCandidates" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Positions</option>
              <option v-for="position in positions" :key="position.id" :value="position.id">{{ position.title }}</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select v-model="filters.status" @change="loadCandidates" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Status</option>
              <option value="applied">Applied</option>
              <option value="screening">Screening</option>
              <option value="interviewing">Interviewing</option>
              <option value="offered">Offered</option>
              <option value="rejected">Rejected</option>
              <option value="hired">Hired</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
            <select v-model="filters.department_id" @change="loadCandidates" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Departments</option>
              <option v-for="dept in departments" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Experience Level</label>
            <select v-model="filters.experience_level" @change="loadCandidates" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Levels</option>
              <option value="entry">Entry Level</option>
              <option value="mid">Mid Level</option>
              <option value="senior">Senior Level</option>
              <option value="executive">Executive</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Candidates Table -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidate</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Position</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Experience</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="candidate in candidates" :key="candidate.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center">
                        <span class="text-white font-medium">{{ candidate.first_name?.charAt(0) }}{{ candidate.last_name?.charAt(0) }}</span>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ candidate.full_name }}</div>
                      <div class="text-sm text-gray-500">{{ candidate.email }}</div>
                      <div class="text-sm text-gray-500">{{ candidate.phone }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ candidate.position?.title || 'N/A' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ candidate.department || 'N/A' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getExperienceBadgeClass(candidate.experience_level)" class="px-2 py-1 text-xs font-medium rounded-full">
                    {{ formatExperience(candidate.experience_level) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ formatDate(candidate.applied_date) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getStatusBadgeClass(candidate.status)" class="px-2 py-1 text-xs font-medium rounded-full">
                    {{ formatStatus(candidate.status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button @click="viewProfile(candidate)" class="text-indigo-600 hover:text-indigo-900" title="View Profile">
                      <EyeIcon class="w-5 h-5" />
                    </button>
                    <button @click="scheduleInterview(candidate)" v-if="candidate.status === 'screening'" class="text-blue-600 hover:text-blue-900" title="Schedule Interview">
                      <CalendarIcon class="w-5 h-5" />
                    </button>
                    <button @click="makeOffer(candidate)" v-if="candidate.status === 'interviewing'" class="text-green-600 hover:text-green-900" title="Make Offer">
                      <CheckIcon class="w-5 h-5" />
                    </button>
                    <button @click="rejectCandidate(candidate)" v-if="candidate.status !== 'hired'" class="text-red-600 hover:text-red-900" title="Reject">
                      <XMarkIcon class="w-5 h-5" />
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
  ArrowDownTrayIcon,
  DocumentArrowDownIcon,
  BriefcaseIcon,
  UserGroupIcon,
  ClockIcon,
  CheckCircleIcon,
  EyeIcon,
  CalendarIcon,
  CheckIcon,
  XMarkIcon
} from '@heroicons/vue/24/outline'

export default {
  name: 'RecruitmentManagement',
  components: {
    PlusIcon,
    ArrowDownTrayIcon,
    DocumentArrowDownIcon,
    BriefcaseIcon,
    UserGroupIcon,
    ClockIcon,
    CheckCircleIcon,
    EyeIcon,
    CalendarIcon,
    CheckIcon,
    XMarkIcon
  },
  setup() {
    const candidates = ref([])
    const positions = ref([])
    const departments = ref([])
    const showAddModal = ref(false)
    const candidateForm = ref({})
    const filters = ref({
      search: '',
      position_id: '',
      status: '',
      department_id: '',
      experience_level: ''
    })

    // Tanzania-specific recruitment statistics
    const stats = ref({
      openPositions: 12,
      totalCandidates: 48,
      inProgress: 15,
      hiredThisMonth: 8
    })

    // Tanzania-specific recruitment data
    const loadCandidates = async () => {
      try {
        // Mock Tanzania-specific recruitment data for demonstration
        const mockCandidates = [
          {
            id: 1,
            first_name: 'John',
            last_name: 'Moshi',
            full_name: 'John Moshi',
            email: 'john.moshi@email.com',
            phone: '+255 754 123 456',
            position: { id: 1, title: 'Software Engineer' },
            department: 'IT',
            experience_level: 'mid',
            status: 'interviewing',
            applied_date: '2024-03-10',
            location: 'Dar es Salaam'
          },
          {
            id: 2,
            first_name: 'Grace',
            last_name: 'Mwanga',
            full_name: 'Grace Mwanga',
            email: 'grace.mwanga@email.com',
            phone: '+255 754 234 567',
            position: { id: 2, title: 'Marketing Manager' },
            department: 'Sales & Marketing',
            experience_level: 'senior',
            status: 'screening',
            applied_date: '2024-03-08',
            location: 'Arusha'
          },
          {
            id: 3,
            first_name: 'David',
            last_name: 'Kikwete',
            full_name: 'David Kikwete',
            email: 'david.kikwete@email.com',
            phone: '+255 754 345 678',
            position: { id: 3, title: 'Finance Officer' },
            department: 'Finance',
            experience_level: 'entry',
            status: 'offered',
            applied_date: '2024-03-05',
            location: 'Mwanza'
          },
          {
            id: 4,
            first_name: 'Sarah',
            last_name: 'Mwalimu',
            full_name: 'Sarah Mwalimu',
            email: 'sarah.mwalimu@email.com',
            phone: '+255 754 456 789',
            position: { id: 4, title: 'HR Assistant' },
            department: 'Human Resources',
            experience_level: 'entry',
            status: 'applied',
            applied_date: '2024-03-12',
            location: 'Dodoma'
          },
          {
            id: 5,
            first_name: 'Peter',
            last_name: 'Nyerere',
            full_name: 'Peter Nyerere',
            email: 'peter.nyerere@email.com',
            phone: '+255 754 567 890',
            position: { id: 5, title: 'Operations Manager' },
            department: 'Operations',
            experience_level: 'executive',
            status: 'hired',
            applied_date: '2024-02-28',
            location: 'Dar es Salaam'
          }
        ]

        // Apply filters
        let filteredCandidates = mockCandidates.filter(candidate => {
          if (filters.value.search && !candidate.full_name.toLowerCase().includes(filters.value.search.toLowerCase()) &&
              !candidate.email.toLowerCase().includes(filters.value.search.toLowerCase())) {
            return false
          }
          if (filters.value.position_id && candidate.position?.id != filters.value.position_id) {
            return false
          }
          if (filters.value.status && candidate.status !== filters.value.status) {
            return false
          }
          if (filters.value.experience_level && candidate.experience_level !== filters.value.experience_level) {
            return false
          }
          return true
        })

        candidates.value = filteredCandidates

        // Update statistics
        stats.value = {
          openPositions: 12,
          totalCandidates: mockCandidates.length,
          inProgress: mockCandidates.filter(c => ['screening', 'interviewing'].includes(c.status)).length,
          hiredThisMonth: mockCandidates.filter(c => c.status === 'hired' && new Date(c.applied_date) >= new Date(Date.now() - 30 * 24 * 60 * 60 * 1000)).length
        }

      } catch (error) {
        console.error('Error loading candidates:', error)
      }
    }

    const loadPositions = async () => {
      try {
        // Mock Tanzania-specific positions
        positions.value = [
          { id: 1, title: 'Software Engineer' },
          { id: 2, title: 'Marketing Manager' },
          { id: 3, title: 'Finance Officer' },
          { id: 4, title: 'HR Assistant' },
          { id: 5, title: 'Operations Manager' },
          { id: 6, title: 'Sales Executive' }
        ]
      } catch (error) {
        console.error('Error loading positions:', error)
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

    const searchCandidates = () => {
      loadCandidates()
    }

    const resetFilters = () => {
      filters.value = {
        search: '',
        position_id: '',
        status: '',
        department_id: '',
        experience_level: ''
      }
      loadCandidates()
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

    const formatExperience = (level) => {
      return level.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())
    }

    const getExperienceBadgeClass = (level) => {
      const classes = {
        entry: 'bg-green-100 text-green-800',
        mid: 'bg-blue-100 text-blue-800',
        senior: 'bg-purple-100 text-purple-800',
        executive: 'bg-indigo-100 text-indigo-800'
      }
      return classes[level] || 'bg-gray-100 text-gray-800'
    }

    const getStatusBadgeClass = (status) => {
      const classes = {
        applied: 'bg-blue-100 text-blue-800',
        screening: 'bg-yellow-100 text-yellow-800',
        interviewing: 'bg-orange-100 text-orange-800',
        offered: 'bg-green-100 text-green-800',
        rejected: 'bg-red-100 text-red-800',
        hired: 'bg-green-600 text-white'
      }
      return classes[status] || 'bg-gray-100 text-gray-800'
    }

    const postJob = () => {
      console.log('Opening job posting form...')
    }

    const importCandidates = () => {
      console.log('Importing candidates...')
    }

    const exportReport = () => {
      console.log('Exporting recruitment report...')
    }

    const viewProfile = (candidate) => {
      console.log('Viewing candidate profile:', candidate)
    }

    const scheduleInterview = (candidate) => {
      console.log('Scheduling interview for:', candidate)
    }

    const makeOffer = (candidate) => {
      console.log('Making offer to:', candidate)
    }

    const rejectCandidate = (candidate) => {
      console.log('Rejecting candidate:', candidate)
    }

    onMounted(() => {
      loadCandidates()
      loadPositions()
      loadDepartments()
    })

    return {
      candidates,
      positions,
      departments,
      showAddModal,
      candidateForm,
      filters,
      stats,
      loadCandidates,
      loadPositions,
      loadDepartments,
      searchCandidates,
      resetFilters,
      formatDate,
      formatStatus,
      formatExperience,
      getExperienceBadgeClass,
      getStatusBadgeClass,
      postJob,
      importCandidates,
      exportReport,
      viewProfile,
      scheduleInterview,
      makeOffer,
      rejectCandidate
    }
  }
}
</script>
