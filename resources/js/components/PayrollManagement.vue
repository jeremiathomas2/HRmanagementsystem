<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center">
            <h1 class="text-xl font-semibold text-gray-900">Payroll Management</h1>
            <span class="ml-3 px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
              {{ currentMonth }} {{ currentYear }}
            </span>
          </div>
          <div class="flex items-center space-x-3">
            <button @click="processPayroll" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center">
              <PlayIcon class="w-5 h-5 mr-2" />
              Process Payroll
            </button>
            <button @click="exportPayroll" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
              <DocumentArrowDownIcon class="w-5 h-5 mr-2" />
              Export
            </button>
            <button @click="showAddModal = true" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 flex items-center">
              <PlusIcon class="w-5 h-5 mr-2" />
              Add Employee
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Payroll Statistics -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-green-100 rounded-lg">
              <CurrencyDollarIcon class="w-6 h-6 text-green-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Payroll</p>
              <p class="text-2xl font-bold text-gray-900">TZS {{ formatCurrency(stats.totalPayroll) }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-blue-100 rounded-lg">
              <UserGroupIcon class="w-6 h-6 text-blue-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Active Employees</p>
              <p class="text-2xl font-bold text-gray-900">{{ stats.activeEmployees }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-yellow-100 rounded-lg">
              <ReceiptPercentIcon class="w-6 h-6 text-yellow-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Total Deductions</p>
              <p class="text-2xl font-bold text-gray-900">TZS {{ formatCurrency(stats.totalDeductions) }}</p>
            </div>
          </div>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
          <div class="flex items-center">
            <div class="p-2 bg-purple-100 rounded-lg">
              <CalendarIcon class="w-6 h-6 text-purple-600" />
            </div>
            <div class="ml-4">
              <p class="text-sm font-medium text-gray-600">Net Payroll</p>
              <p class="text-2xl font-bold text-gray-900">TZS {{ formatCurrency(stats.netPayroll) }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Advanced Filters -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-6">
      <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-sm font-medium text-gray-900">Payroll Filters</h3>
          <button @click="resetFilters" class="text-sm text-gray-500 hover:text-gray-700">Reset All</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <input v-model="filters.search" @input="searchEmployees" type="text" placeholder="Search by name, ID..." 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900 placeholder-gray-500">
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
            <select v-model="filters.department_id" @change="loadEmployees" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Departments</option>
              <option v-for="dept in departments" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Pay Period</label>
            <select v-model="filters.pay_period" @change="loadEmployees" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Periods</option>
              <option value="monthly">Monthly</option>
              <option value="biweekly">Bi-weekly</option>
              <option value="weekly">Weekly</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select v-model="filters.status" @change="loadEmployees" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Status</option>
              <option value="processed">Processed</option>
              <option value="pending">Pending</option>
              <option value="failed">Failed</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Month</label>
            <select v-model="filters.month" @change="loadEmployees" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-gray-900">
              <option value="">All Months</option>
              <option value="1">January</option>
              <option value="2">February</option>
              <option value="3">March</option>
              <option value="4">April</option>
              <option value="5">May</option>
              <option value="6">June</option>
              <option value="7">July</option>
              <option value="8">August</option>
              <option value="9">September</option>
              <option value="10">October</option>
              <option value="11">November</option>
              <option value="12">December</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- Payroll Table -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Basic Salary</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Allowances</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gross Pay</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deductions</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Net Pay</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="employee in employees" :key="employee.id" class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center">
                        <span class="text-white font-medium">{{ employee.first_name?.charAt(0) }}{{ employee.last_name?.charAt(0) }}</span>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ employee.full_name }}</div>
                      <div class="text-sm text-gray-500">{{ employee.employee_number }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ employee.department?.name || 'N/A' }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">TZS {{ formatCurrency(employee.basic_salary) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">TZS {{ formatCurrency(employee.allowances) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">TZS {{ formatCurrency(employee.gross_pay) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">TZS {{ formatCurrency(employee.deductions) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-green-600">TZS {{ formatCurrency(employee.net_pay) }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span :class="getStatusBadgeClass(employee.status)" 
                        class="px-2 py-1 text-xs font-medium rounded-full">
                    {{ employee.status }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button @click="viewPayslip(employee)" class="text-indigo-600 hover:text-indigo-900" title="View Payslip">
                      <EyeIcon class="w-5 h-5" />
                    </button>
                    <button @click="editPayroll(employee)" class="text-blue-600 hover:text-blue-900" title="Edit">
                      <PencilIcon class="w-5 h-5" />
                    </button>
                    <button @click="viewDeductions(employee)" class="text-green-600 hover:text-green-900" title="View Deductions">
                      <DocumentTextIcon class="w-5 h-5" />
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
import { ref, onMounted, computed } from 'vue'
import { 
  PlusIcon, 
  DocumentArrowDownIcon,
  EyeIcon, 
  PencilIcon, 
  CurrencyDollarIcon,
  UserGroupIcon,
  ReceiptPercentIcon,
  CalendarIcon,
  PlayIcon,
  DocumentTextIcon
} from '@heroicons/vue/24/outline'

export default {
  name: 'PayrollManagement',
  components: {
    PlusIcon,
    DocumentArrowDownIcon,
    EyeIcon,
    PencilIcon,
    CurrencyDollarIcon,
    UserGroupIcon,
    ReceiptPercentIcon,
    CalendarIcon,
    PlayIcon,
    DocumentTextIcon
  },
  setup() {
    const employees = ref([])
    const departments = ref([])
    const showAddModal = ref(false)
    const showEditModal = ref(false)
    const payrollForm = ref({})
    const filters = ref({
      search: '',
      department_id: '',
      pay_period: '',
      status: '',
      month: ''
    })

    // Current date info
    const currentDate = new Date()
    const currentMonth = currentDate.toLocaleString('default', { month: 'long' })
    const currentYear = currentDate.getFullYear()

    // Tanzania-specific payroll statistics
    const stats = ref({
      totalPayroll: 45000000,
      activeEmployees: 342,
      totalDeductions: 8500000,
      netPayroll: 36500000
    })

    // Tanzania-specific payroll data
    const loadEmployees = async () => {
      try {
        // Mock Tanzania-specific payroll data for demonstration
        const mockEmployees = [
          {
            id: 1,
            employee_number: 'TZ-HR-001',
            first_name: 'Amina',
            last_name: 'Mwangi',
            full_name: 'Amina Mwangi',
            department: { id: 1, name: 'Human Resources' },
            basic_salary: 2500000,
            allowances: 500000,
            gross_pay: 3000000,
            deductions: 450000,
            net_pay: 2550000,
            status: 'processed',
            pay_period: 'monthly',
            month: 3,
            year: 2024
          },
          {
            id: 2,
            employee_number: 'TZ-HR-002',
            first_name: 'Joseph',
            last_name: 'Mgaya',
            full_name: 'Joseph Mgaya',
            department: { id: 2, name: 'Operations' },
            basic_salary: 1800000,
            allowances: 300000,
            gross_pay: 2100000,
            deductions: 315000,
            net_pay: 1785000,
            status: 'processed',
            pay_period: 'monthly',
            month: 3,
            year: 2024
          },
          {
            id: 3,
            employee_number: 'TZ-HR-003',
            first_name: 'Grace',
            last_name: 'Kimario',
            full_name: 'Grace Kimario',
            department: { id: 3, name: 'Finance' },
            basic_salary: 1500000,
            allowances: 250000,
            gross_pay: 1750000,
            deductions: 262500,
            net_pay: 1487500,
            status: 'processed',
            pay_period: 'monthly',
            month: 3,
            year: 2024
          },
          {
            id: 4,
            employee_number: 'TZ-HR-004',
            first_name: 'Peter',
            last_name: 'Massawe',
            full_name: 'Peter Massawe',
            department: { id: 4, name: 'Sales & Marketing' },
            basic_salary: 800000,
            allowances: 150000,
            gross_pay: 950000,
            deductions: 142500,
            net_pay: 807500,
            status: 'pending',
            pay_period: 'monthly',
            month: 3,
            year: 2024
          },
          {
            id: 5,
            employee_number: 'TZ-HR-005',
            first_name: 'Sarah',
            last_name: 'Kiwanga',
            full_name: 'Sarah Kiwanga',
            department: { id: 5, name: 'IT' },
            basic_salary: 1200000,
            allowances: 200000,
            gross_pay: 1400000,
            deductions: 210000,
            net_pay: 1190000,
            status: 'processed',
            pay_period: 'monthly',
            month: 3,
            year: 2024
          }
        ]

        // Apply filters
        let filteredEmployees = mockEmployees.filter(emp => {
          if (filters.value.search && !emp.full_name.toLowerCase().includes(filters.value.search.toLowerCase()) &&
              !emp.employee_number.toLowerCase().includes(filters.value.search.toLowerCase())) {
            return false
          }
          if (filters.value.department_id && emp.department?.id != filters.value.department_id) {
            return false
          }
          if (filters.value.pay_period && emp.pay_period !== filters.value.pay_period) {
            return false
          }
          if (filters.value.status && emp.status !== filters.value.status) {
            return false
          }
          if (filters.value.month && emp.month != filters.value.month) {
            return false
          }
          return true
        })

        employees.value = filteredEmployees

        // Update statistics
        stats.value = {
          totalPayroll: mockEmployees.reduce((sum, emp) => sum + emp.gross_pay, 0),
          activeEmployees: mockEmployees.length,
          totalDeductions: mockEmployees.reduce((sum, emp) => sum + emp.deductions, 0),
          netPayroll: mockEmployees.reduce((sum, emp) => sum + emp.net_pay, 0)
        }

      } catch (error) {
        console.error('Error loading payroll data:', error)
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

    const searchEmployees = () => {
      loadEmployees()
    }

    const resetFilters = () => {
      filters.value = {
        search: '',
        department_id: '',
        pay_period: '',
        status: '',
        month: ''
      }
      loadEmployees()
    }

    const formatCurrency = (amount) => {
      return (amount || 0).toLocaleString('en-TZ')
    }

    const getStatusBadgeClass = (status) => {
      const classes = {
        processed: 'bg-green-100 text-green-800',
        pending: 'bg-yellow-100 text-yellow-800',
        failed: 'bg-red-100 text-red-800'
      }
      return classes[status] || 'bg-gray-100 text-gray-800'
    }

    const processPayroll = () => {
      console.log('Processing payroll for all employees...')
      // Implement payroll processing logic
    }

    const exportPayroll = () => {
      console.log('Exporting payroll data...')
      // Implement export functionality
    }

    const viewPayslip = (employee) => {
      console.log('Viewing payslip for:', employee)
      // Implement payslip view
    }

    const editPayroll = (employee) => {
      console.log('Editing payroll for:', employee)
      // Implement payroll edit
    }

    const viewDeductions = (employee) => {
      console.log('Viewing deductions for:', employee)
      // Implement deductions view
    }

    onMounted(() => {
      loadEmployees()
      loadDepartments()
    })

    return {
      employees,
      departments,
      showAddModal,
      showEditModal,
      payrollForm,
      filters,
      stats,
      currentMonth,
      currentYear,
      loadEmployees,
      loadDepartments,
      searchEmployees,
      resetFilters,
      formatCurrency,
      getStatusBadgeClass,
      processPayroll,
      exportPayroll,
      viewPayslip,
      editPayroll,
      viewDeductions
    }
  }
}
</script>
