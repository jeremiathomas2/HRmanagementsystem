<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Leave;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    /**
     * Display a listing of leave requests.
     */
    public function index(Request $request): JsonResponse
    {
        $leaves = Leave::with(['employee', 'company'])
            ->when($request->employee_id, function ($query, $employeeId) {
                return $query->where('employee_id', $employeeId);
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->leave_type, function ($query, $leaveType) {
                return $query->where('leave_type', $leaveType);
            })
            ->latest('created_at')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $leaves
        ]);
    }

    /**
     * Store a newly created leave request.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'company_id' => 'required|exists:companies,id',
            'leave_type' => 'required|in:annual,sick,maternity,paternity,unpaid,compassionate,study',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_days' => 'required|integer|min:1',
            'reason' => 'required|string',
            'emergency_contact' => 'nullable|string',
            'emergency_phone' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
            'approved_by' => 'nullable|exists:users,id',
            'approved_at' => 'nullable|date',
            'available_balance' => 'required|integer|min:0',
            'accrual_rate' => 'required|numeric|min:0',
            'policy' => 'nullable|string',
            'compliance' => 'required|boolean',
        ]);

        // Check leave balance
        $employee = Employee::find($validated['employee_id']);
        $availableBalance = $this->getLeaveBalance($employee, $validated['leave_type']);

        if ($availableBalance < $validated['total_days']) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient leave balance'
            ], 400);
        }

        $leave = Leave::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Leave request submitted successfully',
            'data' => $leave
        ], 201);
    }

    /**
     * Display the specified leave request.
     */
    public function show(Leave $leave): JsonResponse
    {
        $leave->load(['employee', 'company', 'approver']);
        
        return response()->json([
            'success' => true,
            'data' => $leave
        ]);
    }

    /**
     * Update the specified leave request.
     */
    public function update(Request $request, Leave $leave): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'sometimes|required|in:pending,approved,rejected',
            'approved_by' => 'nullable|exists:users,id',
            'approved_at' => 'nullable|date',
            'rejection_reason' => 'nullable|string',
        ]);

        if (isset($validated['status']) && $validated['status'] === 'approved') {
            $validated['approved_by'] = Auth::id();
            $validated['approved_at'] = now();
        } elseif (isset($validated['status']) && $validated['status'] === 'rejected') {
            $validated['approved_by'] = Auth::id();
            $validated['approved_at'] = now();
            $validated['rejection_reason'] = $request->rejection_reason;
        }

        $leave->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Leave request updated successfully',
            'data' => $leave
        ]);
    }

    /**
     * Remove the specified leave request.
     */
    public function destroy(Leave $leave): JsonResponse
    {
        $leave->delete();

        return response()->json([
            'success' => true,
            'message' => 'Leave request deleted successfully'
        ]);
    }

    /**
     * Approve leave request.
     */
    public function approve(Request $request, Leave $leave): JsonResponse
    {
        $validated = $request->validate([
            'comments' => 'nullable|string',
        ]);

        $leave->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'comments' => $validated['comments'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Leave request approved successfully',
            'data' => $leave
        ]);
    }

    /**
     * Reject leave request.
     */
    public function reject(Request $request, Leave $leave): JsonResponse
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $leave->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Leave request rejected successfully',
            'data' => $leave
        ]);
    }

    /**
     * Get employee leave balance.
     */
    public function getBalance(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type' => 'required|in:annual,sick,maternity,paternity,unpaid,compassionate,study',
        ]);

        $employee = Employee::find($validated['employee_id']);
        $balance = $this->getLeaveBalance($employee, $validated['leave_type']);

        return response()->json([
            'success' => true,
            'data' => [
                'employee_id' => $validated['employee_id'],
                'leave_type' => $validated['leave_type'],
                'balance' => $balance,
                'used' => $this->getUsedLeave($employee, $validated['leave_type']),
                'available' => $balance - $this->getUsedLeave($employee, $validated['leave_type']),
            ]
        ]);
    }

    /**
     * Get leave analytics.
     */
    public function analytics(Request $request): JsonResponse
    {
        $period = $request->get('period', 'month'); // week, month, year

        $query = Leave::query();

        if ($period === 'week') {
            $query->whereBetween('created_at', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()]);
        } elseif ($period === 'month') {
            $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($period === 'year') {
            $query->whereYear('created_at', now()->year);
        }

        $analytics = [
            'total_requests' => $query->count(),
            'approved' => $query->where('status', 'approved')->count(),
            'rejected' => $query->where('status', 'rejected')->count(),
            'pending' => $query->where('status', 'pending')->count(),
            'by_type' => $query->selectRaw('leave_type, COUNT(*) as count')
                ->groupBy('leave_type')
                ->get(),
            'total_days_taken' => $query->where('status', 'approved')->sum('total_days'),
            'compliance_rate' => $query->where('compliance', true)->count() / max($query->count(), 1) * 100,
        ];

        return response()->json([
            'success' => true,
            'data' => $analytics
        ]);
    }

    /**
     * Get leave balance for employee.
     */
    private function getLeaveBalance(Employee $employee, string $leaveType): int
    {
        // Tanzanian leave policy calculations
        $baseBalances = [
            'annual' => 21, // 21 days per year
            'sick' => 90, // 90 days per year
            'maternity' => 84, // 12 weeks (84 days)
            'paternity' => 7, // 7 days
            'compassionate' => 7, // 7 days per occurrence
            'study' => 7, // 7 days per year
        ];

        return $baseBalances[$leaveType] ?? 0;
    }

    /**
     * Get used leave for employee.
     */
    private function getUsedLeave(Employee $employee, string $leaveType): int
    {
        return Leave::where('employee_id', $employee->id)
            ->where('leave_type', $leaveType)
            ->where('status', 'approved')
            ->whereYear('created_at', now()->year)
            ->sum('total_days');
    }
}
