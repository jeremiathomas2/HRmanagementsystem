<template>
  <div class="p-6" :class="{ 'blur-background': showRoleModal }">
    <div class="mb-6 flex justify-between items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Roles & Permissions</h1>
        <p class="text-gray-600 mt-2">Advanced role-based access control and permission management</p>
      </div>
      <div class="flex space-x-2">
        <button @click="createRole" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition-all duration-200 flex items-center shadow-md hover:shadow-lg transform hover:scale-105 font-semibold">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-2H4a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2z" />
          </svg>
          Create Role
        </button>
        <button @click="managePermissions" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 active:bg-purple-800 transition-all duration-200 flex items-center shadow-md hover:shadow-lg transform hover:scale-105 font-semibold">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
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
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100-4m0 6a2 2 0 100-4" />
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
                class="w-64 px-3 py-2 pl-10 pr-4 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white text-gray-900 placeholder-gray-500 shadow-sm focus:shadow-md transition-all duration-200"
              >
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2 5a7 7 0 0114 0m0 7a7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
            
            <!-- Role Filter -->
            <select v-model="selectedRoleFilter" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white text-gray-900 shadow-sm focus:shadow-md transition-all duration-200">
              <option value="">All Roles</option>
              <option v-for="role in roles" :key="role.id" :value="role.id">{{ role.name }}</option>
            </select>
            
            <!-- View Toggle -->
            <div class="flex items-center space-x-2">
              <button
                @click="viewMode = 'table'"
                :class="{ 'bg-indigo-600 text-white shadow-md': viewMode === 'table', 'bg-gray-200 text-gray-700 shadow-sm': viewMode === 'grid' }"
                class="px-3 py-2 text-sm rounded-lg transition-all duration-200 font-medium"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h6v2a1 1 0 110-2h4a1 1 0 110-2" />
                </svg>
                <span class="ml-1">Table</span>
              </button>
              <button
                @click="viewMode = 'grid'"
                :class="{ 'bg-indigo-600 text-white shadow-md': viewMode === 'grid', 'bg-gray-200 text-gray-700 shadow-sm': viewMode === 'table' }"
                class="px-3 py-2 text-sm rounded-lg transition-all duration-200 font-medium"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 100-4m0 6a2 2 0 100-4" />
                </svg>
                <span class="ml-1">Grid</span>
              </button>
            </div>
            
            <!-- Permission Category Filter -->
            <select v-model="selectedCategoryFilter" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white text-gray-900 shadow-sm focus:shadow-md transition-all duration-200">
              <option value="">All Categories</option>
              <option v-for="category in permissionCategories" :key="category.name" :value="category.name">{{ category.name }}</option>
            </select>
          </div>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 2a1 1 0 110-2h4a1 1 0 110-2" />
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a4 4 0 11-8 0 4 4 0 018 0z" />
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
                  <div class="flex justify-center space-x-2">
                    <span :class="getUserCountClass(role.userCount)" class="px-2 py-1 text-xs font-semibold rounded-full">
                      {{ role.userCount }}
                    </span>
                    <button @click="editRole(role)" class="p-2 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 hover:text-indigo-900 rounded-lg transition-all duration-200 border border-indigo-200" title="Edit Role">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 100-4m0 6a2 2 0 110-2" />
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
                  <div class="flex justify-center space-x-2">
                    <span :class="getPermissionCountClass(role.permissionCount)" class="px-2 py-1 text-xs font-semibold rounded-full">
                      {{ role.permissionCount }}
                    </span>
                    <button @click="viewPermissions(role)" class="p-2 bg-purple-50 text-purple-700 hover:bg-purple-100 hover:text-purple-900 rounded-lg transition-all duration-200 border border-purple-200" title="View Permissions">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                      </svg>
                    </button>
                  </div>
                </td>
                <td class="px-6 py-4 text-center">
                  <div class="flex justify-center space-x-2">
                    <button @click="assignUsers(role)" class="p-2 bg-green-50 text-green-700 hover:bg-green-100 hover:text-green-900 rounded-lg transition-all duration-200 border border-green-200" title="Assign Users">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a4 4 0 11-8 0 4 4 0 018 0z" />
                      </svg>
                    </button>
                    <button @click="toggleRoleStatus(role)" class="p-2 bg-yellow-50 text-yellow-700 hover:bg-yellow-100 hover:text-yellow-900 rounded-lg transition-all duration-200 border border-yellow-200" title="Toggle Role Status">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H7a4 4 0 00-8 0v8a4 4 0 00-8 0zM12 14a4 4 0 11-8 0 4 4 0 018 0z" />
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
                Save Permissions
              </button>
              <button @click="resetPermissions" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition-colors">
                Reset
              </button>
            </div>
        </div>
      </div>
    </div>

    <!-- Role Creation/Edit Modal -->
    <div v-if="showRoleModal" class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm transition-all duration-300" @click="showRoleModal = false"></div>
        <div class="relative bg-white rounded-lg shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-100 opacity-100 dialog-content">
          <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-4 rounded-t-lg">
            <div class="flex items-center justify-between">
              <h3 class="text-lg font-semibold">
                {{ editingRole ? 'Edit Role' : 'Create New Role' }}
              </h3>
              <button @click="showRoleModal = false" class="text-white hover:text-gray-200 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>

          <div class="p-6 space-y-6">
            <!-- Role Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Role Name *</label>
                <input
                  v-model="newRole.name"
                  type="text"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white text-gray-900"
                  placeholder="Enter role name"
                >
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Role Slug *</label>
                <input
                  v-model="newRole.slug"
                  type="text"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white text-gray-900"
                  placeholder="role-slug"
                >
              </div>
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
              <textarea
                v-model="newRole.description"
                rows="3"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white text-gray-900"
                placeholder="Describe the role's responsibilities"
              ></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Role Type *</label>
                <select
                  v-model="newRole.type"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white text-gray-900"
                >
                  <option value="system">System</option>
                  <option value="custom">Custom</option>
                  <option value="default">Default</option>
                </select>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                <select
                  v-model="newRole.status"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white text-gray-900"
                >
                  <option value="active">Active</option>
                  <option value="inactive">Inactive</option>
                  <option value="pending">Pending</option>
                </select>
              </div>
            </div>

            <!-- Permissions Selection -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-3">Permissions</label>
              <div class="space-y-4 max-h-60 overflow-y-auto border rounded-lg p-4">
                <div v-for="category in permissionCategories" :key="category.name" class="space-y-2">
                  <h4 class="font-medium text-gray-900 text-sm">{{ category.name }}</h4>
                  <div class="grid grid-cols-2 gap-2">
                    <label v-for="permission in category.permissions" :key="permission" class="flex items-center space-x-2 text-sm">
                      <input
                        type="checkbox"
                        :value="permission"
                        v-model="newRole.permissions"
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                      >
                      <span class="text-gray-700">{{ permission.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) }}</span>
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Actions -->
          <div class="flex justify-end space-x-3 pt-6 border-t bg-gray-50 px-6 py-4 rounded-b-lg">
            <button
              @click="showRoleModal = false"
              class="px-6 py-3 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 hover:text-gray-900 transition-all duration-200 font-medium shadow-sm hover:shadow-md flex items-center"
            >
              <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              <span class="ml-2">Cancel</span>
            </button>
            <button
              @click="saveRole"
              class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition-all duration-200 font-medium shadow-md hover:shadow-lg transform hover:scale-105 flex items-center"
            >
              <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
              </svg>
              <span class="ml-2">{{ editingRole ? 'Update Role' : 'Create Role' }}</span>
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
    },
    
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
    
    createRole() {
      console.log('Creating new role')
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
      notification.info('Create Role', 'Opening role creation form.')
    },
    
    editRole(role) {
      console.log('Editing role:', role)
      this.editingRole = role
      this.newRole = { ...role }
      this.showRoleModal = true
      notification.info('Edit Role', `Editing role "${role.name}".`)
    },
    
    saveRole() {
      console.log('Saving role:', this.newRole)
      if (this.editingRole) {
        // Update existing role
        const index = this.roles.findIndex(r => r.id === this.editingRole.id)
        if (index !== -1) {
          this.roles[index] = { ...this.newRole, id: this.editingRole.id }
        }
        notification.success('Role Updated', `Role "${this.newRole.name}" has been updated successfully.`)
      } else {
        // Create new role
        const newRoleData = {
          ...this.newRole,
          id: Math.max(...this.roles.map(r => r.id)) + 1,
          userCount: 0,
          permissionCount: this.newRole.permissions.length
        }
        this.roles.push(newRoleData)
        notification.success('Role Created', `Role "${this.newRole.name}" has been created successfully.`)
      }
      this.showRoleModal = false
      this.editingRole = null
    },
    
    deleteRole(role) {
      if (confirm(`Are you sure you want to delete the role "${role.name}"? This action cannot be undone.`)) {
        this.roles = this.roles.filter(r => r.id !== role.id)
        notification.success('Role Deleted', `Role "${role.name}" has been deleted successfully.`)
      }
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
}
</script>

<style scoped>
/* Enhanced blur background effect */
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

/* Ensure modal content is not blurred and has proper visibility */
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

/* Enhanced modal backdrop */
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  z-index: 40;
  transition: all 0.3s ease;
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

/* Status badge styles */
.status-badge {
  padding: 0.25rem 0.5rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.status-active {
  background: linear-gradient(135deg, #10b981, #6366f1);
  color: white;
}

.status-inactive {
  background: #e5e7b7;
  color: white;
}

.status-pending {
  background: #f59e0b;
  color: white;
}

.status-suspended {
  background: #dc2626;
  color: white;
}

/* User count badge styles */
.user-count-badge {
  padding: 0.25rem 0.5rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.user-count-low {
  background: #10b981;
  color: white;
}

.user-count-medium {
  background: #05966d;
  color: white;
}

.user-count-high {
  background: #dc2626;
  color: white;
}

/* Permission count badge styles */
.perm-count-badge {
  padding: 0.25rem 0.5rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.perm-count-low {
  background: #10b981;
  color: white;
}

.perm-count-medium {
  background: #f59e0b;
  color: white;
}

.perm-count-high {
  background: #dc2626;
  color: white;
}

/* Role type styles */
.role-type-badge {
  padding: 0.25rem 0.5rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.role-type-system {
  background: #6366f1;
  color: white;
}

.role-type-custom {
  background: #3b82f6;
  color: white;
}

.role-type-default {
  background: #6b7281;
  color: white;
}

/* Hover effects */
.role-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* Responsive design */
@media (max-width: 768px) {
  .grid-cols-1 {
    grid-template-columns: 1fr;
  }
  
  .grid-cols-2 {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .grid-cols-3 {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (max-width: 1024px) {
  .grid-cols-1 {
    grid-template-columns: 1fr;
  }
  
  .grid-cols-2 {
    grid-template-columns: repeat(2, 1fr);
  }
}

/* Reduce motion for accessibility */
@media (prefers-reduced-motion: reduce) {
  .modal-enter-active,
  .modal-leave-active {
    transition: none;
  }
  
  .modal-enter-from,
  .modal-leave-to {
    transform: none;
    opacity: 0;
  }
}
</style>
