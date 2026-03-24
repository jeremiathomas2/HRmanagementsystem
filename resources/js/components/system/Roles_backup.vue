<template>
  <div class="p-6" :class="{ 'blur-background': showRoleModal }">
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

    <!-- Advanced Permission Matrix -->
    <div class="bg-white rounded-lg shadow">
      <div class="px-6 py-4">
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-lg font-semibold text-gray-900">Advanced Permission Matrix</h3>
          <div class="flex items-center space-x-4">
            <!-- Search and Filter -->
            <div class="relative">
              <input
                type="text"
                v-model="permissionSearch"
                placeholder="Search permissions..."
                class="w-64 px-3 py-2 pl-10 pr-4 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              >
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2 5a7 7 0 0114 0m0 7a7 7 0 0114 0" />
                </svg>
              </div>
            </div>
            
            <!-- Role Filter -->
            <select v-model="selectedRoleFilter" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">All Roles</option>
              <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
            </select>
            
            <!-- View Toggle -->
            <div class="flex items-center space-x-2">
              <button
                @click="viewMode = 'table'"
                :class="{ 'bg-indigo-600 text-white': viewMode === 'table', 'bg-gray-200 text-gray-700': viewMode === 'grid' }"
                class="px-3 py-1 text-sm rounded transition-colors"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h6v2a1 1 0 110-2h4a1 1 0 110-2H3a1 1 0 111-2h4a1 1 0 011-2z" />
                </svg>
                Table
              </button>
              <button
                @click="viewMode = 'grid'"
                :class="{ 'bg-indigo-600 text-white': viewMode === 'grid', 'bg-gray-200 text-gray-700': viewMode === 'table' }"
                class="px-3 py-1 text-sm rounded transition-colors"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 100-4m0 6a2 2 0 100-4" />
                </svg>
                Grid
              </button>
            </div>
            
            <!-- Permission Category Filter -->
            <select v-model="selectedCategoryFilter" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">All Categories</option>
              <option v-for="category in permissionCategories" :key="category.name" :value="category.name">{{ category.name }}</option>
            </select>
          </div>
        </div>
        
        <!-- View Mode Toggle -->
        <div v-if="viewMode === 'table'" class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100 sticky top-0 z-10">
                  <div class="flex items-center">
                    Permission
                    <button @click="sortPermissions('name')" class="ml-2 text-indigo-600 hover:text-indigo-800">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 2a2 2 0 100-4m0 6a2 2 0 100-4" />
                      </svg>
                    </button>
                  </div>
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100 sticky top-0 z-10">
                  <div class="flex items-center">
                    {{ selectedRoleFilter === '' ? 'All Roles' : getSelectedRoleName() }}
                    <button @click="sortPermissions('role')" class="ml-2 text-indigo-600 hover:text-indigo-800">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h6v2a1 1 0 110-2h4a1 1 0 110-2" />
                      </svg>
                    </button>
                  </div>
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100 sticky top-0 z-10">
                  <div class="flex items-center justify-between">
                    <span>Users</span>
                    <button @click="sortPermissions('users')" class="text-indigo-600 hover:text-indigo-800">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h6v2a1 1 0 110-2h4a1 1 0 110-2" />
                      </svg>
                    </button>
                  </div>
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100 sticky top-0 z-10">
                  <div class="flex items-center justify-between">
                    <span>Status</span>
                    <button @click="sortPermissions('status')" class="text-indigo-600 hover:text-indigo-800">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h6v2a1 1 0 110-2h4a1 1 0 110-2" />
                      </svg>
                    </button>
                  </div>
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100 sticky top-0 z-10">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="role in filteredMatrixRoles" :key="role.id" class="hover:bg-gray-50 transition-colors">
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
                <td class="px-6 py-4 text-center">
                  <div class="flex justify-center space-x-1">
                    <span :class="getUserCountClass(role.userCount)" class="px-2 py-1 text-xs font-semibold rounded-full">
                      {{ role.userCount }}
                    </span>
                    <button @click="editRole(role)" class="ml-2 text-indigo-600 hover:text-indigo-900">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 100-4m0 6a2 2 0 100-4" />
                      </svg>
                    </button>
                  </div>
                </td>
                <td class="px-6 py-4 text-center">
                  <span :class="getRoleTypeClass(role.type)" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                    {{ role.type }}
                  </span>
                </td>
                <td class="px-6 py-4 text-center">
                  <div class="flex justify-center space-x-1">
                    <span :class="getPermissionCountClass(role.permissionCount)" class="px-2 py-1 text-xs font-semibold rounded-full">
                      {{ role.permissionCount }}
                    </span>
                    <button @click="viewPermissions(role)" class="text-indigo-600 hover:text-indigo-900">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 100-6m0 6a3 3 0 100-6" />
                      </svg>
                    </button>
                  </div>
                </td>
                <td class="px-6 py-4 text-center">
                  <span :class="getStatusClass(role.status)" class="px-2 py-1 text-xs font-semibold rounded-full">
                    {{ role.status }}
                  </span>
                </td>
                <td class="px-6 py-4">
                  <div class="flex justify-center space-x-1">
                    <button @click="assignUsers(role)" class="text-green-600 hover:text-green-900">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a4 4 0 11-8 0 4 4 0 018 0z" />
                      </svg>
                    </button>
                    <button @click="toggleRoleStatus(role)" class="text-yellow-600 hover:text-yellow-900">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H7a4 4 0 00-8 0v8a4 4 0 00-8 0M12 14a4 4 0 11-8 0 4 4 0 018 0z" />
                      </svg>
                    </button>
                    <button @click="deleteRole(role.id)" class="text-red-600 hover:text-red-900">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 01-2.83 5.24l-6.835 6.829A2 2 0 00-2.83 5.24L12 2l6.835 6.829A2 2 0 00-2.83 5.24L17 15H7z" />
                      </svg>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        
        <!-- Grid View -->
        <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="role in filteredMatrixRoles" :key="role.id" class="border rounded-lg p-6 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
              <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                  {{ role.name.charAt(0) }}
                </div>
                <div class="ml-4">
                  <div class="text-lg font-medium text-gray-900">{{ role.name }}</div>
                  <div class="text-sm text-gray-500">{{ role.slug }}</div>
                </div>
              </div>
              <div class="flex items-center space-x-2">
                <span :class="getUserCountClass(role.userCount)" class="px-2 py-1 text-xs font-semibold rounded-full">
                  {{ role.userCount }} users
                </span>
                <span :class="getRoleTypeClass(role.type)" class="px-2 py-1 text-xs font-semibold rounded-full">
                  {{ role.type }}
                </span>
                <span :class="getPermissionCountClass(role.permissionCount)" class="px-2 py-1 text-xs font-semibold rounded-full">
                  {{ role.permissionCount }} permissions
                </span>
              </div>
            </div>
            
            <!-- Permission Categories -->
            <div class="mt-4 space-y-3">
              <h4 class="text-sm font-medium text-gray-700 mb-2">Permissions</h4>
              <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                <div v-for="category in permissionCategories" :key="category.name" class="border rounded-lg p-4">
                  <div class="flex items-center justify-between mb-3">
                    <h5 class="font-medium text-gray-900">{{ category.name }}</h5>
                    <span class="text-sm text-gray-500">{{ category.permissions.length }} permissions</span>
                  </div>
                  <div class="space-y-2">
                    <label v-for="permission in category.permissions" :key="permission" class="flex items-center text-sm text-gray-600">
                      <input 
                        type="checkbox" 
                        :value="`${role.id}.${permission}`" 
                        v-model="selectedPermissions[role.id]" 
                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                      >
                      <span class="ml-2">{{ permission }}</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex justify-end space-x-2 mt-4">
              <button @click="savePermissions" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition-colors">
              <button @click="resetPermissions" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition-colors">
                Reset
              </button>
              <button @click="savePermissions" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition-colors">
                Save Permissions
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Role Creation Modal -->
    <transition name="modal" appear>
      <div v-if="showRoleModal" class="fixed inset-0 z-50 flex items-center justify-center" @click="closeRoleModal">
        <!-- Backdrop Blur -->
        <div class="absolute inset-0 bg-black bg-opacity-60 backdrop-blur-sm"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-xl shadow-2xl w-11/12 md:w-3/4 lg:w-2/3 max-h-[90vh] overflow-hidden z-50 transform transition-all duration-300 ease-out" @click.stop>
          <!-- Modal Header -->
          <div class="flex justify-between items-center px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-600 to-purple-600">
            <h3 class="text-lg font-semibold text-white">{{ editingRole ? 'Edit Role' : 'Create New Role' }}</h3>
            <button @click="closeRoleModal" class="text-white hover:text-gray-200 transition-colors">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          
          <!-- Modal Body -->
          <div class="p-6 overflow-y-auto max-h-[calc(90vh-80px)]">
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
                <label class="block text-sm font-medium text-gray-700 mb-2">Role Description</label>
                <textarea v-model="newRole.description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md"></textarea>
              </div>
            </div>
            
            <!-- Permission Categories -->
            <div class="space-y-4">
              <h4 class="text-sm font-medium text-gray-700 mb-3">Permissions</h4>
              <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div v-for="category in permissionCategories" :key="category.name" class="border rounded-lg p-4">
                  <div class="flex items-center justify-between mb-3">
                    <h5 class="font-medium text-gray-900">{{ category.name }}</h5>
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
    </transition>
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
      searchQuery: '',
      filterType: '',
      permissionSearch: '',
      selectedRoleFilter: '',
      selectedCategoryFilter: '',
      viewMode: 'table', // 'table' or 'grid'
      selectedPermissions: {},
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
          name: 'Super Admin',
          slug: 'super-admin',
          description: 'Full system access with all permissions',
          type: 'system',
          userCount: 1,
          permissionCount: 156
        },
        {
          id: 2,
          name: 'HR Manager',
          slug: 'hr-manager',
          description: 'Manage employees, payroll, and attendance',
          type: 'custom',
          userCount: 5,
          permissionCount: 45
        },
        {
          id: 3,
          name: 'Finance Manager',
          slug: 'finance-manager',
          description: 'Access to financial reports and payroll data',
          type: 'custom',
          userCount: 3,
          permissionCount: 32
        },
        {
          id: 4,
          name: 'Employee',
          slug: 'employee',
          description: 'Basic employee access',
          type: 'default',
          userCount: 156,
          permissionCount: 12
        }
      ],
      permissionCategories: [
        {
          name: 'User Management',
          permissions: ['create_user', 'edit_user', 'delete_user', 'view_users', 'manage_roles', 'assign_permissions']
        },
        {
          name: 'Employee Management',
          permissions: ['create_employee', 'edit_employee', 'delete_employee', 'view_employees', 'manage_contracts', 'view_payroll']
        },
        {
          name: 'Payroll Management',
          permissions: ['process_payroll', 'view_payroll_reports', 'manage_tax_settings', 'approve_payouts']
        },
        {
          name: 'System Settings',
          permissions: ['manage_system', 'view_logs', 'manage_backups', 'system_configuration']
        },
        {
          name: 'Reporting',
          permissions: ['view_reports', 'export_reports', 'schedule_reports', 'manage_dashboards']
        }
      ]
    }
  },
  computed: {
    filteredRoles() {
      let filtered = this.roles
      
      if (this.searchQuery) {
        filtered = filtered.filter(role => 
          role.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          role.description.toLowerCase().includes(this.searchQuery.toLowerCase())
        )
      }
      
      if (this.filterType) {
        filtered = filtered.filter(role => role.type === this.filterType)
      }
      
      return filtered
    },
    
    filteredMatrixRoles() {
      let filtered = this.roles
      
      if (this.searchQuery) {
        filtered = filtered.filter(role => 
          role.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          role.description.toLowerCase().includes(this.searchQuery.toLowerCase())
        )
      }
      
      if (this.selectedRoleFilter) {
        filtered = filtered.filter(role => role.id === this.selectedRoleFilter)
      }
      
      if (this.selectedCategoryFilter) {
        filtered = filtered.filter(role => 
          role.permissions.some(perm => 
            this.permissionCategories.find(cat => cat.permissions.includes(perm))?.name === this.selectedCategoryFilter
          )
        )
      }
      
      return filtered
    },
    
    getSelectedRoleName() {
      const role = this.roles.find(r => r.id === this.selectedRoleFilter)
      return role ? role.name : 'All Roles'
    },
    
    getUserCountClass(count) {
      if (count === 0) return 'bg-gray-100 text-gray-600'
      if (count < 5) return 'bg-green-100 text-green-800'
      if (count < 10) return 'bg-yellow-100 text-yellow-800'
      if (count < 20) return 'bg-orange-100 text-orange-800'
      return 'bg-red-100 text-red-800'
    },
    
    getPermissionCountClass(count) {
      if (count === 0) return 'bg-gray-100 text-gray-600'
      if (count < 10) return 'bg-green-100 text-green-800'
      if (count < 25) return 'bg-yellow-100 text-yellow-800'
      if (count < 50) return 'bg-orange-100 text-orange-800'
      return 'bg-red-100 text-red-800'
    },
    
    getStatusClass(status) {
      const classes = {
        active: 'bg-green-100 text-green-800',
        inactive: 'bg-gray-100 text-gray-600',
        pending: 'bg-yellow-100 text-yellow-800',
        suspended: 'bg-red-100 text-red-800'
      }
      return classes[status] || 'bg-gray-100 text-gray-600'
    }
  },
  methods: {
    sortPermissions(field) {
      this.sortField = field
      this.sortDirection = this.sortField === field ? (this.sortDirection === 'asc' ? 'desc' : 'asc') : 'asc'
    },
    viewPermissions(role) {
      console.log('Viewing permissions for role:', role)
      notification.info('Role Permissions', `Viewing ${role.permissionCount} permissions for role "${role.name}".`)
      // In a real application, this would open a detailed permissions modal
    },
    assignUsers(role) {
      console.log('Assigning users to role:', role)
      notification.info('User Assignment', `Managing user assignments for role "${role.name}" (${role.userCount} users).`)
      // In a real application, this would open a user assignment modal
    },
    toggleRoleStatus(role) {
      const newStatus = role.status === 'active' ? 'inactive' : 'active'
      const index = this.roles.findIndex(r => r.id === role.id)
      if (index !== -1) {
        this.roles[index].status = newStatus
        const statusMessage = newStatus === 'active' ? 'activated' : 'deactivated'
        notification.success('Role Status Updated', `Role "${role.name}" has been ${statusMessage}.`)
      }
    },
    deleteRole(roleId) {
      if (confirm('Are you sure you want to delete this role? This action cannot be undone.')) {
        const role = this.roles.find(r => r.id === roleId)
        this.roles = this.roles.filter(r => r.id !== roleId)
        console.log('Role deleted:', roleId)
        notification.error('Role Deleted', `Role "${role.name}" has been deleted successfully.`)
      }
    },
    managePermissions() {
      console.log('Opening global permissions management')
      notification.info('Permissions Management', 'Opening comprehensive permissions management interface.')
      // In a real application, this would open a comprehensive permissions interface
    },
    savePermissions() {
      console.log('Saving permissions for roles')
      notification.success('Permissions Saved', 'Role permissions have been saved successfully.')
      // In a real application, this would save to API
    },
    resetPermissions() {
      console.log('Resetting permissions')
      notification.info('Permissions Reset', 'All permission changes have been reset.')
      // Reset selected permissions
      Object.keys(this.selectedPermissions).forEach(roleId => {
        this.selectedPermissions[roleId] = []
      })
    }
}
</script>

<style scoped>
.blur-background {
  transition: filter 0.3s ease;
}

.blur-background > *:not(.fixed) {
  filter: blur(2px);
  pointer-events: none;
}

/* Ensure modal content is not blurred */
.blur-background .fixed,
.blur-background .fixed * {
  filter: none !important;
  pointer-events: auto;
}

/* Modal animations */
.modal-enter-active,
.modal-leave-active {
  transition: all 0.3s ease;
}

.modal-enter-from {
  opacity: 0;
  transform: scale(0.9) translateY(-20px);
}

.modal-leave-to {
  opacity: 0;
  transform: scale(0.9) translateY(-20px);
}
</style>
