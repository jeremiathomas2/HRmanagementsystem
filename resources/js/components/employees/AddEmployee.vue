<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">Add New Employee</h1>
      <p class="text-gray-600 mt-2">Register a new employee in the system</p>
    </div>

    <div class="bg-white rounded-lg shadow">
      <form @submit.prevent="handleSubmit" class="p-6 space-y-6">
        <!-- Personal Information -->
        <div class="border-b border-gray-200 pb-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">First Name *</label>
              <input type="text" v-model="form.firstName" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Last Name *</label>
              <input type="text" v-model="form.lastName" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
              <input type="email" v-model="form.email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
              <input type="tel" v-model="form.phone" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth *</label>
              <input type="date" v-model="form.dateOfBirth" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Gender *</label>
              <select v-model="form.gender" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Job Information -->
        <div class="border-b border-gray-200 pb-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Job Information</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Employee ID *</label>
              <input type="text" v-model="form.employeeId" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Department *</label>
              <select v-model="form.department" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Select Department</option>
                <option value="engineering">Engineering</option>
                <option value="sales">Sales</option>
                <option value="hr">Human Resources</option>
                <option value="finance">Finance</option>
                <option value="marketing">Marketing</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Job Title *</label>
              <input type="text" v-model="form.jobTitle" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Employment Type *</label>
              <select v-model="form.employmentType" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Select Type</option>
                <option value="full-time">Full Time</option>
                <option value="part-time">Part Time</option>
                <option value="contract">Contract</option>
                <option value="intern">Intern</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
              <input type="date" v-model="form.startDate" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Reports To</label>
              <select v-model="form.reportsTo" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Select Manager</option>
                <option value="manager1">John Doe</option>
                <option value="manager2">Jane Smith</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Compensation -->
        <div class="border-b border-gray-200 pb-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Compensation</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Basic Salary (TZS) *</label>
              <input type="number" v-model="form.basicSalary" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method *</label>
              <select v-model="form.paymentMethod" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Select Method</option>
                <option value="bank">Bank Transfer</option>
                <option value="cash">Cash</option>
                <option value="mobile">Mobile Money</option>
              </select>
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-gray-700 mb-2">Bank Details</label>
              <input type="text" v-model="form.bankDetails" placeholder="Bank Name, Account Number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
          </div>
        </div>

        <!-- Tanzanian Specific Fields -->
        <div class="border-b border-gray-200 pb-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Tanzanian Compliance Information</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">NIN Number</label>
              <input type="text" v-model="form.ninNumber" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">NSSF Number</label>
              <input type="text" v-model="form.nssfNumber" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Tax Identification Number (TIN)</label>
              <input type="text" v-model="form.tinNumber" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Work Permit (for non-citizens)</label>
              <input type="text" v-model="form.workPermit" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
          </div>
        </div>

        <!-- Emergency Contact -->
        <div class="pb-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Emergency Contact</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Contact Name *</label>
              <input type="text" v-model="form.emergencyContactName" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Relationship *</label>
              <input type="text" v-model="form.emergencyContactRelationship" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Contact Phone *</label>
              <input type="tel" v-model="form.emergencyContactPhone" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Contact Email</label>
              <input type="email" v-model="form.emergencyContactEmail" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-4">
          <button type="button" @click="$router.go(-1)" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
            Cancel
          </button>
          <button type="submit" :disabled="submitting" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors disabled:opacity-50">
            {{ submitting ? 'Creating...' : 'Create Employee' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AddEmployee',
  data() {
    return {
      submitting: false,
      form: {
        firstName: '',
        lastName: '',
        email: '',
        phone: '',
        dateOfBirth: '',
        gender: '',
        employeeId: '',
        department: '',
        jobTitle: '',
        employmentType: '',
        startDate: '',
        reportsTo: '',
        basicSalary: '',
        paymentMethod: '',
        bankDetails: '',
        ninNumber: '',
        nssfNumber: '',
        tinNumber: '',
        workPermit: '',
        emergencyContactName: '',
        emergencyContactRelationship: '',
        emergencyContactPhone: '',
        emergencyContactEmail: ''
      }
    }
  },
  methods: {
    async handleSubmit() {
      this.submitting = true
      try {
        // API call to create employee
        await new Promise(resolve => setTimeout(resolve, 1000)) // Simulate API call
        alert('Employee created successfully!')
        this.$router.push('/employees')
      } catch (error) {
        alert('Error creating employee')
      } finally {
        this.submitting = false
      }
    }
  }
}
</script>
