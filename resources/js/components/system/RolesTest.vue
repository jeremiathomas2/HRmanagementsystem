<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-4">System Roles - Test Version</h1>
    <p class="text-gray-600 mb-6">This is a simplified test version to verify the component loads.</p>
    
    <div class="bg-white p-6 rounded-lg shadow">
      <h2 class="text-lg font-semibold mb-4">Test Content</h2>
      <p>If you can see this page, the routing is working correctly.</p>
      
      <button class="bg-indigo-600 text-white px-4 py-2 rounded mt-4" @click="showAlert">
        Test Button
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SystemRolesTest',
  methods: {
    showAlert() {
      alert('Component is working!')
    }
  }
}
</script>
