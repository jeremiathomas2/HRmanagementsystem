<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Performance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PerformanceController extends Controller
{
    /**
     * Display a listing of performance records.
     */
    public function index(Request $request): JsonResponse
    {
        $performances = Performance::with(['employee', 'reviewer'])
            ->when($request->employee_id, function ($query, $employeeId) {
                return $query->where('employee_id', $employeeId);
            })
            ->when($request->evaluation_period, function ($query, $period) {
                return $query->where('evaluation_period', $period);
            })
            ->latest('evaluation_date')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $performances
        ]);
    }

    /**
     * Store a newly created performance record.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'reviewer_id' => 'required|exists:users,id',
            'evaluation_period' => 'required|in:quarterly,semi_annual,annual',
            'evaluation_date' => 'required|date',
            'overall_rating' => 'required|integer|min:1|max:5',
            'goals_achieved' => 'required|integer|min:0|max:100',
            'technical_skills' => 'required|integer|min:1|max:5',
            'communication_skills' => 'required|integer|min:1|max:5',
            'teamwork' => 'required|integer|min:1|max:5',
            'leadership' => 'nullable|integer|min:1|max:5',
            'problem_solving' => 'required|integer|min:1|max:5',
            'time_management' => 'required|integer|min:1|max:5',
            'attendance' => 'required|integer|min:1|max:5',
            'quality_of_work' => 'required|integer|min:1|max:5',
            'initiative' => 'required|integer|min:1|max:5',
            'strengths' => 'nullable|array',
            'areas_for_improvement' => 'nullable|array',
            'comments' => 'required|string',
            'development_plan' => 'nullable|string',
            'promotion_recommendation' => 'nullable|in:promote,ready_soon,not_ready,no',
            'salary_recommendation' => 'nullable|numeric|min:0',
            'status' => 'required|in:draft,submitted,approved,rejected',
        ]);

        $performance = Performance::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Performance evaluation created successfully',
            'data' => $performance
        ], 201);
    }

    /**
     * Display the specified performance record.
     */
    public function show(Performance $performance): JsonResponse
    {
        $performance->load(['employee', 'reviewer']);
        
        return response()->json([
            'success' => true,
            'data' => $performance
        ]);
    }

    /**
     * Update the specified performance record.
     */
    public function update(Request $request, Performance $performance): JsonResponse
    {
        $validated = $request->validate([
            'overall_rating' => 'sometimes|required|integer|min:1|max:5',
            'goals_achieved' => 'sometimes|required|integer|min:0|max:100',
            'technical_skills' => 'sometimes|required|integer|min:1|max:5',
            'communication_skills' => 'sometimes|required|integer|min:1|max:5',
            'teamwork' => 'sometimes|required|integer|min:1|max:5',
            'leadership' => 'nullable|integer|min:1|max:5',
            'problem_solving' => 'sometimes|required|integer|min:1|max:5',
            'time_management' => 'sometimes|required|integer|min:1|max:5',
            'attendance' => 'sometimes|required|integer|min:1|max:5',
            'quality_of_work' => 'sometimes|required|integer|min:1|max:5',
            'initiative' => 'sometimes|required|integer|min:1|max:5',
            'strengths' => 'nullable|array',
            'areas_for_improvement' => 'nullable|array',
            'comments' => 'sometimes|required|string',
            'development_plan' => 'nullable|string',
            'promotion_recommendation' => 'nullable|in:promote,ready_soon,not_ready,no',
            'salary_recommendation' => 'nullable|numeric|min:0',
            'status' => 'sometimes|required|in:draft,submitted,approved,rejected',
        ]);

        $performance->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Performance evaluation updated successfully',
            'data' => $performance
        ]);
    }

    /**
     * Remove the specified performance record.
     */
    public function destroy(Performance $performance): JsonResponse
    {
        $performance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Performance evaluation deleted successfully'
        ]);
    }

    /**
     * Submit performance evaluation for review.
     */
    public function submit(Request $request, Performance $performance): JsonResponse
    {
        $performance->update([
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Performance evaluation submitted for review',
            'data' => $performance
        ]);
    }

    /**
     * Approve performance evaluation.
     */
    public function approve(Request $request, Performance $performance): JsonResponse
    {
        $validated = $request->validate([
            'comments' => 'nullable|string',
        ]);

        $performance->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'manager_comments' => $validated['comments'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Performance evaluation approved',
            'data' => $performance
        ]);
    }

    /**
     * Reject performance evaluation.
     */
    public function reject(Request $request, Performance $performance): JsonResponse
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $performance->update([
            'status' => 'rejected',
            'rejected_by' => Auth::id(),
            'rejected_at' => now(),
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Performance evaluation rejected',
            'data' => $performance
        ]);
    }

    /**
     * Get performance analytics.
     */
    public function analytics(Request $request): JsonResponse
    {
        $period = $request->get('period', 'year'); // quarter, semi_annual, year

        $query = Performance::query();

        if ($period === 'quarter') {
            $query->whereBetween('evaluation_date', [now()->startOfQuarter()->toDateString(), now()->endOfQuarter()->toDateString()]);
        } elseif ($period === 'semi_annual') {
            $query->whereBetween('evaluation_date', [now()->startOfYear()->toDateString(), now()->endOfYear()->toDateString()])
                ->whereMonth('evaluation_date', '<=', 6);
        } elseif ($period === 'year') {
            $query->whereYear('evaluation_date', now()->year);
        }

        $analytics = [
            'total_evaluations' => $query->count(),
            'by_rating' => $query->selectRaw('overall_rating, COUNT(*) as count')
                ->groupBy('overall_rating')
                ->get(),
            'average_rating' => $query->avg('overall_rating'),
            'by_period' => $query->selectRaw('evaluation_period, COUNT(*) as count')
                ->groupBy('evaluation_period')
                ->get(),
            'by_status' => $query->selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get(),
            'goals_achievement_rate' => $query->avg('goals_achieved'),
            'promotions_recommended' => $query->where('promotion_recommendation', 'promote')->count(),
            'salary_increases' => $query->whereNotNull('salary_recommendation')->sum('salary_recommendation'),
        ];

        return response()->json([
            'success' => true,
            'data' => $analytics
        ]);
    }

    /**
     * Get employee performance history.
     */
    public function employeeHistory(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        $history = Performance::where('employee_id', $validated['employee_id'])
            ->with(['reviewer'])
            ->orderBy('evaluation_date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $history
        ]);
    }

    /**
     * Get performance summary for dashboard.
     */
    public function summary(Request $request): JsonResponse
    {
        $year = $request->get('year', now()->year);
        
        $summary = [
            'total_evaluations' => Performance::whereYear('evaluation_date', $year)->count(),
            'average_rating' => Performance::whereYear('evaluation_date', $year)->avg('overall_rating'),
            'pending_reviews' => Performance::where('status', 'submitted')->count(),
            'overdue_evaluations' => Performance::whereYear('evaluation_date', $year)
                ->where('status', 'draft')
                ->where('evaluation_date', '<', now()->subDays(30))
                ->count(),
            'top_performers' => Performance::whereYear('evaluation_date', $year)
                ->orderBy('overall_rating', 'desc')
                ->with(['employee'])
                ->limit(10)
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $summary
        ]);
    }
}
