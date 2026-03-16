<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Recruitment;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RecruitmentController extends Controller
{
    /**
     * Display a listing of recruitment records.
     */
    public function index(Request $request): JsonResponse
    {
        $recruitments = Recruitment::with(['company', 'hiringManager'])
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->position, function ($query, $position) {
                return $query->where('position', 'like', '%'.$position.'%');
            })
            ->latest('created_at')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $recruitments
        ]);
    }

    /**
     * Store a newly created recruitment record.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'position' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'employment_type' => 'required|in:full_time,part_time,contract,internship',
            'experience_level' => 'required|in:entry_level,mid_level,senior_level,executive',
            'salary_range_min' => 'required|numeric|min:0',
            'salary_range_max' => 'required|numeric|min:salary_range_min',
            'description' => 'required|string',
            'requirements' => 'required|array',
            'responsibilities' => 'required|array',
            'status' => 'required|in:open,in_review,shortlisted,interviewing,offered,hired,closed',
            'hiring_manager_id' => 'nullable|exists:users,id',
            'deadline' => 'required|date',
            'location' => 'required|string',
            'remote_allowed' => 'required|boolean',
            'tanzanian_required' => 'required|boolean',
            'work_permit_sponsorship' => 'required|boolean',
        ]);

        $recruitment = Recruitment::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Job posting created successfully',
            'data' => $recruitment
        ], 201);
    }

    /**
     * Display the specified recruitment record.
     */
    public function show(Recruitment $recruitment): JsonResponse
    {
        $recruitment->load(['company', 'hiringManager', 'applications']);
        
        return response()->json([
            'success' => true,
            'data' => $recruitment
        ]);
    }

    /**
     * Update the specified recruitment record.
     */
    public function update(Request $request, Recruitment $recruitment): JsonResponse
    {
        $validated = $request->validate([
            'position' => 'sometimes|required|string|max:255',
            'department' => 'sometimes|required|string|max:255',
            'employment_type' => 'sometimes|required|in:full_time,part_time,contract,internship',
            'experience_level' => 'sometimes|required|in:entry_level,mid_level,senior_level,executive',
            'salary_range_min' => 'sometimes|required|numeric|min:0',
            'salary_range_max' => 'sometimes|required|numeric|min:salary_range_min',
            'description' => 'sometimes|required|string',
            'requirements' => 'sometimes|required|array',
            'responsibilities' => 'sometimes|required|array',
            'status' => 'sometimes|required|in:open,in_review,shortlisted,interviewing,offered,hired,closed',
            'hiring_manager_id' => 'nullable|exists:users,id',
            'deadline' => 'sometimes|required|date',
            'location' => 'sometimes|required|string',
            'remote_allowed' => 'sometimes|required|boolean',
        ]);

        $recruitment->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Job posting updated successfully',
            'data' => $recruitment
        ]);
    }

    /**
     * Remove the specified recruitment record.
     */
    public function destroy(Recruitment $recruitment): JsonResponse
    {
        $recruitment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Job posting deleted successfully'
        ]);
    }

    /**
     * Get recruitment analytics.
     */
    public function analytics(Request $request): JsonResponse
    {
        $period = $request->get('period', 'month'); // week, month, year

        $query = Recruitment::query();

        if ($period === 'week') {
            $query->whereBetween('created_at', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()]);
        } elseif ($period === 'month') {
            $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($period === 'year') {
            $query->whereYear('created_at', now()->year);
        }

        $analytics = [
            'total_postings' => $query->count(),
            'by_status' => $query->selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get(),
            'by_department' => $query->selectRaw('department, COUNT(*) as count')
                ->groupBy('department')
                ->get(),
            'by_employment_type' => $query->selectRaw('employment_type, COUNT(*) as count')
                ->groupBy('employment_type')
                ->get(),
            'by_experience_level' => $query->selectRaw('experience_level, COUNT(*) as count')
                ->groupBy('experience_level')
                ->get(),
            'tanzanian_required' => $query->where('tanzanian_required', true)->count(),
            'remote_positions' => $query->where('remote_allowed', true)->count(),
            'average_salary_range' => [
                'min' => $query->avg('salary_range_min'),
                'max' => $query->avg('salary_range_max'),
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $analytics
        ]);
    }

    /**
     * Get active job postings.
     */
    public function activePostings(Request $request): JsonResponse
    {
        $postings = Recruitment::whereIn('status', ['open', 'in_review', 'shortlisted', 'interviewing'])
            ->where('deadline', '>', now())
            ->with(['company'])
            ->latest('created_at')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $postings
        ]);
    }

    /**
     * Get recruitment pipeline statistics.
     */
    public function pipelineStats(Request $request): JsonResponse
    {
        $stats = [
            'open' => Recruitment::where('status', 'open')->count(),
            'in_review' => Recruitment::where('status', 'in_review')->count(),
            'shortlisted' => Recruitment::where('status', 'shortlisted')->count(),
            'interviewing' => Recruitment::where('status', 'interviewing')->count(),
            'offered' => Recruitment::where('status', 'offered')->count(),
            'hired' => Recruitment::where('status', 'hired')->count(),
            'closed' => Recruitment::where('status', 'closed')->count(),
            'total_applications' => $this->getTotalApplications(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get total applications across all recruitments.
     */
    private function getTotalApplications(): int
    {
        // This would typically query an applications table
        // For now, return a placeholder
        return 0;
    }
}
