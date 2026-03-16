<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Contract;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    /**
     * Display a listing of contracts.
     */
    public function index(Request $request): JsonResponse
    {
        $contracts = Contract::with(['employee', 'company'])
            ->when($request->employee_id, function ($query, $employeeId) {
                return $query->where('employee_id', $employeeId);
            })
            ->when($request->company_id, function ($query, $companyId) {
                return $query->where('company_id', $companyId);
            })
            ->latest('start_date')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $contracts
        ]);
    }

    /**
     * Store a newly created contract.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'company_id' => 'required|exists:companies,id',
            'contract_type' => 'required|in:fixed_term,indefinite,casual,probation',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'duration_months' => 'nullable|integer|min:1',
            'renewal_type' => 'nullable|in:automatic,manual,non_renewable',
            'job_title' => 'required|string|max:255',
            'job_description' => 'nullable|string',
            'department' => 'required|string|max:255',
            'basic_salary' => 'required|numeric|min:0',
            'allowances' => 'nullable|array',
            'benefits' => 'nullable|array',
            'payment_frequency' => 'required|in:weekly,bi_weekly,monthly',
            'notice_period_days' => 'required|integer|min:0',
            'leave_entitlement_days' => 'required|integer|min:0',
            'termination_conditions' => 'nullable|string',
            'compliance_status' => 'required|in:compliant,non_compliant,pending_review',
            'digital_signature' => 'nullable|string',
            'status' => 'required|in:active,expired,terminated',
        ]);

        $contract = Contract::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Contract created successfully',
            'data' => $contract
        ], 201);
    }

    /**
     * Display the specified contract.
     */
    public function show(Contract $contract): JsonResponse
    {
        $contract->load(['employee', 'company']);
        
        return response()->json([
            'success' => true,
            'data' => $contract
        ]);
    }

    /**
     * Update the specified contract.
     */
    public function update(Request $request, Contract $contract): JsonResponse
    {
        $validated = $request->validate([
            'contract_type' => 'sometimes|required|in:fixed_term,indefinite,casual,probation',
            'end_date' => 'nullable|date|after:start_date',
            'duration_months' => 'nullable|integer|min:1',
            'renewal_type' => 'nullable|in:automatic,manual,non_renewable',
            'job_title' => 'sometimes|required|string|max:255',
            'job_description' => 'nullable|string',
            'department' => 'sometimes|required|string|max:255',
            'basic_salary' => 'sometimes|required|numeric|min:0',
            'allowances' => 'nullable|array',
            'benefits' => 'nullable|array',
            'payment_frequency' => 'sometimes|required|in:weekly,bi_weekly,monthly',
            'notice_period_days' => 'sometimes|required|integer|min:0',
            'leave_entitlement_days' => 'sometimes|required|integer|min:0',
            'termination_conditions' => 'nullable|string',
            'compliance_status' => 'sometimes|required|in:compliant,non_compliant,pending_review',
            'digital_signature' => 'nullable|string',
            'status' => 'sometimes|required|in:active,expired,terminated',
        ]);

        $contract->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Contract updated successfully',
            'data' => $contract
        ]);
    }

    /**
     * Remove the specified contract.
     */
    public function destroy(Contract $contract): JsonResponse
    {
        $contract->delete();

        return response()->json([
            'success' => true,
            'message' => 'Contract deleted successfully'
        ]);
    }

    /**
     * Get contracts expiring soon.
     */
    public function expiringSoon(Request $request): JsonResponse
    {
        $days = $request->get('days', 30);
        
        $contracts = Contract::where('end_date', '<=', now()->addDays($days))
            ->where('end_date', '>', now())
            ->where('status', 'active')
            ->with(['employee', 'company'])
            ->orderBy('end_date')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $contracts
        ]);
    }

    /**
     * Get contract analytics.
     */
    public function analytics(Request $request): JsonResponse
    {
        $analytics = [
            'total_contracts' => Contract::count(),
            'active_contracts' => Contract::where('status', 'active')->count(),
            'expiring_contracts' => Contract::where('end_date', '<=', now()->addDays(30))
                ->where('end_date', '>', now())
                ->where('status', 'active')
                ->count(),
            'by_type' => Contract::selectRaw('contract_type, COUNT(*) as count')
                ->groupBy('contract_type')
                ->get(),
            'compliance_status' => Contract::selectRaw('compliance_status, COUNT(*) as count')
                ->groupBy('compliance_status')
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $analytics
        ]);
    }
}
