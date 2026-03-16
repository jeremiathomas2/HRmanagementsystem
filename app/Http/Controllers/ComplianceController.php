<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Compliance;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ComplianceController extends Controller
{
    /**
     * Display a listing of compliance records.
     */
    public function index(Request $request): JsonResponse
    {
        $compliances = Compliance::with(['company', 'assignedUser'])
            ->when($request->company_id, function ($query, $companyId) {
                return $query->where('company_id', $companyId);
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->risk_level, function ($query, $riskLevel) {
                return $query->where('risk_level', $riskLevel);
            })
            ->latest('created_at')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $compliances
        ]);
    }

    /**
     * Store a newly created compliance record.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'risk_level' => 'required|in:low,medium,high,critical',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,in_progress,completed,overdue,resolved',
            'due_date' => 'required|date',
            'assigned_to' => 'nullable|exists:users,id',
            'requirements' => 'nullable|array',
            'checklist' => 'nullable|array',
            'evidence' => 'nullable|array',
            'score' => 'nullable|integer|min:0|max:100',
            'violations' => 'nullable|array',
            'corrective_actions' => 'nullable|array',
            'legal_references' => 'nullable|array',
            'compliance_type' => 'required|in:tax,labour,immigration,safety,environment,other',
        ]);

        $compliance = Compliance::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Compliance record created successfully',
            'data' => $compliance
        ], 201);
    }

    /**
     * Display the specified compliance record.
     */
    public function show(Compliance $compliance): JsonResponse
    {
        $compliance->load(['company', 'assignedUser']);
        
        return response()->json([
            'success' => true,
            'data' => $compliance
        ]);
    }

    /**
     * Update the specified compliance record.
     */
    public function update(Request $request, Compliance $compliance): JsonResponse
    {
        $validated = $request->validate([
            'risk_level' => 'sometimes|required|in:low,medium,high,critical',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:pending,in_progress,completed,overdue,resolved',
            'due_date' => 'sometimes|required|date',
            'assigned_to' => 'nullable|exists:users,id',
            'requirements' => 'nullable|array',
            'checklist' => 'nullable|array',
            'evidence' => 'nullable|array',
            'score' => 'nullable|integer|min:0|max:100',
            'violations' => 'nullable|array',
            'corrective_actions' => 'nullable|array',
            'legal_references' => 'nullable|array',
        ]);

        $compliance->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Compliance record updated successfully',
            'data' => $compliance
        ]);
    }

    /**
     * Remove the specified compliance record.
     */
    public function destroy(Compliance $compliance): JsonResponse
    {
        $compliance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Compliance record deleted successfully'
        ]);
    }

    /**
     * Get upcoming compliance deadlines.
     */
    public function upcomingDeadlines(Request $request): JsonResponse
    {
        $days = $request->get('days', 30);
        
        $compliances = Compliance::where('due_date', '<=', now()->addDays($days))
            ->where('due_date', '>', now())
            ->where('status', '!=', 'resolved')
            ->with(['company', 'assignedUser'])
            ->orderBy('due_date')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $compliances
        ]);
    }

    /**
     * Get overdue compliance items.
     */
    public function overdue(Request $request): JsonResponse
    {
        $compliances = Compliance::where('due_date', '<', now())
            ->where('status', '!=', 'resolved')
            ->with(['company', 'assignedUser'])
            ->orderBy('due_date')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $compliances
        ]);
    }

    /**
     * Get compliance analytics.
     */
    public function analytics(Request $request): JsonResponse
    {
        $period = $request->get('period', 'month'); // week, month, year

        $query = Compliance::query();

        if ($period === 'week') {
            $query->whereBetween('created_at', [now()->startOfWeek()->toDateString(), now()->endOfWeek()->toDateString()]);
        } elseif ($period === 'month') {
            $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
        } elseif ($period === 'year') {
            $query->whereYear('created_at', now()->year);
        }

        $analytics = [
            'total_compliances' => $query->count(),
            'by_status' => $query->selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get(),
            'by_risk_level' => $query->selectRaw('risk_level, COUNT(*) as count')
                ->groupBy('risk_level')
                ->get(),
            'by_type' => $query->selectRaw('compliance_type, COUNT(*) as count')
                ->groupBy('compliance_type')
                ->get(),
            'overdue' => Compliance::where('due_date', '<', now())
                ->where('status', '!=', 'resolved')
                ->count(),
            'upcoming' => Compliance::whereBetween('due_date', [now(), now()->addDays(30)])
                ->where('status', '!=', 'resolved')
                ->count(),
            'average_score' => $query->avg('score'),
            'compliance_rate' => $query->where('status', 'completed')->count() / max($query->count(), 1) * 100,
        ];

        return response()->json([
            'success' => true,
            'data' => $analytics
        ]);
    }

    /**
     * Run compliance check.
     */
    public function runCheck(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'compliance_type' => 'required|in:tax,labour,immigration,safety,environment,other',
        ]);

        $company = Company::find($validated['company_id']);
        $results = [];

        // Tanzanian compliance checks based on type
        switch ($validated['compliance_type']) {
            case 'tax':
                $results = $this->checkTaxCompliance($company);
                break;
            case 'labour':
                $results = $this->checkLabourCompliance($company);
                break;
            case 'immigration':
                $results = $this->checkImmigrationCompliance($company);
                break;
            case 'safety':
                $results = $this->checkSafetyCompliance($company);
                break;
            default:
                $results = ['status' => 'completed', 'issues' => []];
        }

        return response()->json([
            'success' => true,
            'message' => 'Compliance check completed',
            'data' => $results
        ]);
    }

    /**
     * Check tax compliance.
     */
    private function checkTaxCompliance(Company $company): array
    {
        $issues = [];
        
        // Check PAYE filing
        $payeDue = Carbon::now()->endOfMonth();
        if (Carbon::now()->gt($payeDue->addDays(7))) {
            $issues[] = 'PAYE filing overdue';
        }

        // Check NSSF contributions
        $nssfDue = Carbon::now()->endOfMonth();
        if (Carbon::now()->gt($nssfDue->addDays(15))) {
            $issues[] = 'NSSF contributions overdue';
        }

        // Check WCF contributions
        $wcfDue = Carbon::now()->endOfMonth();
        if (Carbon::now()->gt($wcfDue->addDays(15))) {
            $issues[] = 'WCF contributions overdue';
        }

        return [
            'status' => count($issues) > 0 ? 'issues_found' : 'compliant',
            'issues' => $issues,
            'score' => max(100 - (count($issues) * 25), 0),
            'checked_at' => now()->toDateTimeString()
        ];
    }

    /**
     * Check labour compliance.
     */
    private function checkLabourCompliance(Company $company): array
    {
        $issues = [];
        
        // Check for non-citizen work permits
        $nonCitizens = $company->employees()
            ->where('citizenship', '!=', 'tanzanian')
            ->get();
        
        foreach ($nonCitizens as $employee) {
            if (!$employee->work_permit_expiry || Carbon::parse($employee->work_permit_expiry)->lt(now()->addDays(90))) {
                $issues[] = "Work permit expiring soon for {$employee->name}";
            }
        }

        // Check minimum wage compliance
        $minWage = 280000; // Current Tanzanian minimum wage
        $belowMinWage = $company->employees()->where('basic_salary', '<', $minWage)->count();
        if ($belowMinWage > 0) {
            $issues[] = "{$belowMinWage} employees below minimum wage";
        }

        return [
            'status' => count($issues) > 0 ? 'issues_found' : 'compliant',
            'issues' => $issues,
            'score' => max(100 - (count($issues) * 20), 0),
            'checked_at' => now()->toDateTimeString()
        ];
    }

    /**
     * Check immigration compliance.
     */
    private function checkImmigrationCompliance(Company $company): array
    {
        $issues = [];
        
        // Check residence permits
        $nonCitizens = $company->employees()
            ->where('citizenship', '!=', 'tanzanian')
            ->get();
        
        foreach ($nonCitizens as $employee) {
            if (!$employee->residence_permit_expiry || Carbon::parse($employee->residence_permit_expiry)->lt(now()->addDays(180))) {
                $issues[] = "Residence permit expiring soon for {$employee->name}";
            }
        }

        return [
            'status' => count($issues) > 0 ? 'issues_found' : 'compliant',
            'issues' => $issues,
            'score' => max(100 - (count($issues) * 30), 0),
            'checked_at' => now()->toDateTimeString()
        ];
    }

    /**
     * Check safety compliance.
     */
    private function checkSafetyCompliance(Company $company): array
    {
        $issues = [];
        
        // Check for safety training
        $safetyTrainingRequired = $company->employees()->count();
        $safetyTrainingCompleted = $company->employees()
            ->whereHas('trainings', function ($query) {
                $query->where('type', 'safety');
            })
            ->count();
        
        if ($safetyTrainingCompleted < $safetyTrainingRequired) {
            $issues[] = 'Safety training not completed for all employees';
        }

        return [
            'status' => count($issues) > 0 ? 'issues_found' : 'compliant',
            'issues' => $issues,
            'score' => max(100 - (count($issues) * 15), 0),
            'checked_at' => now()->toDateTimeString()
        ];
    }
}
