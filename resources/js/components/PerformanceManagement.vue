<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center">
            <h1 class="text-xl font-semibold text-gray-900">Performance Management</h1>
            <span class="ml-3 px-2 py-1 text-xs font-medium rounded-full bg-amber-100 text-amber-800">
              {{ currentQuarter }} {{ currentYear }}
            </span>
          </div>
          <div class="flex items-center space-x-3">
            <button @click="createReview" class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-700 flex items-center">
              <PlusIcon class="w-5 h-5 mr-2" />
              Create Review
            </button>
            <button @click="exportReport" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
              <DocumentArrowDownIcon class="w-5 h-5 mr-2" />
              Export Report
            </button>
            <button @click="viewAnalytics" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 flex items-center">
              <ChartBarIcon class="w-5 h-5 mr-2" />
              Analytics
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Performance Statistics -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-amber-100 rounded-lg">
              <ChartBarIcon class="w-6 h-6 text-amber-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Average Score</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.averageScore }}%</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
              <StarIcon class="w-6 h-6 text-green-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Top Performers</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.topPerformers }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
              <ExclamationTriangleIcon class="w-6 h-6 text-yellow-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Need Improvement</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.needImprovement }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
              <CalendarIcon class="w-6 h-6 text-blue-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Pending Reviews</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.pendingReviews }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Advanced Filters -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-6">
      <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-medium text-gray-900">Performance Filters</h3>
          <button @click="resetFilters" class="text-sm text-gray-500 hover:text-gray-700">Reset All</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input v-model="filters.search" @input="searchReviews" type="text" placeholder="Search by name, ID..." 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900 placeholder-gray-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
            <select v-model="filters.department_id" @change="loadReviews" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Departments</option>
              <option v-for="dept in departments" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Review Type</label>
            <select v-model="filters.review_type" @change="loadReviews" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Types</option>
              <option value="quarterly">Quarterly</option>
              <option value="annual">Annual</option>
              <option value="probation">Probation</option>
              <option value="project">Project-based</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
            <select v-model="filters.rating" @change="loadReviews" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Ratings</option>
              <option value="5">5 - Excellent</option>
              <option value="4">4 - Good</option>
              <option value="3">3 - Satisfactory</option>
              <option value="2">2 - Needs Improvement</option>
              <option value="1">1 - Poor</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select v-model="filters.status" @change="loadReviews" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Status</option>
              <option value="draft">Draft</option>
              <option value="submitted">Submitted</option>
              <option value="approved">Approved</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Performance Reviews Table -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Review Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reviewer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="review in reviews" :key="review.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center">
                        <span class="text-white font-medium">{{ review.employee_name?.charAt(0) }}</span>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ review.employee_name }}</div>
                      <div class="text-sm text-gray-500">{{ review.employee_number }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getReviewTypeBadgeClass(review.review_type)" class="px-2 py-1 text-xs font-medium rounded-full">
                    {{ formatReviewType(review.review_type) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ review.period }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex">
                      <StarIcon v-for="i in 5" :key="i" :class="i <= review.rating ? 'text-yellow-400' : 'text-gray-300'" class="w-4 h-4" />
                    </div>
                    <span class="ml-2 text-sm text-gray-600">({{ review.rating }}/5)</span>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="text-sm font-medium" :class="getScoreColor(review.score)">
                      {{ review.score }}%
                    </div>
                    <div class="ml-2 w-12 bg-gray-200 rounded-full h-2">
                      <div :class="getScoreBar(review.score)" class="h-2 rounded-full"></div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ review.reviewer }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getStatusBadgeClass(review.status)" class="px-2 py-1 text-xs font-medium rounded-full">
                    {{ formatStatus(review.status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button @click="viewReview(review)" class="text-indigo-600 hover:text-indigo-900" title="View Details">
                      <EyeIcon class="w-5 h-5" />
                    </button>
                    <button @click="editReview(review)" v-if="review.status === 'draft'" class="text-blue-600 hover:text-blue-900" title="Edit">
                      <PencilIcon class="w-5 h-5" />
                    </button>
                    <button @click="approveReview(review)" v-if="review.status === 'submitted'" class="text-green-600 hover:text-green-900" title="Approve">
                      <CheckIcon class="w-5 h-5" />
                    </button>
                    <button @click="viewGoals(review)" class="text-purple-600 hover:text-purple-900" title="View Goals">
                      <FlagIcon class="w-5 h-5" />
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
  ChartBarIcon,
  StarIcon,
  ExclamationTriangleIcon,
  CalendarIcon,
  EyeIcon,
  PencilIcon,
  CheckIcon,
  FlagIcon
} from '@heroicons/vue/24/outline'

export default {
  name: 'PerformanceManagement',
  components: {
    PlusIcon,
    DocumentArrowDownIcon,
    ChartBarIcon,
    StarIcon,
    ExclamationTriangleIcon,
    CalendarIcon,
    EyeIcon,
    PencilIcon,
    CheckIcon,
    FlagIcon
  },
  setup() {
    const reviews = ref([])
    const departments = ref([])
    const showAddModal = ref(false)
    const reviewForm = ref({})
    const filters = ref({
      search: '',
      department_id: '',
      review_type: '',
      rating: '',
      status: ''
    })

    // Current date info
    const currentDate = new Date()
    const currentQuarter = `Q${Math.ceil((currentDate.getMonth() + 1) / 3)}`
    const currentYear = currentDate.getFullYear()

    // Tanzania-specific performance statistics
    const stats = ref({
      averageScore: 78,
      topPerformers: 12,
      needImprovement: 5,
      pendingReviews: 8
    })

    // Tanzania-specific performance data
    const loadReviews = async () => {
      try {
        // Mock Tanzania-specific performance data for demonstration
        const mockReviews = [
          {
            id: 1,
            employee_name: 'Amina Mwangi',
            employee_number: 'TZ-HR-001',
            review_type: 'quarterly',
            period: 'Q1 2024',
            rating: 5,
            score: 92,
            reviewer: 'Joseph Mgaya',
            status: 'approved',
            review_date: '2024-03-10',
            department: 'Human Resources'
          },
          {
            id: 2,
            employee_name: 'Joseph Mgaya',
            employee_number: 'TZ-HR-002',
            review_type: 'quarterly',
            period: 'Q1 2024',
            rating: 4,
            score: 85,
            reviewer: 'Grace Kimario',
            status: 'approved',
            review_date: '2024-03-08',
            department: 'Operations'
          },
          {
            id: 3,
            employee_name: 'Grace Kimario',
            employee_number: 'TZ-HR-003',
            review_type: 'annual',
            period: '2023',
            rating: 4,
            score: 78,
            reviewer: 'Peter Massawe',
            status: 'submitted',
            review_date: '2024-03-05',
            department: 'Finance'
          },
          {
            id: 4,
            employee_name: 'Peter Massawe',
            employee_number: 'TZ-HR-004',
            review_type: 'probation',
            period: 'Probation',
            rating: 3,
            score: 65,
            reviewer: 'Sarah Kiwanga',
            status: 'draft',
            review_date: '2024-03-12',
            department: 'Sales & Marketing'
          },
          {
            id: 5,
            employee_name: 'Sarah Kiwanga',
            employee_number: 'TZ-HR-005',
            review_type: 'project',
            period: 'Website Project',
            rating: 5,
            score: 95,
            reviewer: 'Amina Mwangi',
            status: 'approved',
            review_date: '2024-03-01',
            department: 'IT'
          }
        ]

        // Apply filters
        let filteredReviews = mockReviews.filter(review => {
          if (filters.value.search && !review.employee_name.toLowerCase().includes(filters.value.search.toLowerCase()) &&
              !review.employee_number.toLowerCase().includes(filters.value.search.toLowerCase())) {
            return false
          }
          if (filters.value.department_id && review.department_id != filters.value.department_id) {
            return false
          }
          if (filters.value.review_type && review.review_type !== filters.value.review_type) {
            return false
          }
          if (filters.value.rating && review.rating != filters.value.rating) {
            return false
          }
          if (filters.value.status && review.status !== filters.value.status) {
            return false
          }
          return true
        })

        reviews.value = filteredReviews

        // Update statistics
        stats.value = {
          averageScore: Math.round(mockReviews.reduce((sum, r) => sum + r.score, 0) / mockReviews.length),
          topPerformers: mockReviews.filter(r => r.rating >= 4).length,
          needImprovement: mockReviews.filter(r => r.rating <= 2).length,
          pendingReviews: mockReviews.filter(r => r.status === 'submitted').length
        }

      } catch (error) {
        console.error('Error loading performance reviews:', error)
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

    const searchReviews = () => {
      loadReviews()
    }

    const resetFilters = () => {
      filters.value = {
        search: '',
        department_id: '',
        review_type: '',
        rating: '',
        status: ''
      }
      loadReviews()
    }

    const formatReviewType = (type) => {
      return type.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())
    }

    const formatStatus = (status) => {
      return status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())
    }

    const getReviewTypeBadgeClass = (type) => {
      const classes = {
        quarterly: 'bg-blue-100 text-blue-800',
        annual: 'bg-purple-100 text-purple-800',
        probation: 'bg-yellow-100 text-yellow-800',
        project: 'bg-green-100 text-green-800'
      }
      return classes[type] || 'bg-gray-100 text-gray-800'
    }

    const getStatusBadgeClass = (status) => {
      const classes = {
        draft: 'bg-gray-100 text-gray-800',
        submitted: 'bg-yellow-100 text-yellow-800',
        approved: 'bg-green-100 text-green-800',
        rejected: 'bg-red-100 text-red-800'
      }
      return classes[status] || 'bg-gray-100 text-gray-800'
    }

    const getScoreColor = (score) => {
      if (score >= 90) return 'text-green-600'
      if (score >= 80) return 'text-blue-600'
      if (score >= 70) return 'text-yellow-600'
      if (score >= 60) return 'text-orange-600'
      return 'text-red-600'
    }

    const getScoreBar = (score) => {
      if (score >= 90) return 'bg-green-500'
      if (score >= 80) return 'bg-blue-500'
      if (score >= 70) return 'bg-yellow-500'
      if (score >= 60) return 'bg-orange-500'
      return 'bg-red-500'
    }

    const createReview = () => {
      console.log('Opening performance review form...')
    }

    const exportReport = () => {
      console.log('Exporting performance report...')
    }

    const viewAnalytics = () => {
      console.log('Opening performance analytics...')
    }

    const viewReview = (review) => {
      console.log('Viewing performance review:', review)
    }

    const editReview = (review) => {
      console.log('Editing performance review:', review)
    }

    const approveReview = (review) => {
      console.log('Approving performance review:', review)
    }

    const viewGoals = (review) => {
      console.log('Viewing goals for:', review)
    }

    onMounted(() => {
      loadReviews()
      loadDepartments()
    })

    return {
      reviews,
      departments,
      showAddModal,
      reviewForm,
      filters,
      stats,
      currentQuarter,
      currentYear,
      loadReviews,
      loadDepartments,
      searchReviews,
      resetFilters,
      formatReviewType,
      formatStatus,
      getReviewTypeBadgeClass,
      getStatusBadgeClass,
      getScoreColor,
      getScoreBar,
      createReview,
      exportReport,
      viewAnalytics,
      viewReview,
      editReview,
      approveReview,
      viewGoals
    }
  }
}
</script>
