<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">New Discipline Case</h1>
      <p class="text-gray-600 mt-2">Create a new disciplinary case file</p>
    </div>

    <div class="bg-white rounded-lg shadow">
      <form @submit.prevent="handleSubmit" class="p-6 space-y-6">
        <!-- Case Information -->
        <div class="border-b border-gray-200 pb-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Case Information</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Case ID *</label>
              <input type="text" v-model="form.caseId" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Date Filed *</label>
              <input type="date" v-model="form.dateFiled" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Employee *</label>
              <select v-model="form.employeeId" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Select Employee</option>
                <option value="emp001">John Doe - Software Engineer</option>
                <option value="emp002">Jane Smith - HR Manager</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Priority Level *</label>
              <select v-model="form.priority" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Select Priority</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
                <option value="critical">Critical</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Incident Details -->
        <div class="border-b border-gray-200 pb-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Incident Details</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Incident Date *</label>
              <input type="date" v-model="form.incidentDate" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Incident Time *</label>
              <input type="time" v-model="form.incidentTime" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Location *</label>
              <input type="text" v-model="form.location" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Witnesses</label>
              <input type="text" v-model="form.witnesses" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>
          </div>
          <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">Description of Incident *</label>
            <textarea v-model="form.description" required rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
          </div>
        </div>

        <!-- Violation Type -->
        <div class="border-b border-gray-200 pb-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Violation Type</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="flex items-center">
              <input type="checkbox" v-model="form.violations" value="attendance" class="mr-2">
              <span class="text-sm text-gray-700">Attendance Issues</span>
            </label>
            <label class="flex items-center">
              <input type="checkbox" v-model="form.violations" value="misconduct" class="mr-2">
              <span class="text-sm text-gray-700">Misconduct</span>
            </label>
            <label class="flex items-center">
              <input type="checkbox" v-model="form.violations" value="policy" class="mr-2">
              <span class="text-sm text-gray-700">Policy Violation</span>
            </label>
            <label class="flex items-center">
              <input type="checkbox" v-model="form.violations" value="harassment" class="mr-2">
              <span class="text-sm text-gray-700">Harassment</span>
            </label>
            <label class="flex items-center">
              <input type="checkbox" v-model="form.violations" value="theft" class="mr-2">
              <span class="text-sm text-gray-700">Theft</span>
            </label>
            <label class="flex items-center">
              <input type="checkbox" v-model="form.violations" value="performance" class="mr-2">
              <span class="text-sm text-gray-700">Performance Issues</span>
            </label>
          </div>
        </div>

        <!-- Evidence -->
        <div class="pb-6">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Evidence</h3>
          <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            <div class="mt-4">
              <p class="text-sm text-gray-600">Click to upload or drag and drop</p>
              <p class="text-xs text-gray-500">PDF, DOC, DOCX, JPG, PNG up to 10MB</p>
            </div>
            <input type="file" class="hidden" multiple>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-4">
          <button type="button" @click="$router.go(-1)" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
            Cancel
          </button>
          <button type="submit" :disabled="submitting" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors disabled:opacity-50">
            {{ submitting ? 'Creating...' : 'Create Case' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DisciplineNewCase',
  data() {
    return {
      submitting: false,
      form: {
        caseId: '',
        dateFiled: '',
        employeeId: '',
        priority: '',
        incidentDate: '',
        incidentTime: '',
        location: '',
        witnesses: '',
        description: '',
        violations: []
      }
    }
  },
  methods: {
    async handleSubmit() {
      this.submitting = true
      try {
        await new Promise(resolve => setTimeout(resolve, 1000))
        alert('Discipline case created successfully!')
        this.$router.push('/discipline')
      } catch (error) {
        alert('Error creating case')
      } finally {
        this.submitting = false
      }
    }
  }
}
</script>
