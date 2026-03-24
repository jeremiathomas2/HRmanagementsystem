<template>
  <div class="p-6" :class="{ 'blur-background': showRoleModal }">
    <div class="mb-6 flex justify-between items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Roles & Permissions</h1>
        <p class="text-gray-600 mt-2">Advanced role-based access control and permission management</p>
      </div>
      <div class="flex space-x-2">
        <button @click="createRole" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors">
          Create Role
        </button>
        <button @click="managePermissions" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
          Manage Permissions
        </button>
      </div>
    </div>

    <!-- Role Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-blue-100 rounded-full">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 0112 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Roles</p>
            <p class="text-2xl font-semibold text-gray-900">{{ roles.length }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-green-100 rounded-full">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Active Roles</p>
            <p class="text-2xl font-semibold text-gray-900">{{ activeRolesCount }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-purple-100 rounded-full">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Permissions</p>
            <p class="text-2xl font-semibold text-gray-900">156</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-yellow-100 rounded-full">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100-4m0 6a2 2 0 100-4" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Custom Roles</p>
            <p class="text-2xl font-semibold text-gray-900">{{ customRolesCount }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Roles Table -->
    <div class="bg-white rounded-lg shadow">
      <div class="px-6 py-4">
        <h3 class="text-lg font-semibold text-gray-900">Roles List</h3>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Users</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="role in roles" :key="role.id">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="w-8 h-8 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">
                    {{ role.name.charAt(0) }}
                  </div>
                  <div class="ml-3">
                    <div class="text-sm font-medium text-gray-900">{{ role.name }}</div>
                    <div class="text-xs text-gray-500">{{ role.slug }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getRoleTypeClass(role.type)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                  {{ role.type }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getStatusClass(role.status)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                  {{ role.status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                {{ role.userCount }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button @click="editRole(role)" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                <button @click="deleteRole(role)" class="text-red-600 hover:text-red-900">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Role Modal -->
    <div v-if="showRoleModal" class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm" @click="showRoleModal = false"></div>
        <div class="relative bg-white rounded-lg shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
          <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-4 rounded-t-lg">
            <div class="flex items-center justify-between">
              <h3 class="text-lg font-semibold">
                {{ editingRole ? 'Edit Role' : 'Create New Role' }}
              </h3>
              <button @click="showRoleModal = false" class="text-white hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>

          <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Role Name</label>
                <input v-model="newRole.name" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Enter role name">
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Role Slug</label>
                <input v-model="newRole.slug" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="role-slug">
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
              <textarea v-model="newRole.description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Describe the role's responsibilities"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Role Type</label>
                <select v-model="newRole.type" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                  <option value="system">System</option>
                  <option value="custom">Custom</option>
                  <option value="default">Default</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select v-model="newRole.status" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                  <option value="pending">Pending</option>
                </select>
              </div>
            </div>
          </div>

          <div class="flex justify-end space-x-3 px-6 py-4 bg-gray-50 rounded-b-lg">
            <button @click="showRoleModal = false" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Cancel</button>
            <button @click="saveRole" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
              {{ editingRole ? 'Update Role' : 'Create Role' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import notification from '../../utils/notification.js'

export default {
  name: 'SystemRoles',
  data() {
    return {
      showRoleModal: false,
      editingRole: null,
      newRole: {
        name: '',
        slug: '',
        description: '',
        type: 'custom',
        status: 'active'
      },
      roles: [
        {
          id: 1,
          name: 'Super Admin',
          slug: 'super-admin',
          description: 'Full system access with all permissions',
          type: 'system',
          status: 'active',
          userCount: 1
        },
        {
          id: 2,
          name: 'HR Manager',
          slug: 'hr-manager',
          description: 'Manage employees, payroll, and attendance',
          type: 'custom',
          status: 'active',
          userCount: 5
        },
        {
          id: 3,
          name: 'Finance Manager',
          slug: 'finance-manager',
          description: 'Access to financial reports and payroll data',
          type: 'custom',
          status: 'active',
          userCount: 3
        },
        {
          id: 4,
          name: 'Employee',
          slug: 'employee',
          description: 'Basic employee access',
          type: 'default',
          status: 'active',
          userCount: 156
        }
      ]
    }
  },
  computed: {
    activeRolesCount() {
      return this.roles.filter(role => role.status === 'active').length
    },
    customRolesCount() {
      return this.roles.filter(role => role.type === 'custom').length
    }
  },
  methods: {
    createRole() {
      this.editingRole = null
      this.newRole = {
        name: '',
        slug: '',
        description: '',
        type: 'custom',
        status: 'active'
      }
      this.showRoleModal = true
      notification.info('Create Role', 'Opening role creation form.')
    },
    
    managePermissions() {
      notification.info('Permissions Management', 'Opening comprehensive permissions management interface.')
    },
    
    editRole(role) {
      this.editingRole = role
      this.newRole = { ...role }
      this.showRoleModal = true
      notification.info('Edit Role', `Editing role "${role.name}".`)
    },
    
    saveRole() {
      if (this.editingRole) {
        const index = this.roles.findIndex(r => r.id === this.editingRole.id)
        if (index !== -1) {
          this.roles[index] = { ...this.newRole, id: this.editingRole.id }
        }
        notification.success('Role Updated', `Role "${this.newRole.name}" has been updated successfully.`)
      } else {
        const newRoleData = {
          ...this.newRole,
          id: Math.max(...this.roles.map(r => r.id)) + 1,
          userCount: 0
        }
        this.roles.push(newRoleData)
        notification.success('Role Created', `Role "${this.newRole.name}" has been created successfully.`)
      }
      this.showRoleModal = false
      this.editingRole = null
    },
    
    deleteRole(role) {
      if (confirm(`Are you sure you want to delete the role "${role.name}"?`)) {
        this.roles = this.roles.filter(r => r.id !== role.id)
        notification.success('Role Deleted', `Role "${role.name}" has been deleted successfully.`)
      }
    },
    
    getRoleTypeClass(type) {
      const classes = {
        system: 'bg-purple-100 text-purple-800',
        custom: 'bg-blue-100 text-blue-800',
        default: 'bg-gray-100 text-gray-800'
      }
      return classes[type] || 'bg-gray-100 text-gray-800'
    },
    
    getStatusClass(status) {
      const classes = {
        active: 'bg-green-100 text-green-800',
        inactive: 'bg-gray-100 text-gray-600',
        pending: 'bg-yellow-100 text-yellow-800'
      }
      return classes[status] || 'bg-gray-100 text-gray-600'
    }
  }
}
</script>

<style scoped>
.blur-background {
  transition: all 0.3s ease;
  position: relative;
}

.blur-background::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.4);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  z-index: 1;
  pointer-events: none;
}

.blur-background > *:not(.fixed) {
  filter: blur(1px);
  opacity: 0.7;
  pointer-events: none;
  transition: all 0.3s ease;
}

.blur-background .fixed,
.blur-background .fixed * {
  filter: none !important;
  backdrop-filter: none !important;
  -webkit-backdrop-filter: none !important;
  opacity: 1 !important;
  pointer-events: auto !important;
  z-index: 50 !important;
  position: relative !important;
}
</style>
