<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">Discipline Hearings</h1>
      <p class="text-gray-600 mt-2">Manage disciplinary hearing schedules and outcomes</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Scheduled Hearings</h3>
      <div class="space-y-4">
        <div class="border rounded-lg p-4">
          <div class="flex justify-between items-start">
            <div>
              <h4 class="font-medium text-gray-900">Case #DSC-001 - John Doe</h4>
              <p class="text-sm text-gray-600 mt-1">Scheduled: March 20, 2024 at 10:00 AM</p>
              <p class="text-sm text-gray-600">Violation: Policy Violation - Attendance Issues</p>
            </div>
            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
          </div>
          <div class="mt-3 flex space-x-2">
            <button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition-colors text-sm">
              View Details
            </button>
            <button class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition-colors text-sm">
              Conduct Hearing
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DisciplineHearings'
}
</script>
