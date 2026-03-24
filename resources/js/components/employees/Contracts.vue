<template>
  <div class="p-6">
    <!-- Header Section -->
    <div class="mb-6 flex justify-between items-center">
      <div>
        <h1 class="text-2xl font-bold text-gray-900">Employee Contracts</h1>
        <p class="text-gray-600 mt-2">Manage employment contracts and agreements with Tanzanian legal compliance</p>
      </div>
      <div class="flex space-x-2">
        <button @click="openNewContractModal" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition-all duration-200 flex items-center shadow-md hover:shadow-lg transform hover:scale-105 font-semibold">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-2H4a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2z" />
          </svg>
          <span class="ml-2 font-medium">New Contract</span>
        </button>
        <button @click="exportContracts" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 active:bg-emerald-800 transition-all duration-200 flex items-center shadow-md hover:shadow-lg transform hover:scale-105 font-semibold">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 6-6m-6 6h6m-6 6h6M9 19v-6a3 3 0 00-6-6 3 3 0 006 6z" />
          </svg>
          <span class="ml-2 font-medium">Export</span>
        </button>
        <button @click="generateBulkContracts" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 active:bg-purple-800 transition-all duration-200 flex items-center shadow-md hover:shadow-lg transform hover:scale-105 font-semibold">
          <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 0h6m2 6H9m9 6V9m0 6v6m0-6h6m-6 0h6M9 3H5a2 2 0 00-2 2v4a2 2 0 002 2h4a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2z" />
          </svg>
          <span class="ml-2 font-medium">Bulk Generate</span>
        </button>
      </div>
    </div>

    <!-- Contract Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-green-100 rounded-full flex-shrink-0">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Active Contracts</p>
            <p class="text-2xl font-semibold text-gray-900">{{ contractStats.active }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-yellow-100 rounded-full flex-shrink-0">
            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Expiring (30 days)</p>
            <p class="text-2xl font-semibold text-gray-900">{{ contractStats.expiring }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-blue-100 rounded-full flex-shrink-0">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Under Review</p>
            <p class="text-2xl font-semibold text-gray-900">{{ contractStats.review }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-red-100 rounded-full flex-shrink-0">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0L4 14l4-4m0 0l-4 4m2 2v6" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Expired</p>
            <p class="text-2xl font-semibold text-gray-900">{{ contractStats.expired }}</p>
          </div>
        </div>
      </div>

      <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex items-center">
          <div class="p-3 bg-purple-100 rounded-full flex-shrink-0">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2z" />
            </svg>
          </div>
          <div class="ml-4">
            <p class="text-sm font-medium text-gray-600">Total Contracts</p>
            <p class="text-2xl font-semibold text-gray-900">{{ contractStats.total }}</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Advanced Filters and Search -->
    <div class="bg-white rounded-lg shadow mb-6">
      <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex flex-wrap gap-4 items-center justify-between">
          <div class="flex items-center space-x-4">
            <!-- Search -->
            <div class="relative">
              <input
                type="text"
                v-model="searchQuery"
                placeholder="Search contracts..."
                class="w-64 px-3 py-2 pl-10 pr-4 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
              >
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>

            <!-- Status Filter -->
            <select v-model="statusFilter" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">All Status</option>
              <option value="active">Active</option>
              <option value="expiring">Expiring</option>
              <option value="review">Under Review</option>
              <option value="expired">Expired</option>
            </select>

            <!-- Contract Type Filter -->
            <select v-model="contractTypeFilter" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">All Types</option>
              <option value="permanent">Permanent</option>
              <option value="fixed_term">Fixed Term</option>
              <option value="probation">Probation</option>
              <option value="casual">Casual</option>
              <option value="internship">Internship</option>
            </select>

            <!-- Department Filter -->
            <select v-model="departmentFilter" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">All Departments</option>
              <option v-for="dept in departments" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
            </select>
          </div>

          <div class="flex items-center space-x-2">
            <!-- Date Filter -->
            <input
              type="date"
              v-model="dateFromFilter"
              placeholder="Filter by Date"
              class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white text-gray-900 placeholder-gray-500"
            >

            <!-- Clear Filters -->
            <button @click="clearFilters" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 active:bg-gray-800 transition-all duration-200 font-medium shadow-md hover:shadow-lg transform hover:scale-105 flex items-center">
              <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v2H4zM4 12h16v2H4zM4 20h16v2H4z" />
              </svg>
              <span class="ml-2">Clear</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Contracts Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
              <!-- Employee Column -->
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50 sticky top-0 z-10 border-r border-gray-200">
                <div class="flex items-center justify-between">
                  <div class="flex items-center space-x-3">
                    <input
                      type="checkbox"
                      @change="toggleSelectAll"
                      :checked="allSelected"
                      class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-2 focus:ring-indigo-500 focus:ring-offset-0"
                    >
                    <span class="text-gray-900">Employee</span>
                  </div>
                  <button @click="sortContracts('employee_name')" class="p-1.5 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded transition-colors" title="Sort by Employee">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l-4 4m4-4v12" />
                    </svg>
                  </button>
                </div>
              </th>

              <!-- Contract Type Column -->
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50 sticky top-0 z-10 border-r border-gray-200">
                <div class="flex items-center justify-between">
                  <span class="text-gray-900">Contract Type</span>
                  <button @click="sortContracts('contract_type')" class="p-1.5 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded transition-colors" title="Sort by Contract Type">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l-4 4m4-4v12" />
                    </svg>
                  </button>
                </div>
              </th>

              <!-- Start Date Column -->
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50 sticky top-0 z-10 border-r border-gray-200">
                <div class="flex items-center justify-between">
                  <span class="text-gray-900">Start Date</span>
                  <button @click="sortContracts('start_date')" class="p-1.5 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded transition-colors" title="Sort by Start Date">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l-4 4m4-4v12" />
                    </svg>
                  </button>
                </div>
              </th>

              <!-- End Date Column -->
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50 sticky top-0 z-10 border-r border-gray-200">
                <div class="flex items-center justify-between">
                  <span class="text-gray-900">End Date</span>
                  <button @click="sortContracts('end_date')" class="p-1.5 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded transition-colors" title="Sort by End Date">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l-4 4m4-4v12" />
                    </svg>
                  </button>
                </div>
              </th>

              <!-- Salary Column -->
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50 sticky top-0 z-10 border-r border-gray-200">
                <div class="flex items-center justify-between">
                  <span class="text-gray-900">Salary</span>
                  <button @click="sortContracts('salary')" class="p-1.5 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded transition-colors" title="Sort by Salary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l-4 4m4-4v12" />
                    </svg>
                  </button>
                </div>
              </th>

              <!-- Status Column -->
              <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50 sticky top-0 z-10 border-r border-gray-200">
                <span class="text-gray-900">Status</span>
              </th>

              <!-- Actions Column -->
              <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider bg-gray-50 sticky top-0 z-10">
                <span class="text-gray-900">Actions</span>
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="contract in filteredContracts" :key="contract.id" class="hover:bg-gray-50 transition-colors border-b border-gray-100">
              <!-- Employee Cell -->
              <td class="px-6 py-4 whitespace-nowrap border-r border-gray-100">
                <div class="flex items-center space-x-3">
                  <input
                    type="checkbox"
                    :value="contract.id"
                    v-model="selectedContracts"
                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-2 focus:ring-indigo-500"
                  >
                  <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                      <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                        <span class="text-xs font-medium text-white">{{ contract.employee_name.charAt(0) }}{{ contract.employee_name.split(' ')[1]?.charAt(0) || '' }}</span>
                      </div>
                    </div>
                    <div>
                      <div class="text-sm font-medium text-gray-900">{{ contract.employee_name }}</div>
                      <div class="text-xs text-gray-500">{{ contract.employee_number }}</div>
                    </div>
                  </div>
                </div>
              </td>

              <!-- Contract Type Cell -->
              <td class="px-6 py-4 whitespace-nowrap border-r border-gray-100">
                <span :class="getContractTypeClass(contract.contract_type)" class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full">
                  {{ contract.contract_type }}
                </span>
              </td>

              <!-- Start Date Cell -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium border-r border-gray-100">
                {{ formatDate(contract.start_date) }}
              </td>

              <!-- End Date Cell -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium border-r border-gray-100">
                {{ formatDate(contract.end_date) }}
              </td>

              <!-- Salary Cell -->
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium border-r border-gray-100">
                <div class="flex items-center space-x-2">
                  <span class="font-semibold">{{ formatCurrency(contract.salary) }}</span>
                  <span class="text-xs text-gray-500">/month</span>
                </div>
              </td>

              <!-- Status Cell -->
              <td class="px-6 py-4 whitespace-nowrap border-r border-gray-100">
                <span :class="getStatusClass(contract.status)" class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full">
                  {{ contract.status }}
                </span>
              </td>

              <!-- Actions Cell -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center justify-center space-x-2">
                  <button @click="viewContract(contract)" class="icon-button bg-indigo-50 text-indigo-700 hover:bg-indigo-100 hover:text-indigo-900 hover:shadow-md transition-all duration-200 border border-indigo-200 rounded-lg font-medium flex items-center" title="View Contract">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                  </button>
                  <button @click="editContract(contract)" class="icon-button bg-blue-50 text-blue-700 hover:bg-blue-100 hover:text-blue-900 hover:shadow-md transition-all duration-200 border border-blue-200 rounded-lg font-medium flex items-center" title="Edit Contract">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </button>
                  <button @click="downloadContract(contract)" class="icon-button bg-emerald-50 text-emerald-700 hover:bg-emerald-100 hover:text-emerald-900 hover:shadow-md transition-all duration-200 border border-emerald-200 rounded-lg font-medium flex items-center" title="Download Contract">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                  </button>
                  <button @click="deleteContract(contract)" class="icon-button bg-red-50 text-red-700 hover:bg-red-100 hover:text-red-900 hover:shadow-md transition-all duration-200 border border-red-200 rounded-lg font-medium flex items-center" title="Delete Contract">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        <div class="flex items-center justify-between">
          <div class="text-sm text-gray-700">
            Showing {{ (currentPage - 1) * perPage + 1 }} to {{ Math.min(currentPage * perPage, totalContracts) }} of {{ totalContracts }} contracts
          </div>
          <div class="flex items-center space-x-2">
            <button
              @click="currentPage > 1 && (currentPage--)"
              :disabled="currentPage === 1"
              class="px-4 py-2 text-sm font-medium bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 shadow-sm hover:shadow-md flex items-center"
            >
              <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
              </svg>
              <span class="ml-2">Previous</span>
            </button>
            <div class="flex space-x-1">
              <button
                v-for="page in visiblePages"
                :key="page"
                @click="currentPage = page"
                :class="{ 
                  'bg-indigo-600 text-white shadow-md hover:bg-indigo-700': page === currentPage, 
                  'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 hover:shadow-sm': page !== currentPage 
                }"
                class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200 flex items-center justify-center"
              >
                {{ page }}
              </button>
            </div>
            <button
              @click="currentPage < totalPages && (currentPage++)"
              :disabled="currentPage === totalPages"
              class="px-4 py-2 text-sm font-medium bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 shadow-sm hover:shadow-md flex items-center"
            >
              <span class="mr-2">Next</span>
              <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- View Contract Dialog -->
    <div v-if="showViewDialog" class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm transition-all duration-300" @click="closeViewDialog"></div>
        <div class="relative bg-white rounded-lg shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-100 opacity-100 dialog-content">
          <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-4 rounded-t-lg">
            <div class="flex items-center justify-between">
              <h3 class="text-lg font-semibold">Contract Details</h3>
              <button @click="closeViewDialog" class="text-white hover:text-gray-200 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>

          <div class="p-6 space-y-6">
            <!-- Contract Header Info -->
            <div class="bg-gray-50 rounded-lg p-4">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-600">Employee</label>
                  <p class="text-lg font-semibold text-gray-900">{{ selectedContract?.employee_name }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-600">Contract Type</label>
                  <p class="text-lg font-semibold text-gray-900">{{ selectedContract?.contract_type }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-600">Start Date</label>
                  <p class="text-lg font-semibold text-gray-900">{{ formatDate(selectedContract?.start_date) }}</p>
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-600">End Date</label>
                  <p class="text-lg font-semibold text-gray-900">{{ formatDate(selectedContract?.end_date) }}</p>
                </div>
              </div>
            </div>

            <!-- Contract Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-600">Salary</label>
                <p class="text-lg font-semibold text-gray-900">{{ formatCurrency(selectedContract?.salary) }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600">Status</label>
                <span :class="getStatusClass(selectedContract?.status)" class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full">
                  {{ selectedContract?.status }}
                </span>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600">Department</label>
                <p class="text-lg font-semibold text-gray-900">{{ selectedContract?.department }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600">Position</label>
                <p class="text-lg font-semibold text-gray-900">{{ selectedContract?.position || 'Not specified' }}</p>
              </div>
            </div>

            <!-- Contract Terms -->
            <div>
              <label class="block text-sm font-medium text-gray-600 mb-2">Contract Terms</label>
              <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-gray-700">{{ selectedContract?.terms || 'Standard employment terms as per Tanzanian labor laws.' }}</p>
              </div>
            </div>

            <!-- Signature Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-600">Signed By</label>
                <p class="text-lg font-semibold text-gray-900">{{ selectedContract?.signed_by || 'Not signed' }}</p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-600">Signature Date</label>
                <p class="text-lg font-semibold text-gray-900">{{ formatDate(selectedContract?.signature_date) || 'Not signed' }}</p>
              </div>
            </div>
          </div>

          <!-- Dialog Actions -->
          <div class="flex justify-end space-x-3 pt-6 border-t bg-gray-50 px-6 py-4 rounded-b-lg">
            <button
              @click="closeViewDialog"
              class="px-6 py-3 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 hover:text-gray-900 transition-all duration-200 font-medium shadow-sm hover:shadow-md flex items-center"
            >
              <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
              <span class="ml-2">Close</span>
            </button>
            <button
              @click="downloadContract(selectedContract)"
              class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 active:bg-emerald-800 transition-all duration-200 font-medium shadow-md hover:shadow-lg transform hover:scale-105 flex items-center"
            >
              <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              <span class="ml-2">Download</span>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- New/Edit Contract Modal -->
    <div v-if="showContractModal" class="fixed inset-0 z-50 overflow-y-auto">
      <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm transition-all duration-300" @click="closeContractModal"></div>
        <div class="relative bg-white rounded-lg shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto transform transition-all duration-300 scale-100 opacity-100 dialog-content">
          <div class="bg-gradient-to-r from-indigo-600 to-blue-600 text-white px-6 py-4 rounded-t-lg">
            <div class="flex items-center justify-between">
              <h3 class="text-lg font-semibold">
                {{ editingContract ? 'Edit Contract' : 'New Contract' }}
              </h3>
              <button @click="closeContractModal" class="text-white hover:text-gray-200 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </div>

          <form @submit.prevent="saveContract" class="p-6 space-y-6">
            <!-- Employee Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Employee *</label>
                <select v-model="contractForm.employee_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                  <option value="">Select Employee</option>
                  <option v-for="employee in employees" :key="employee.id" :value="employee.id">
                    {{ employee.first_name }} {{ employee.last_name }} - {{ employee.employee_number }}
                  </option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Contract Type *</label>
                <select v-model="contractForm.contract_type" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                  <option value="">Select Type</option>
                  <option value="permanent">Permanent</option>
                  <option value="fixed_term">Fixed Term</option>
                  <option value="probation">Probation</option>
                  <option value="casual">Casual</option>
                  <option value="internship">Internship</option>
                </select>
              </div>
            </div>

            <!-- Contract Dates -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date *</label>
                <input
                  type="date"
                  v-model="contractForm.start_date"
                  required
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                <input
                  type="date"
                  v-model="contractForm.end_date"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Leave empty for permanent contracts</p>
              </div>
            </div>

            <!-- Salary and Benefits -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Monthly Salary (TZS)</label>
                <input
                  type="number"
                  v-model="contractForm.salary"
                  required
                  step="0.01"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Work Permit Number</label>
                <input
                  type="text"
                  v-model="contractForm.work_permit_number"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
              </div>
            </div>

            <!-- Tanzanian Compliance Fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">NSSF Number</label>
                <input
                  type="text"
                  v-model="contractForm.nssf_number"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tax Identification Number</label>
                <input
                  type="text"
                  v-model="contractForm.tin_number"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                >
              </div>
            </div>

            <!-- Status and Department -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                <select v-model="contractForm.status" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                  <option value="">Select Status</option>
                  <option value="draft">Draft</option>
                  <option value="active">Active</option>
                  <option value="expiring">Expiring</option>
                  <option value="expired">Expired</option>
                  <option value="terminated">Terminated</option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                <select v-model="contractForm.department_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                  <option value="">Select Department</option>
                  <option v-for="dept in departments" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
                </select>
              </div>
            </div>

            <!-- Notes and Attachments -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">Contract Notes</label>
              <textarea
                v-model="contractForm.notes"
                rows="4"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                placeholder="Enter any additional contract notes..."
              ></textarea>
            </div>

            <!-- Digital Signature -->
            <div class="border-t pt-6">
              <h4 class="text-lg font-medium text-gray-900 mb-4">Digital Signature</h4>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Signed By</label>
                  <input
                    type="text"
                    v-model="contractForm.signed_by"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="Enter signer name and title"
                  >
                </div>

                <div>
                  <label class="block text-sm font-medium text-gray-700 mb-2">Signature Date</label>
                  <input
                    type="date"
                    v-model="contractForm.signature_date"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                  >
                </div>
              </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 pt-6 border-t">
              <button
                type="button"
                @click="closeContractModal"
                class="px-6 py-3 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 hover:text-gray-900 transition-all duration-200 font-medium shadow-sm hover:shadow-md flex items-center"
              >
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span class="ml-2">Cancel</span>
              </button>
              <button
                type="submit"
                :disabled="saving"
                class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 active:bg-indigo-800 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 font-medium shadow-md hover:shadow-lg transform hover:scale-105 flex items-center"
              >
                <span v-if="!saving" class="flex items-center">
                  <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m0 0l-4 4m2 2v6" />
                  </svg>
                  <span class="ml-2">{{ editingContract ? 'Update Contract' : 'Create Contract' }}</span>
                </span>
                <span v-else class="flex items-center">
                  <svg class="animate-spin h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  <span class="ml-2 font-medium">Saving...</span>
                </span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import notification from '../../utils/notification.js'

export default {
  name: 'EmployeeContracts',
  data() {
    return {
      showContractModal: false,
      showViewDialog: false,
      selectedContract: null,
      editingContract: null,
      saving: false,
      searchQuery: '',
      statusFilter: '',
      contractTypeFilter: '',
      departmentFilter: '',
      dateFromFilter: '',
      sortField: 'created_at',
      sortDirection: 'desc',
      currentPage: 1,
      perPage: 10,
      selectedContracts: [],
      allSelected: false,
      contractForm: {
        employee_id: '',
        contract_type: '',
        start_date: '',
        end_date: '',
        salary: '',
        work_permit_number: '',
        nssf_number: '',
        tin_number: '',
        status: 'draft',
        department_id: '',
        notes: '',
        signed_by: '',
        signature_date: ''
      },
      contracts: [
        {
          id: 1,
          employee_id: 1,
          employee_name: 'John Doe',
          employee_number: 'EMP001',
          contract_type: 'Permanent',
          start_date: '2023-01-15',
          end_date: null,
          salary: 2500000,
          status: 'active',
          department_id: 1
        },
        {
          id: 2,
          employee_id: 2,
          employee_name: 'Jane Smith',
          employee_number: 'EMP002',
          contract_type: 'Fixed Term',
          start_date: '2024-01-01',
          end_date: '2024-12-31',
          salary: 1800000,
          status: 'expiring',
          department_id: 2
        },
        {
          id: 3,
          employee_id: 3,
          employee_name: 'Michael Brown',
          employee_number: 'EMP003',
          contract_type: 'Probation',
          start_date: '2024-02-01',
          end_date: '2024-05-01',
          salary: 1500000,
          status: 'review',
          department_id: 3
        }
      ],
      employees: [
        { id: 1, first_name: 'John', last_name: 'Doe', employee_number: 'EMP001' },
        { id: 2, first_name: 'Jane', last_name: 'Smith', employee_number: 'EMP002' },
        { id: 3, first_name: 'Michael', last_name: 'Brown', employee_number: 'EMP003' }
      ],
      departments: [
        { id: 1, name: 'Engineering' },
        { id: 2, name: 'Human Resources' },
        { id: 3, name: 'Finance' },
        { id: 4, name: 'Operations' }
      ]
    }
  },
  computed: {
    filteredContracts() {
      let filtered = this.contracts
      
      // Apply search filter
      if (this.searchQuery) {
        filtered = filtered.filter(contract => 
          contract.employee_name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          contract.employee_number.toLowerCase().includes(this.searchQuery.toLowerCase())
        )
      }
      
      // Apply status filter
      if (this.statusFilter) {
        filtered = filtered.filter(contract => contract.status === this.statusFilter)
      }
      
      // Apply contract type filter
      if (this.contractTypeFilter) {
        filtered = filtered.filter(contract => contract.contract_type === this.contractTypeFilter)
      }
      
      // Apply department filter
      if (this.departmentFilter) {
        filtered = filtered.filter(contract => contract.department_id === this.departmentFilter)
      }
      
      // Apply date filter
      if (this.dateFromFilter) {
        filtered = filtered.filter(contract => {
          const contractDate = new Date(contract.start_date)
          const filterDate = new Date(this.dateFromFilter)
          return contractDate.toDateString() === filterDate.toDateString()
        })
      }
      
      // Apply sorting
      filtered.sort((a, b) => {
        let modifier = 1
        if (this.sortDirection === 'desc') modifier = -1
        
        if (a[this.sortField] < b[this.sortField]) return -1 * modifier
        if (a[this.sortField] > b[this.sortField]) return 1 * modifier
        return 0
      })
      
      return filtered
    },
    
    contractStats() {
      return {
        active: this.contracts.filter(c => c.status === 'active').length,
        expiring: this.contracts.filter(c => c.status === 'expiring').length,
        review: this.contracts.filter(c => c.status === 'review').length,
        expired: this.contracts.filter(c => c.status === 'expired').length,
        total: this.contracts.length
      }
    },
    
    totalContracts() {
      return this.filteredContracts.length
    },
    
    totalPages() {
      return Math.ceil(this.totalContracts / this.perPage)
    },
    
    visiblePages() {
      let start = Math.max(1, this.currentPage - 2)
      let end = Math.min(this.totalPages, this.currentPage + 2)
      let pages = []
      for (let i = start; i <= end; i++) {
        pages.push(i)
      }
      return pages
    }
  },
  methods: {
    openNewContractModal() {
      this.editingContract = null
      this.contractForm = {
        employee_id: '',
        contract_type: '',
        start_date: '',
        end_date: '',
        salary: '',
        work_permit_number: '',
        nssf_number: '',
        tin_number: '',
        status: 'draft',
        department_id: '',
        notes: '',
        signed_by: '',
        signature_date: ''
      }
      this.showContractModal = true
    },
    
    editContract(contract) {
      this.editingContract = contract
      this.contractForm = { ...contract }
      this.showContractModal = true
    },
    
    closeContractModal() {
      this.showContractModal = false
      this.editingContract = null
      this.saving = false
    },
    
    async saveContract() {
      this.saving = true
      
      try {
        if (this.editingContract) {
          // Update existing contract
          const index = this.contracts.findIndex(c => c.id === this.editingContract.id)
          if (index !== -1) {
            this.contracts[index] = { ...this.contractForm, id: this.editingContract.id }
          }
          notification.success('Contract Updated', 'Employment contract has been updated successfully.')
        } else {
          // Create new contract
          const newContract = {
            ...this.contractForm,
            id: Date.now(),
            created_at: new Date().toISOString()
          }
          this.contracts.unshift(newContract)
          notification.success('Contract Created', 'New employment contract has been created successfully.')
        }
        
        this.closeContractModal()
      } catch (error) {
        notification.error('Error', 'Failed to save contract. Please try again.')
        console.error('Contract save error:', error)
      } finally {
        this.saving = false
      }
    },
    
    deleteContract(contract) {
      if (confirm(`Are you sure you want to delete the contract for ${contract.employee_name}? This action cannot be undone.`)) {
        this.contracts = this.contracts.filter(c => c.id !== contract.id)
        notification.success('Contract Deleted', `Contract for ${contract.employee_name} has been deleted.`)
      }
    },
    
    viewContract(contract) {
      this.selectedContract = contract
      this.showViewDialog = true
    },
    
    closeViewDialog() {
      this.showViewDialog = false
      this.selectedContract = null
    },
    
    downloadContract(contract) {
      notification.info('Download Contract', `Downloading contract for ${contract.employee_name}.`)
      console.log('Download contract:', contract)
    },
    
    exportContracts() {
      notification.info('Export Contracts', 'Exporting contract data to Excel...')
      console.log('Export contracts')
    },
    
    generateBulkContracts() {
      notification.info('Bulk Generation', 'Generating bulk contracts for selected employees...')
      console.log('Generate bulk contracts')
    },
    
    clearFilters() {
      this.searchQuery = ''
      this.statusFilter = ''
      this.contractTypeFilter = ''
      this.departmentFilter = ''
      this.dateFromFilter = ''
    },
    
    sortContracts(field) {
      if (this.sortField === field) {
        this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc'
      } else {
        this.sortField = field
        this.sortDirection = 'asc'
      }
    },
    
    toggleSelectAll() {
      this.allSelected = !this.allSelected
      if (this.allSelected) {
        this.selectedContracts = this.filteredContracts.map(c => c.id)
      } else {
        this.selectedContracts = []
      }
    },
    
    getContractTypeClass(type) {
      const classes = {
        permanent: 'bg-green-100 text-green-800',
        fixed_term: 'bg-blue-100 text-blue-800',
        probation: 'bg-yellow-100 text-yellow-800',
        casual: 'bg-gray-100 text-gray-800',
        internship: 'bg-purple-100 text-purple-800'
      }
      return classes[type] || 'bg-gray-100 text-gray-800'
    },
    
    getStatusClass(status) {
      const classes = {
        active: 'bg-green-100 text-green-800',
        expiring: 'bg-yellow-100 text-yellow-800',
        review: 'bg-blue-100 text-blue-800',
        expired: 'bg-red-100 text-red-800',
        terminated: 'bg-gray-100 text-gray-800',
        draft: 'bg-gray-100 text-gray-800'
      }
      return classes[status] || 'bg-gray-100 text-gray-800'
    },
    
    formatDate(dateString) {
      if (!dateString) return 'N/A'
      const date = new Date(dateString)
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      })
    },
    
    formatCurrency(amount) {
      return new Intl.NumberFormat('en-TZ', {
        style: 'currency',
        currency: 'TZS'
      }).format(amount)
    }
  }
}
</script>

<style scoped>
/* Icon styles */
.icon-button {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0.5rem;
  border-radius: 0.375rem;
  background-color: transparent;
  border: 1px solid transparent;
  transition: all 0.2s ease-in-out;
  min-width: 2rem;
  min-height: 2rem;
}

.icon-button:hover {
  background-color: rgba(99, 102, 241, 0.05);
  transform: scale(1.05);
}

.icon-button svg {
  width: 1.25rem;
  height: 1.25rem;
  flex-shrink: 0;
  color: currentColor;
  stroke-width: 2;
}

/* Ensure all icons are visible */
svg {
  display: block;
  width: 1rem;
  height: 1rem;
  flex-shrink: 0;
  color: currentColor;
  stroke-width: 2;
}

/* Enhanced Modal animations with blur effects */
.modal-enter-active,
.modal-leave-active {
  transition: all 0.3s ease;
}

.modal-enter-from {
  opacity: 0;
  transform: scale(0.9) translateY(-20px);
  backdrop-filter: blur(0px);
}

.modal-leave-to {
  opacity: 0;
  transform: scale(0.9) translateY(-20px);
  backdrop-filter: blur(0px);
}

/* Enhanced backdrop blur */
.backdrop-blur-sm {
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
}

.backdrop-blur-md {
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
}

/* Dialog content blur prevention */
.dialog-content {
  backdrop-filter: none;
  -webkit-backdrop-filter: none;
}

/* Enhanced modal shadow */
.modal-shadow {
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25),
              0 0 0 1px rgba(0, 0, 0, 0.1);
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

.status-expiring {
  background: linear-gradient(135deg, #f59e0b, #d97706);
  color: white;
}

.status-review {
  background: linear-gradient(135deg, #3b82f6, #1e40af);
  color: white;
}

.status-expired {
  background: linear-gradient(135deg, #dc2626, #991b1b);
  color: white;
}

.status-terminated {
  background: linear-gradient(135deg, #6b7281, #374151);
  color: white;
}

.status-draft {
  background: linear-gradient(135deg, #6b7281, #374151);
  color: white;
}

/* Contract type styles */
.contract-type-badge {
  padding: 0.25rem 0.5rem;
  border-radius: 9999px;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.contract-type-permanent {
  background: #10b981;
  color: white;
}

.contract-type-fixed_term {
  background: #3b82f6;
  color: white;
}

.contract-type-probation {
  background: #f59e0b;
  color: white;
}

.contract-type-casual {
  background: #6b7281;
  color: white;
}

.contract-type-internship {
  background: #8b5cf6;
  color: white;
}

/* Hover effects */
tr:hover {
  background-color: #f9fafb;
}

/* Responsive design */
@media (max-width: 768px) {
  .grid-cols-2 {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .grid-cols-4 {
    grid-template-columns: repeat(4, 1fr);
  }
}

@media (max-width: 1024px) {
  .grid-cols-4 {
    grid-template-columns: repeat(2, 1fr);
  }
}

/* Table improvements */
table {
  border-collapse: separate;
  border-spacing: 0;
}

th {
  position: sticky;
  top: 0;
  z-index: 10;
}

/* Loading spinner */
@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}
</style>
