<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center">
            <h1 class="text-xl font-semibold text-gray-900">Training Management</h1>
            <span class="ml-3 px-2 py-1 text-xs font-medium rounded-full bg-cyan-100 text-cyan-800">
              {{ activePrograms }} Active Programs
            </span>
          </div>
          <div class="flex items-center space-x-3">
            <button @click="createProgram" class="bg-cyan-600 text-white px-4 py-2 rounded-lg hover:bg-cyan-700 flex items-center">
              <PlusIcon class="w-5 h-5 mr-2" />
              Create Program
            </button>
            <button @click="enrollEmployees" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 flex items-center">
              <UserGroupIcon class="w-5 h-5 mr-2" />
              Enroll Employees
            </button>
            <button @click="exportReport" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
              <DocumentArrowDownIcon class="w-5 h-5 mr-2" />
              Export Report
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Training Statistics -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-cyan-100 rounded-lg">
              <AcademicCapIcon class="w-6 h-6 text-cyan-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Active Programs</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.activePrograms }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
              <UserGroupIcon class="w-6 h-6 text-blue-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Enrolled</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.totalEnrolled }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
              <CheckCircleIcon class="w-6 h-6 text-green-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Completed This Month</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.completedThisMonth }}</p>
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
      </div>
    </div>

    <!-- Advanced Filters -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-6">
      <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-medium text-gray-900">Training Filters</h3>
          <button @click="resetFilters" class="text-sm text-gray-500 hover:text-gray-700">Reset All</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input v-model="filters.search" @input="searchPrograms" type="text" placeholder="Search by program, employee..." 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900 placeholder-gray-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Program Type</label>
            <select v-model="filters.program_type" @change="loadPrograms" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Types</option>
              <option value="technical">Technical Skills</option>
              <option value="soft_skills">Soft Skills</option>
              <option value="compliance">Compliance</option>
              <option value="leadership">Leadership</option>
              <option value="safety">Safety Training</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select v-model="filters.status" @change="loadPrograms" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Status</option>
              <option value="planned">Planned</option>
              <option value="ongoing">Ongoing</option>
              <option value="completed">Completed</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
            <select v-model="filters.department_id" @change="loadPrograms" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Departments</option>
              <option v-for="dept in departments" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Delivery Mode</label>
            <select v-model="filters.delivery_mode" @change="loadPrograms" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Modes</option>
              <option value="classroom">Classroom</option>
              <option value="online">Online</option>
              <option value="blended">Blended</option>
              <option value="workshop">Workshop</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Training Programs Table -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrolled</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delivery</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="program in programs" :key="program.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-full bg-cyan-600 flex items-center justify-center">
                        <AcademicCapIcon class="w-5 h-5 text-white" />
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ program.title }}</div>
                      <div class="text-sm text-gray-500">{{ program.department }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getProgramTypeBadgeClass(program.program_type)" class="px-2 py-1 text-xs font-medium rounded-full">
                    {{ formatProgramType(program.program_type) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ program.instructor }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ program.duration }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ program.enrolled }}/{{ program.capacity }}</div>
                  <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                    <div :class="getEnrollmentBar(program.enrolled, program.capacity)" class="h-2 rounded-full"></div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getDeliveryBadgeClass(program.delivery_mode)" class="px-2 py-1 text-xs font-medium rounded-full">
                    {{ formatDeliveryMode(program.delivery_mode) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getStatusBadgeClass(program.status)" class="px-2 py-1 text-xs font-medium rounded-full">
                    {{ formatStatus(program.status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button @click="viewProgram(program)" class="text-indigo-600 hover:text-indigo-900" title="View Details">
                      <EyeIcon class="w-5 h-5" />
                    </button>
                    <button @click="viewParticipants(program)" class="text-blue-600 hover:text-blue-900" title="View Participants">
                      <UserGroupIcon class="w-5 h-5" />
                    </button>
                    <button @click="editProgram(program)" v-if="program.status === 'planned'" class="text-green-600 hover:text-green-900" title="Edit">
                      <PencilIcon class="w-5 h-5" />
                    </button>
                    <button @click="viewCertificates(program)" v-if="program.status === 'completed'" class="text-purple-600 hover:text-purple-900" title="Certificates">
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
  AcademicCapIcon,
  UserGroupIcon,
  CheckCircleIcon,
  ClockIcon,
  EyeIcon,
  PencilIcon,
  DocumentIcon
} from '@heroicons/vue/24/outline'

export default {
  name: 'TrainingManagement',
  components: {
    PlusIcon,
    DocumentArrowDownIcon,
    AcademicCapIcon,
    UserGroupIcon,
    CheckCircleIcon,
    ClockIcon,
    EyeIcon,
    PencilIcon,
    DocumentIcon
  },
  setup() {
    const programs = ref([])
    const departments = ref([])
    const showAddModal = ref(false)
    const programForm = ref({})
    const filters = ref({
      search: '',
      program_type: '',
      status: '',
      department_id: '',
      delivery_mode: ''
    })

    // Tanzania-specific training statistics
    const stats = ref({
      activePrograms: 8,
      totalEnrolled: 45,
      completedThisMonth: 12,
      inProgress: 28
    })

    // Tanzania-specific training data
    const loadPrograms = async () => {
      try {
        // Mock Tanzania-specific training data for demonstration
        const mockPrograms = [
          {
            id: 1,
            title: 'Tanzania Labor Law Compliance',
            program_type: 'compliance',
            instructor: 'John Mushi',
            duration: '3 days',
            enrolled: 15,
            capacity: 20,
            delivery_mode: 'classroom',
            status: 'ongoing',
            start_date: '2024-03-10',
            end_date: '2024-03-12',
            department: 'Human Resources',
            cost: 500000
          },
          {
            id: 2,
            title: 'Advanced Excel for Finance',
            program_type: 'technical',
            instructor: 'Grace Kimario',
            duration: '2 weeks',
            enrolled: 8,
            capacity: 10,
            delivery_mode: 'online',
            status: 'planned',
            start_date: '2024-03-20',
            end_date: '2024-04-03',
            department: 'Finance',
            cost: 750000
          },
          {
            id: 3,
            title: 'Leadership Excellence Program',
            program_type: 'leadership',
            instructor: 'Peter Nyerere',
            duration: '1 week',
            enrolled: 12,
            capacity: 15,
            delivery_mode: 'workshop',
            status: 'completed',
            start_date: '2024-02-15',
            end_date: '2024-02-22',
            department: 'Operations',
            cost: 1200000
          },
          {
            id: 4,
            title: 'Workplace Safety Training',
            program_type: 'safety',
            instructor: 'Sarah Kiwanga',
            duration: '2 days',
            enrolled: 18,
            capacity: 25,
            delivery_mode: 'blended',
            status: 'ongoing',
            start_date: '2024-03-08',
            end_date: '2024-03-09',
            department: 'Logistics',
            cost: 300000
          },
          {
            id: 5,
            title: 'Communication Skills Workshop',
            program_type: 'soft_skills',
            instructor: 'Amina Mwangi',
            duration: '1 day',
            enrolled: 20,
            capacity: 20,
            delivery_mode: 'classroom',
            status: 'completed',
            start_date: '2024-03-01',
            end_date: '2024-03-01',
            department: 'Sales & Marketing',
            cost: 200000
          }
        ]

        // Apply filters
        let filteredPrograms = mockPrograms.filter(program => {
          if (filters.value.search && !program.title.toLowerCase().includes(filters.value.search.toLowerCase()) &&
              !program.instructor.toLowerCase().includes(filters.value.search.toLowerCase())) {
            return false
          }
          if (filters.value.program_type && program.program_type !== filters.value.program_type) {
            return false
          }
          if (filters.value.status && program.status !== filters.value.status) {
            return false
          }
          if (filters.value.delivery_mode && program.delivery_mode !== filters.value.delivery_mode) {
            return false
          }
          return true
        })

        programs.value = filteredPrograms

        // Update statistics
        stats.value = {
          activePrograms: mockPrograms.filter(p => p.status === 'ongoing').length,
          totalEnrolled: mockPrograms.reduce((sum, p) => sum + p.enrolled, 0),
          completedThisMonth: mockPrograms.filter(p => p.status === 'completed' && new Date(p.end_date) >= new Date(Date.now() - 30 * 24 * 60 * 60 * 1000)).length,
          inProgress: mockPrograms.filter(p => p.status === 'ongoing').reduce((sum, p) => sum + p.enrolled, 0)
        }

      } catch (error) {
        console.error('Error loading training programs:', error)
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

    const searchPrograms = () => {
      loadPrograms()
    }

    const resetFilters = () => {
      filters.value = {
        search: '',
        program_type: '',
        status: '',
        department_id: '',
        delivery_mode: ''
      }
      loadPrograms()
    }

    const formatProgramType = (type) => {
      return type.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())
    }

    const formatDeliveryMode = (mode) => {
      return mode.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())
    }

    const formatStatus = (status) => {
      return status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())
    }

    const getProgramTypeBadgeClass = (type) => {
      const classes = {
        technical: 'bg-blue-100 text-blue-800',
        soft_skills: 'bg-green-100 text-green-800',
        compliance: 'bg-purple-100 text-purple-800',
        leadership: 'bg-orange-100 text-orange-800',
        safety: 'bg-red-100 text-red-800'
      }
      return classes[type] || 'bg-gray-100 text-gray-800'
    }

    const getDeliveryBadgeClass = (mode) => {
      const classes = {
        classroom: 'bg-indigo-100 text-indigo-800',
        online: 'bg-cyan-100 text-cyan-800',
        blended: 'bg-pink-100 text-pink-800',
        workshop: 'bg-yellow-100 text-yellow-800'
      }
      return classes[mode] || 'bg-gray-100 text-gray-800'
    }

    const getStatusBadgeClass = (status) => {
      const classes = {
        planned: 'bg-blue-100 text-blue-800',
        ongoing: 'bg-green-100 text-green-800',
        completed: 'bg-gray-100 text-gray-800',
        cancelled: 'bg-red-100 text-red-800'
      }
      return classes[status] || 'bg-gray-100 text-gray-800'
    }

    const getEnrollmentBar = (enrolled, capacity) => {
      const percentage = (enrolled / capacity) * 100
      if (percentage >= 90) return 'bg-red-500'
      if (percentage >= 75) return 'bg-yellow-500'
      return 'bg-green-500'
    }

    const createProgram = () => {
      console.log('Opening training program creation form...')
    }

    const enrollEmployees = () => {
      console.log('Opening employee enrollment interface...')
    }

    const exportReport = () => {
      console.log('Exporting training report...')
    }

    const viewProgram = (program) => {
      console.log('Viewing training program details:', program)
    }

    const viewParticipants = (program) => {
      console.log('Viewing program participants:', program)
    }

    const editProgram = (program) => {
      console.log('Editing training program:', program)
    }

    const viewCertificates = (program) => {
      console.log('Viewing certificates for:', program)
    }

    onMounted(() => {
      loadPrograms()
      loadDepartments()
    })

    return {
      programs,
      departments,
      showAddModal,
      programForm,
      filters,
      stats,
      loadPrograms,
      loadDepartments,
      searchPrograms,
      resetFilters,
      formatProgramType,
      formatDeliveryMode,
      formatStatus,
      getProgramTypeBadgeClass,
      getDeliveryBadgeClass,
      getStatusBadgeClass,
      getEnrollmentBar,
      createProgram,
      enrollEmployees,
      exportReport,
      viewProgram,
      viewParticipants,
      editProgram,
      viewCertificates
    }
  }
}
</script>
