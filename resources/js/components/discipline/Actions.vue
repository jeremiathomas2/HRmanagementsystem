<template>
  <div class="p-6">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">Disciplinary Actions</h1>
      <p class="text-gray-600 mt-2">View and manage disciplinary action outcomes</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Action History</h3>
      <div class="space-y-4">
        <div class="border rounded-lg p-4">
          <div class="flex justify-between items-start">
            <div>
              <h4 class="font-medium text-gray-900">Written Warning - John Doe</h4>
              <p class="text-sm text-gray-600 mt-1">Issued: March 15, 2024</p>
              <p class="text-sm text-gray-600">Case: DSC-001 - Policy Violation</p>
            </div>
            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DisciplineActions'
}
</script>
