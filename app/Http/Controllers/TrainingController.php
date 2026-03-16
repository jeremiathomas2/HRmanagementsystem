<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Training;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    /**
     * Display a listing of training records.
     */
    public function index(Request $request): JsonResponse
    {
        $trainings = Training::with(['employees', 'instructor', 'company'])
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->latest('start_date')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $trainings
        ]);
    }

    /**
     * Store a newly created training record.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:technical,soft_skills,compliance,safety,leadership,other',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'duration_hours' => 'required|integer|min:1',
            'location' => 'required|string',
            'instructor_id' => 'nullable|exists:users,id',
            'instructor_name' => 'nullable|string|max:255',
            'cost_per_employee' => 'nullable|numeric|min:0',
            'max_participants' => 'required|integer|min:1',
            'status' => 'required|in:planned,in_progress,completed,cancelled',
            'certification' => 'required|boolean',
            'certificate_issued' => 'nullable|boolean',
            'certificate_expiry' => 'nullable|date',
            'compliance_required' => 'required|boolean',
            'materials' => 'nullable|array',
            'objectives' => 'required|array',
            'evaluation_method' => 'required|in:test,assignment,presentation,observation',
        ]);

        $training = Training::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Training created successfully',
            'data' => $training
        ], 201);
    }

    /**
     * Display the specified training record.
     */
    public function show(Training $training): JsonResponse
    {
        $training->load(['employees', 'instructor', 'company']);
        
        return response()->json([
            'success' => true,
            'data' => $training
        ]);
    }

    /**
     * Update the specified training record.
     */
    public function update(Request $request, Training $training): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'type' => 'sometimes|required|in:technical,soft_skills,compliance,safety,leadership,other',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'duration_hours' => 'sometimes|required|integer|min:1',
            'location' => 'sometimes|required|string',
            'instructor_id' => 'nullable|exists:users,id',
            'instructor_name' => 'nullable|string|max:255',
            'cost_per_employee' => 'nullable|numeric|min:0',
            'max_participants' => 'sometimes|required|integer|min:1',
            'status' => 'sometimes|required|in:planned,in_progress,completed,cancelled',
            'certification' => 'sometimes|required|boolean',
            'certificate_issued' => 'nullable|boolean',
            'certificate_expiry' => 'nullable|date',
            'compliance_required' => 'sometimes|required|boolean',
            'materials' => 'nullable|array',
            'objectives' => 'sometimes|required|array',
            'evaluation_method' => 'sometimes|required|in:test,assignment,presentation,observation',
        ]);

        $training->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Training updated successfully',
            'data' => $training
        ]);
    }

    /**
     * Remove the specified training record.
     */
    public function destroy(Training $training): JsonResponse
    {
        $training->delete();

        return response()->json([
            'success' => true,
            'message' => 'Training deleted successfully'
        ]);
    }

    /**
     * Enroll employees in training.
     */
    public function enroll(Request $request, Training $training): JsonResponse
    {
        $validated = $request->validate([
            'employee_ids' => 'required|array',
            'employee_ids.*' => 'exists:employees,id',
        ]);

        // Check if training has capacity
        $currentEnrollments = $training->employees()->count();
        $newEnrollments = count($validated['employee_ids']);
        
        if ($currentEnrollments + $newEnrollments > $training->max_participants) {
            return response()->json([
                'success' => false,
                'message' => 'Training capacity exceeded'
            ], 400);
        }

        $training->employees()->attach($validated['employee_ids']);

        return response()->json([
            'success' => true,
            'message' => 'Employees enrolled successfully',
            'data' => $training
        ]);
    }

    /**
     * Get training analytics.
     */
    public function analytics(Request $request): JsonResponse
    {
        $period = $request->get('period', 'year'); // quarter, semi_annual, year

        $query = Training::query();

        if ($period === 'quarter') {
            $query->whereBetween('start_date', [now()->startOfQuarter()->toDateString(), now()->endOfQuarter()->toDateString()]);
        } elseif ($period === 'semi_annual') {
            $query->whereBetween('start_date', [now()->startOfYear()->toDateString(), now()->endOfYear()->toDateString()])
                ->whereMonth('start_date', '<=', 6);
        } elseif ($period === 'year') {
            $query->whereYear('start_date', now()->year);
        }

        $analytics = [
            'total_trainings' => $query->count(),
            'by_type' => $query->selectRaw('type, COUNT(*) as count')
                ->groupBy('type')
                ->get(),
            'by_status' => $query->selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get(),
            'total_participants' => $query->withCount('employees')->get()->sum(function ($training) {
                return $training->employees_count;
            }),
            'total_hours' => $query->sum('duration_hours'),
            'total_cost' => $query->get()->sum(function ($training) {
                return $training->employees_count * ($training->cost_per_employee ?? 0);
            }),
            'certification_rate' => $query->where('certification', true)->count() / max($query->count(), 1) * 100,
            'compliance_trainings' => $query->where('compliance_required', true)->count(),
        ];

        return response()->json([
            'success' => true,
            'data' => $analytics
        ]);
    }

    /**
     * Get upcoming trainings.
     */
    public function upcoming(Request $request): JsonResponse
    {
        $trainings = Training::where('start_date', '>', now())
            ->where('status', 'planned')
            ->with(['company', 'instructor'])
            ->orderBy('start_date')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $trainings
        ]);
    }

    /**
     * Get employee training history.
     */
    public function employeeHistory(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        $history = Training::whereHas('employees', function ($query) use ($validated) {
                $query->where('employee_id', $validated['employee_id']);
            })
            ->with(['instructor', 'company'])
            ->orderBy('start_date', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $history
        ]);
    }

    /**
     * Get training calendar.
     */
    public function calendar(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2030',
        ]);

        $trainings = Training::whereMonth('start_date', $validated['month'])
            ->whereYear('start_date', $validated['year'])
            ->with(['employees'])
            ->get();

        return response()->json([
            'success' => true,
            'data' => $trainings
        ]);
    }

    /**
     * Get compliance training requirements.
     */
    public function complianceRequirements(Request $request): JsonResponse
    {
        $requirements = [
            'safety_training' => [
                'frequency' => 'annual',
                'required_for' => 'all_employees',
                'duration_hours' => 8,
                'description' => 'Workplace safety and emergency procedures',
            ],
            'sexual_harassment' => [
                'frequency' => 'biennial',
                'required_for' => 'all_employees',
                'duration_hours' => 4,
                'description' => 'Prevention of sexual harassment in workplace',
            ],
            'first_aid' => [
                'frequency' => 'biennial',
                'required_for' => 'designated_personnel',
                'duration_hours' => 16,
                'description' => 'First aid and CPR certification',
            ],
            'fire_safety' => [
                'frequency' => 'annual',
                'required_for' => 'designated_personnel',
                'duration_hours' => 8,
                'description' => 'Fire prevention and emergency response',
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $requirements
        ]);
    }

    /**
     * Check compliance training status.
     */
    public function complianceStatus(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        $company = Company::find($validated['company_id']);
        
        $complianceStatus = [];
        $requirements = $this->complianceRequirements($request);
        
        foreach ($requirements['data'] as $requirement => $details) {
            $lastTraining = Training::where('company_id', $validated['company_id'])
                ->where('type', 'compliance')
                ->where('title', 'like', '%' . $requirement . '%')
                ->latest('end_date')
                ->first();

            $isCompliant = false;
            if ($lastTraining) {
                $monthsSinceTraining = $lastTraining->end_date->diffInMonths(now());
                $isCompliant = $monthsSinceTraining < $this->getFrequencyInMonths($details['frequency']);
            }

            $complianceStatus[$requirement] = [
                'compliant' => $isCompliant,
                'last_training' => $lastTraining ? $lastTraining->end_date->toDateString() : null,
                'required_frequency' => $details['frequency'],
                'required_for' => $details['required_for'],
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $complianceStatus
        ]);
    }

    /**
     * Convert frequency string to months.
     */
    private function getFrequencyInMonths(string $frequency): int
    {
        $frequencies = [
            'monthly' => 1,
            'quarterly' => 3,
            'biennial' => 6,
            'annual' => 12,
        ];

        return $frequencies[$frequency] ?? 12;
    }
}
