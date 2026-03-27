@extends('layouts.app')

@section('title', 'Employee Contracts - Orvion HR System')

@section('content')
<div class="p-6">
    <!-- Header Section -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Employee Contracts</h1>
            <p class="text-gray-600 mt-2">Manage employment contracts and agreements with Tanzanian legal compliance</p>
        </div>
        <div class="flex space-x-2">
            <button onclick="openNewContractModal()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition-all duration-200 flex items-center shadow-md hover:shadow-lg transform hover:scale-105 font-semibold">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-2H4a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2z" />
                </svg>
                <span class="ml-2 font-medium">New Contract</span>
            </button>
            <button onclick="exportContracts()" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 active:bg-emerald-800 transition-all duration-200 flex items-center shadow-md hover:shadow-lg transform hover:scale-105 font-semibold">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 6-6m-6 6h6m-6 6h6M9 19v-6a3 3 0 00-6-6 3 3 0 006 6z" />
                </svg>
                <span class="ml-2 font-medium">Export</span>
            </button>
            <button onclick="generateBulkContracts()" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 active:bg-purple-800 transition-all duration-200 flex items-center shadow-md hover:shadow-lg transform hover:scale-105 font-semibold">
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
                    <p class="text-2xl font-semibold text-gray-900">{{ $contractStats['active'] ?? 0 }}</p>
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
                    <p class="text-sm font-medium text-gray-600">Expiring Soon</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $contractStats['expiring'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-full flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2 2m2 2l2 2m7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Expired</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $contractStats['expired'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Under Review</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $contractStats['review'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search Employee</label>
                <input type="text" id="searchEmployee" placeholder="Search by name or ID..." class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Contract Type</label>
                <select id="contractType" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">All Types</option>
                    <option value="permanent">Permanent</option>
                    <option value="probation">Probation</option>
                    <option value="contract">Contract</option>
                    <option value="casual">Casual</option>
                    <option value="intern">Intern</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select id="contractStatus" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="expired">Expired</option>
                    <option value="terminated">Terminated</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                <select id="department" class="w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">All Departments</option>
                    @foreach($departments ?? [] as $department)
                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="mt-4 flex justify-end space-x-2">
            <button onclick="clearFilters()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                Clear Filters
            </button>
            <button onclick="applyFilters()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                Apply Filters
            </button>
        </div>
    </div>

    <!-- Contracts Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Contracts List</h3>
            
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contract Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Salary</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Compliance</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($contracts ?? [] as $contract)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" src="{{ asset('images/default-avatar.png') }}" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $contract->employee->full_name }}</div>
                                            <div class="text-sm text-gray-500">{{ $contract->employee->employee_number }}</div>
                                            <div class="text-sm text-gray-500">{{ $contract->employee->department->name ?? 'No Department' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst($contract->contract_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div>{{ $contract->start_date->format('M d, Y') }}</div>
                                    @if($contract->end_date)
                                        <div class="text-gray-500">to {{ $contract->end_date->format('M d, Y') }}</div>
                                    @else
                                        <div class="text-gray-500">Permanent</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ number_format($contract->basic_salary, 0) }} TZS
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @switch($contract->status)
                                        @case('active')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                            @break
                                        @case('expired')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Expired</span>
                                            @break
                                        @case('terminated')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Terminated</span>
                                            @break
                                        @case('pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @break
                                        @default
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Unknown</span>
                                    @endswitch
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            @if($contract->compliance_score >= 80)
                                                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            @elseif($contract->compliance_score >= 60)
                                                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="ml-2">
                                            <div class="text-sm font-medium text-gray-900">{{ $contract->compliance_score ?? 0 }}%</div>
                                            <div class="text-xs text-gray-500">Compliance</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="viewContract({{ $contract->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">View</button>
                                    <button onclick="editContract({{ $contract->id }})" class="text-green-600 hover:text-green-900 mr-3">Edit</button>
                                    <button onclick="downloadContract({{ $contract->id }})" class="text-blue-600 hover:text-blue-900 mr-3">Download</button>
                                    <button onclick="terminateContract({{ $contract->id }})" class="text-red-600 hover:text-red-900">Terminate</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No contracts found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- New Contract Modal -->
    <div id="contractModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-4/5 max-w-4xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Create New Contract</h3>
                
                <form id="contractForm" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Employee</label>
                            <select name="employee_id" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                                <option value="">Select Employee</option>
                                @foreach($employees ?? [] as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->full_name }} - {{ $employee->employee_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Contract Type</label>
                            <select name="contract_type" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                                <option value="">Select Type</option>
                                <option value="permanent">Permanent</option>
                                <option value="probation">Probation</option>
                                <option value="contract">Contract</option>
                                <option value="casual">Casual</option>
                                <option value="intern">Intern</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                            <input type="date" name="start_date" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">End Date (if applicable)</label>
                            <input type="date" name="end_date" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Job Title</label>
                            <input type="text" name="job_title" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Basic Salary (TZS)</label>
                            <input type="number" name="basic_salary" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Job Description</label>
                        <textarea name="job_description" rows="4" class="w-full border border-gray-300 rounded-md px-3 py-2"></textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Working Hours</label>
                            <input type="text" name="working_hours" placeholder="e.g., 9:00 - 17:00" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Probation Period (months)</label>
                            <input type="number" name="probation_period" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notice Period (days)</label>
                            <input type="number" name="notice_period" class="w-full border border-gray-300 rounded-md px-3 py-2">
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeContractModal()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">
                            Cancel
                        </button>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                            Create Contract
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// JavaScript functions for contract management
function openNewContractModal() {
    document.getElementById('contractModal').classList.remove('hidden');
}

function closeContractModal() {
    document.getElementById('contractModal').classList.add('hidden');
    document.getElementById('contractForm').reset();
}

function viewContract(id) {
    window.location.href = `/contracts/${id}`;
}

function editContract(id) {
    window.location.href = `/contracts/${id}/edit`;
}

function downloadContract(id) {
    window.location.href = `/contracts/${id}/download`;
}

function terminateContract(id) {
    if (confirm('Are you sure you want to terminate this contract? This action cannot be undone.')) {
        // Implementation for contract termination
        fetch(`/contracts/${id}/terminate`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error terminating contract: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error terminating contract');
        });
    }
}

function exportContracts() {
    window.location.href = '/contracts/export';
}

function generateBulkContracts() {
    // Implementation for bulk contract generation
    alert('Bulk contract generation functionality would be implemented here');
}

function applyFilters() {
    const search = document.getElementById('searchEmployee').value;
    const type = document.getElementById('contractType').value;
    const status = document.getElementById('contractStatus').value;
    const department = document.getElementById('department').value;
    
    const params = new URLSearchParams();
    if (search) params.append('search', search);
    if (type) params.append('type', type);
    if (status) params.append('status', status);
    if (department) params.append('department', department);
    
    window.location.href = `/contracts?${params.toString()}`;
}

function clearFilters() {
    window.location.href = '/contracts';
}

// Form submission
document.getElementById('contractForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/contracts', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeContractModal();
            location.reload();
        } else {
            alert('Error creating contract: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error creating contract');
    });
});
</script>
@endsection
