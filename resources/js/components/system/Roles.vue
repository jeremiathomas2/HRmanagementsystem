<template>
  <div class="p-6">
    <div class="mb-6 flex justify-between items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Roles & Permissions</h1>
        <p class="text-gray-600 mt-2">Advanced role-based access control and permission management</p>
      </div>
      <div class="flex space-x-2">
        <button @click="createRole" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition-colors">
          Create Role
        </button>
        <button @click="managePermissions" class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 transition-colors">
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
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Roles</p>
            <p class="text-2xl font-semibold text-gray-900">12</p>
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
            <p class="text-2xl font-semibold text-gray-900">10</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-purple-100 rounded-full">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
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
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Custom Roles</p>
            <p class="text-2xl font-semibold text-gray-900">7</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Permission Matrix Overview -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
      <h3 class="text-lg font-semibold text-gray-900 mb-4">Permission Matrix Overview</h3>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Module</th>
              <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
              <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">HR Manager</th>
              <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Payroll</th>
              <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
              <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Manager</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="module in permissionModules" :key="module.name">
              <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ module.name }}</td>
              <td class="px-4 py-3 text-center">
                <span :class="getPermissionClass(module.admin)" class="px-2 py-1 text-xs font-semibold rounded-full">
                  {{ module.admin ? 'Full' : 'None' }}
                </span>
              </td>
              <td class="px-4 py-3 text-center">
                <span :class="getPermissionClass(module.hr)" class="px-2 py-1 text-xs font-semibold rounded-full">
                  {{ getPermissionText(module.hr) }}
                </span>
              </td>
              <td class="px-4 py-3 text-center">
                <span :class="getPermissionClass(module.payroll)" class="px-2 py-1 text-xs font-semibold rounded-full">
                  {{ getPermissionText(module.payroll) }}
                </span>
              </td>
              <td class="px-4 py-3 text-center">
                <span :class="getPermissionClass(module.employee)" class="px-2 py-1 text-xs font-semibold rounded-full">
                  {{ getPermissionText(module.employee) }}
                </span>
              </td>
              <td class="px-4 py-3 text-center">
                <span :class="getPermissionClass(module.manager)" class="px-2 py-1 text-xs font-semibold rounded-full">
                  {{ getPermissionText(module.manager) }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Roles Management -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
          <h3 class="text-lg font-semibold text-gray-900">Roles Management</h3>
          <div class="flex space-x-2">
            <input type="text" v-model="searchQuery" placeholder="Search roles..." class="px-3 py-2 border border-gray-300 rounded-md text-sm">
            <select v-model="filterType" class="px-3 py-2 border border-gray-300 rounded-md text-sm">
              <option value="">All Types</option>
              <option value="system">System</option>
              <option value="custom">Custom</option>
              <option value="default">Default</option>
            </select>
          </div>
        </div>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role Name</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Users</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Permissions</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="role in filteredRoles" :key="role.id">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10">
                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                      <span class="text-sm font-medium text-gray-700">{{ role.name.charAt(0) }}</span>
                    </div>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ role.name }}</div>
                    <div class="text-sm text-gray-500">{{ role.slug }}</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getRoleTypeClass(role.type)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                  {{ role.type }}
                </span>
              </td>
              <td class="px-6 py-4 text-sm text-gray-500">
                <div class="max-w-xs truncate" :title="role.description">{{ role.description }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ role.userCount }}</td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ role.permissionCount }} permissions</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span :class="getStatusClass(role.status)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                  {{ role.status }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button @click="editRole(role)" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                <button @click="viewPermissions(role)" class="text-purple-600 hover:text-purple-900 mr-3">Permissions</button>
                <button @click="assignUsers(role)" class="text-green-600 hover:text-green-900 mr-3">Assign</button>
                <button @click="deleteRole(role.id)" class="text-red-600 hover:text-red-900">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Permission Categories -->
    <div class="bg-white rounded-lg shadow">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Permission Categories</h3>
      </div>
      <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="category in permissionCategories" :key="category.name" class="border rounded-lg p-4">
            <div class="flex items-center justify-between mb-3">
              <h4 class="font-medium text-gray-900">{{ category.name }}</h4>
              <span class="text-sm text-gray-500">{{ category.permissions.length }} permissions</span>
            </div>
            <div class="space-y-2">
              <div v-for="permission in category.permissions.slice(0, 3)" :key="permission" class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ permission }}
              </div>
              <div v-if="category.permissions.length > 3" class="text-sm text-gray-500">
                +{{ category.permissions.length - 3 }} more...
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Role Creation Modal -->
    <div v-if="showRoleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" @click="closeRoleModal">
      <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white" @click.stop>
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold text-gray-900">{{ editingRole ? 'Edit Role' : 'Create New Role' }}</h3>
          <button @click="closeRoleModal" class="text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="space-y-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Role Name</label>
              <input type="text" v-model="newRole.name" class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Role Slug</label>
              <input type="text" v-model="newRole.slug" class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
            <textarea v-model="newRole.description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Role Type</label>
              <select v-model="newRole.type" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="custom">Custom</option>
                <option value="system">System</option>
                <option value="default">Default</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
              <select v-model="newRole.status" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
          </div>
          <div>
            <h4 class="font-medium text-gray-900 mb-3">Permissions</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-60 overflow-y-auto">
              <div v-for="category in allPermissions" :key="category.name">
                <h5 class="font-medium text-gray-700 mb-2">{{ category.name }}</h5>
                <div class="space-y-2">
                  <label v-for="permission in category.permissions" :key="permission" class="flex items-center">
                    <input type="checkbox" :value="`${category.name}.${permission}`" v-model="newRole.permissions" class="mr-2">
                    <span class="text-sm text-gray-700">{{ permission }}</span>
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="flex justify-end space-x-2">
            <button @click="closeRoleModal" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition-colors">
              Cancel
            </button>
            <button @click="saveRole" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition-colors">
              {{ editingRole ? 'Update Role' : 'Create Role' }}
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SystemRoles',
  data() {
    return {
      showRoleModal: false,
      editingRole: null,
      searchQuery: '',
      filterType: '',
      newRole: {
        name: '',
        slug: '',
        description: '',
        type: 'custom',
        status: 'active',
        permissions: []
      },
      roles: [
        {
          id: 1,
          name: 'Administrator',
          slug: 'administrator',
          type: 'system',
          description: 'Full system access with all administrative permissions',
          userCount: 8,
          permissionCount: 156,
          status: 'active'
        },
        {
          id: 2,
          name: 'HR Manager',
          slug: 'hr_manager',
          type: 'default',
          description: 'Manage employees, payroll, and HR functions',
          userCount: 12,
          permissionCount: 89,
          status: 'active'
        },
        {
          id: 3,
          name: 'Payroll Manager',
          slug: 'payroll_manager',
          type: 'default',
          description: 'Payroll processing and salary management',
          userCount: 3,
          permissionCount: 45,
          status: 'active'
        },
        {
          id: 4,
          name: 'Employee',
          slug: 'employee',
          type: 'default',
          description: 'Basic employee self-service access',
          userCount: 25,
          permissionCount: 12,
          status: 'active'
        },
        {
          id: 5,
          name: 'Department Manager',
          slug: 'department_manager',
          type: 'custom',
          description: 'Department-level management and reporting',
          userCount: 7,
          permissionCount: 34,
          status: 'active'
        }
      ],
      permissionModules: [
        { name: 'Dashboard', admin: 2, hr: 2, payroll: 2, employee: 1, manager: 2 },
        { name: 'Employees', admin: 2, hr: 2, payroll: 1, employee: 1, manager: 2 },
        { name: 'Payroll', admin: 2, hr: 2, payroll: 2, employee: 0, manager: 1 },
        { name: 'Discipline', admin: 2, hr: 2, payroll: 0, employee: 0, manager: 1 },
        { name: 'Compliance', admin: 2, hr: 1, payroll: 0, employee: 0, manager: 1 },
        { name: 'System', admin: 2, hr: 0, payroll: 0, employee: 0, manager: 0 }
      ],
      permissionCategories: [
        {
          name: 'Dashboard',
          permissions: ['view_dashboard', 'view_analytics', 'export_reports']
        },
        {
          name: 'Employees',
          permissions: ['view_employees', 'create_employee', 'edit_employee', 'delete_employee', 'manage_contracts']
        },
        {
          name: 'Payroll',
          permissions: ['view_payroll', 'process_payroll', 'manage_salaries', 'view_reports']
        },
        {
          name: 'System',
          permissions: ['manage_users', 'manage_roles', 'system_settings', 'view_logs']
        }
      ]
    }
  },
  computed: {
    filteredRoles() {
      let filtered = this.roles
      
      if (this.filterType) {
        filtered = filtered.filter(role => role.type === this.filterType)
      }
      
      if (this.searchQuery) {
        filtered = filtered.filter(role => 
          role.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          role.description.toLowerCase().includes(this.searchQuery.toLowerCase())
        )
      }
      
      return filtered
    },
    allPermissions() {
      return this.permissionCategories
    }
  },
  methods: {
    getPermissionClass(level) {
      const classes = {
        0: 'bg-gray-100 text-gray-800',
        1: 'bg-yellow-100 text-yellow-800',
        2: 'bg-green-100 text-green-800'
      }
      return classes[level] || 'bg-gray-100 text-gray-800'
    },
    getPermissionText(level) {
      const texts = {
        0: 'None',
        1: 'Read',
        2: 'Full'
      }
      return texts[level] || 'None'
    },
    getRoleTypeClass(type) {
      const classes = {
        system: 'bg-purple-100 text-purple-800',
        custom: 'bg-blue-100 text-blue-800',
        default: 'bg-green-100 text-green-800'
      }
      return classes[type] || 'bg-gray-100 text-gray-800'
    },
    getStatusClass(status) {
      const classes = {
        active: 'bg-green-100 text-green-800',
        inactive: 'bg-red-100 text-red-800'
      }
      return classes[status] || 'bg-gray-100 text-gray-800'
    },
    createRole() {
      this.editingRole = null
      this.newRole = {
        name: '',
        slug: '',
        description: '',
        type: 'custom',
        status: 'active',
        permissions: []
      }
      this.showRoleModal = true
    },
    editRole(role) {
      this.editingRole = role
      this.newRole = { ...role }
      this.showRoleModal = true
    },
    closeRoleModal() {
      this.showRoleModal = false
      this.editingRole = null
    },
    saveRole() {
      console.log('Saving role:', this.newRole)
      // In a real application, this would save to the API
      if (this.editingRole) {
        // Update existing role
        const index = this.roles.findIndex(r => r.id === this.editingRole.id)
        if (index !== -1) {
          this.roles[index] = { ...this.newRole, id: this.editingRole.id }
        }
      } else {
        // Create new role
        this.roles.push({
          ...this.newRole,
          id: this.roles.length + 1,
          userCount: 0,
          permissionCount: this.newRole.permissions.length
        })
      }
      this.closeRoleModal()
    },
    viewPermissions(role) {
      console.log('Viewing permissions for role:', role)
      // In a real application, this would open a permissions modal
    },
    assignUsers(role) {
      console.log('Assigning users to role:', role)
      // In a real application, this would open a user assignment modal
    },
    deleteRole(roleId) {
      if (confirm('Are you sure you want to delete this role? This action cannot be undone.')) {
        this.roles = this.roles.filter(r => r.id !== roleId)
        console.log('Role deleted:', roleId)
      }
    },
    managePermissions() {
      console.log('Opening global permissions management')
      // In a real application, this would open a comprehensive permissions interface
    }
  }
}
</script>
