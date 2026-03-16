<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of attendance records.
     */
    public function index(Request $request): JsonResponse
    {
        $attendances = Attendance::with(['employee', 'company'])
            ->when($request->employee_id, function ($query, $employeeId) {
                return $query->where('employee_id', $employeeId);
            })
            ->when($request->date, function ($query, $date) {
                return $query->whereDate('date', $date);
            })
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                return $query->whereBetween('date', [$request->start_date, $request->end_date]);
            })
            ->latest('date')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $attendances
        ]);
    }

    /**
     * Store a newly created attendance record.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'company_id' => 'required|exists:companies,id',
            'date' => 'required|date',
            'clock_in' => 'required|date_format:H:i',
            'clock_out' => 'nullable|date_format:H:i|after:clock_in',
            'break_start' => 'nullable|date_format:H:i',
            'break_end' => 'nullable|date_format:H:i|after:break_start',
            'total_hours' => 'nullable|numeric|min:0',
            'overtime_hours' => 'nullable|numeric|min:0',
            'status' => 'required|in:present,absent,late,half_day',
            'reason' => 'nullable|string',
            'shift_type' => 'required|in:day,night,flexible',
            'biometric_data' => 'nullable|string',
            'location' => 'nullable|string',
            'ip_address' => 'nullable|string',
            'approval_status' => 'required|in:pending,approved,rejected',
            'compliance' => 'required|boolean',
        ]);

        // Calculate total hours if not provided
        if (empty($validated['total_hours']) && isset($validated['clock_out'])) {
            $clockIn = Carbon::parse($validated['clock_in']);
            $clockOut = Carbon::parse($validated['clock_out']);
            $validated['total_hours'] = $clockOut->diffInMinutes($clockIn) / 60;
        }

        $attendance = Attendance::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Attendance recorded successfully',
            'data' => $attendance
        ], 201);
    }

    /**
     * Display the specified attendance record.
     */
    public function show(Attendance $attendance): JsonResponse
    {
        $attendance->load(['employee', 'company']);
        
        return response()->json([
            'success' => true,
            'data' => $attendance
        ]);
    }

    /**
     * Update the specified attendance record.
     */
    public function update(Request $request, Attendance $attendance): JsonResponse
    {
        $validated = $request->validate([
            'clock_out' => 'nullable|date_format:H:i|after:clock_in',
            'break_start' => 'nullable|date_format:H:i',
            'break_end' => 'nullable|date_format:H:i|after:break_start',
            'total_hours' => 'nullable|numeric|min:0',
            'overtime_hours' => 'nullable|numeric|min:0',
            'status' => 'sometimes|required|in:present,absent,late,half_day',
            'reason' => 'nullable|string',
            'approval_status' => 'sometimes|required|in:pending,approved,rejected',
        ]);

        // Recalculate total hours if clock_out is updated
        if (isset($validated['clock_out']) && !isset($validated['total_hours'])) {
            $clockIn = Carbon::parse($attendance->clock_in);
            $clockOut = Carbon::parse($validated['clock_out']);
            $validated['total_hours'] = $clockOut->diffInMinutes($clockIn) / 60;
        }

        $attendance->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Attendance updated successfully',
            'data' => $attendance
        ]);
    }

    /**
     * Remove the specified attendance record.
     */
    public function destroy(Attendance $attendance): JsonResponse
    {
        $attendance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Attendance record deleted successfully'
        ]);
    }

    /**
     * Clock in employee.
     */
    public function clockIn(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'company_id' => 'required|exists:companies,id',
            'biometric_data' => 'nullable|string',
            'location' => 'nullable|string',
        ]);

        // Check if already clocked in today
        $existing = Attendance::where('employee_id', $validated['employee_id'])
            ->where('date', now()->toDateString())
            ->first();

        if ($existing && $existing->clock_in) {
            return response()->json([
                'success' => false,
                'message' => 'Already clocked in today'
            ], 400);
        }

        $attendance = Attendance::create([
            'employee_id' => $validated['employee_id'],
            'company_id' => $validated['company_id'],
            'date' => now()->toDateString(),
            'clock_in' => now()->toTimeString(),
            'status' => 'present',
            'shift_type' => 'day',
            'approval_status' => 'approved',
            'compliance' => true,
            'biometric_data' => $validated['biometric_data'],
            'location' => $validated['location'],
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Clocked in successfully',
            'data' => $attendance
        ]);
    }

    /**
     * Clock out employee.
     */
    public function clockOut(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        $attendance = Attendance::where('employee_id', $validated['employee_id'])
            ->where('date', now()->toDateString())
            ->whereNull('clock_out')
            ->first();

        if (!$attendance) {
            return response()->json([
                'success' => false,
                'message' => 'No active clock-in found'
            ], 400);
        }

        $clockOut = now();
        $clockIn = Carbon::parse($attendance->clock_in);
        $totalHours = $clockOut->diffInMinutes($clockIn) / 60;

        $attendance->update([
            'clock_out' => $clockOut->toTimeString(),
            'total_hours' => $totalHours,
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Clocked out successfully',
            'data' => $attendance
        ]);
    }

    /**
     * Get attendance analytics.
     */
    public function analytics(Request $request): JsonResponse
    {
        $date = $request->get('date', now()->toDateString());
        $period = $request->get('period', 'week'); // week, month, year

        $query = Attendance::query();

        if ($period === 'week') {
            $query->whereBetween('date', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()]);
        } elseif ($period === 'month') {
            $query->whereMonth('date', now()->month)->whereYear('date', now()->year);
        } elseif ($period === 'year') {
            $query->whereYear('date', now()->year);
        }

        $analytics = [
            'total_records' => $query->count(),
            'present' => $query->where('status', 'present')->count(),
            'absent' => $query->where('status', 'absent')->count(),
            'late' => $query->where('status', 'late')->count(),
            'average_hours' => $query->avg('total_hours'),
            'total_overtime' => $query->sum('overtime_hours'),
            'compliance_rate' => $query->where('compliance', true)->count() / max($query->count(), 1) * 100,
        ];

        return response()->json([
            'success' => true,
            'data' => $analytics
        ]);
    }
}
