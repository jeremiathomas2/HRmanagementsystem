<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Employee;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class DisciplineController extends Controller
{
    /**
     * Display a listing of discipline cases.
     */
    public function index(Request $request)
    {
        $query = Discipline::with(['employee', 'company'])
            ->where('company_id', $request->user()->company_id);

        // Apply filters
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('case_number', 'like', '%' . $request->search . '%')
                  ->orWhere('incident_description', 'like', '%' . $request->search . '%')
                  ->orWhereHas('employee', function($subQ) use ($request) {
                      $subQ->where('first_name', 'like', '%' . $request->search . '%')
                           ->orWhere('last_name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->case_type) {
            $query->where('case_type', $request->case_type);
        }

        if ($request->severity_level) {
            $query->where('severity_level', $request->severity_level);
        }

        if ($request->risk_score) {
            $query->where('risk_score', $request->risk_score);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $cases = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($cases);
    }

    /**
     * Store a newly created discipline case.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'case_type' => 'required|in:misconduct,performance,absenteeism,theft,fraud,harassment,violence,policy_violation,other',
            'severity_level' => 'required|in:minor,major,critical,gross_misconduct',
            'incident_date' => 'required|date|before_or_equal:today',
            'incident_description' => 'required|string',
            'incident_location' => 'nullable|string|max:255',
            'witness_details' => 'nullable|string',
            'evidence' => 'nullable|array',
            'evidence_documents' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $data = $validator->validated();
        $data['company_id'] = $request->user()->company_id;
        $data['case_number'] = $this->generateCaseNumber($request->user()->company_id);
        $data['reported_by'] = $request->user()->id;
        $data['status'] = 'reported';

        // Assess risk score based on severity and case type
        $data['risk_score'] = $this->assessRiskScore($data['case_type'], $data['severity_level']);

        // Perform legal risk analysis
        $data['legal_risk_analysis'] = $this->performLegalRiskAnalysis($data);

        $case = Discipline::create($data);

        // Create audit trail
        AuditLog::create([
            'user_id' => $request->user()->id,
            'company_id' => $request->user()->company_id,
            'action' => 'create',
            'module' => 'discipline',
            'record_id' => $case->id,
            'record_type' => 'Discipline',
            'description' => "Discipline case {$case->case_number} created for employee {$case->employee->full_name}",
            'new_values' => $data,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now(),
            'risk_level' => $data['risk_score'],
        ]);

        return response()->json([
            'message' => 'Discipline case created successfully',
            'case' => $case->load(['employee', 'company'])
        ], 201);
    }

    /**
     * Display the specified discipline case.
     */
    public function show(Request $request, Discipline $discipline)
    {
        if ($discipline->company_id !== $request->user()->company_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($discipline->load([
            'employee',
            'company',
            'reporter',
            'investigator',
            'hrAdminApprover'
        ]));
    }

    /**
     * Update the specified discipline case.
     */
    public function update(Request $request, Discipline $discipline)
    {
        if ($discipline->company_id !== $request->user()->company_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'sometimes|required|in:reported,investigation_pending,investigation_ongoing,show_cause_issued,hearing_scheduled,hearing_completed,decision_made,appeal_pending,closed',
            'investigation_findings' => 'nullable|string',
            'show_cause_letter' => 'nullable|string',
            'show_cause_response_deadline' => 'nullable|date',
            'employee_response' => 'nullable|string',
            'hearing_date' => 'nullable|date|after:today',
            'hearing_location' => 'nullable|string|max:255',
            'hearing_panel' => 'nullable|array',
            'hearing_notes' => 'nullable|string',
            'disciplinary_action' => 'nullable|in:warning,written_warning,final_warning,suspension,demotion,termination,fine,training_required,counseling',
            'action_details' => 'nullable|string',
            'action_effective_date' => 'nullable|date',
            'suspension_days' => 'nullable|integer|min:1',
            'fine_amount' => 'nullable|numeric|min:0',
            'final_decision' => 'nullable|string',
            'case_documents' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $data = $validator->validated();

        // Handle status transitions
        if (isset($data['status'])) {
            $this->handleStatusTransition($discipline, $data['status'], $request->user());
        }

        // Handle disciplinary action
        if (isset($data['disciplinary_action'])) {
            $data = $this->processDisciplinaryAction($discipline, $data, $request->user());
        }

        $discipline->update($data);

        return response()->json([
            'message' => 'Discipline case updated successfully',
            'case' => $discipline->load(['employee', 'company'])
        ]);
    }

    /**
     * Approve disciplinary action (HR Admin only).
     */
    public function approve(Request $request, Discipline $discipline)
    {
        if ($discipline->company_id !== $request->user()->company_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!$request->user()->isHRAdmin()) {
            return response()->json(['message' => 'Only HR Admin can approve disciplinary actions'], 403);
        }

        $validator = Validator::make($request->all(), [
            'approval_notes' => 'required|string',
            'final_decision' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $data = $validator->validated();
        $data['hr_admin_approved_by'] = $request->user()->id;
        $data['hr_admin_approved_at'] = now();
        $data['decision_status'] = 'approved_by_hr_admin';

        $discipline->update($data);

        // Generate final documents
        $this->generateFinalDocuments($discipline);

        return response()->json([
            'message' => 'Disciplinary action approved by HR Admin',
            'case' => $discipline->load(['employee', 'company'])
        ]);
    }

    /**
     * Reject disciplinary action (HR Admin only).
     */
    public function reject(Request $request, Discipline $discipline)
    {
        if ($discipline->company_id !== $request->user()->company_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!$request->user()->isHRAdmin()) {
            return response()->json(['message' => 'Only HR Admin can reject disciplinary actions'], 403);
        }

        $validator = Validator::make($request->all(), [
            'rejection_reason' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $data = $validator->validated();
        $data['hr_admin_approved_by'] = $request->user()->id;
        $data['hr_admin_approved_at'] = now();
        $data['decision_status'] = 'rejected';
        $data['hr_admin_notes'] = $data['rejection_reason'];

        $discipline->update($data);

        return response()->json([
            'message' => 'Disciplinary action rejected by HR Admin',
            'case' => $discipline->load(['employee', 'company'])
        ]);
    }

    /**
     * Generate discipline analytics.
     */
    public function analytics(Request $request)
    {
        $companyId = $request->user()->company_id;

        $analytics = [
            'total_cases' => Discipline::where('company_id', $companyId)->count(),
            'by_status' => Discipline::where('company_id', $companyId)
                ->groupBy('status')
                ->selectRaw('status, COUNT(*) as count')
                ->get(),
            'by_severity' => Discipline::where('company_id', $companyId)
                ->groupBy('severity_level')
                ->selectRaw('severity_level, COUNT(*) as count')
                ->get(),
            'by_risk_score' => Discipline::where('company_id', $companyId)
                ->groupBy('risk_score')
                ->selectRaw('risk_score, COUNT(*) as count')
                ->get(),
            'by_case_type' => Discipline::where('company_id', $companyId)
                ->groupBy('case_type')
                ->selectRaw('case_type, COUNT(*) as count')
                ->get(),
            'pending_hr_approval' => Discipline::where('company_id', $companyId)
                ->where('decision_status', 'pending')
                ->count(),
            'high_risk_cases' => Discipline::where('company_id', $companyId)
                ->whereIn('risk_score', ['high', 'critical'])
                ->count(),
            'termination_cases' => Discipline::where('company_id', $companyId)
                ->where('disciplinary_action', 'termination')
                ->count(),
            'recent_cases' => Discipline::where('company_id', $companyId)
                ->where('created_at', '>=', now()->subDays(30))
                ->count(),
            'average_resolution_time' => $this->calculateAverageResolutionTime($companyId),
            'legal_risk_exposure' => $this->calculateLegalRiskExposure($companyId),
        ];

        return response()->json($analytics);
    }

    /**
     * Generate unique case number.
     */
    private function generateCaseNumber(int $companyId): string
    {
        $prefix = 'DIS';
        $sequence = Discipline::where('company_id', $companyId)->count() + 1;
        $year = date('Y');
        
        return $prefix . '-' . $year . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Assess risk score based on case type and severity.
     */
    private function assessRiskScore(string $caseType, string $severityLevel): string
    {
        $riskMatrix = [
            'theft' => ['minor' => 'medium', 'major' => 'high', 'critical' => 'critical', 'gross_misconduct' => 'critical'],
            'fraud' => ['minor' => 'high', 'major' => 'high', 'critical' => 'critical', 'gross_misconduct' => 'critical'],
            'harassment' => ['minor' => 'high', 'major' => 'high', 'critical' => 'critical', 'gross_misconduct' => 'critical'],
            'violence' => ['minor' => 'high', 'major' => 'critical', 'critical' => 'critical', 'gross_misconduct' => 'critical'],
            'misconduct' => ['minor' => 'low', 'major' => 'medium', 'critical' => 'high', 'gross_misconduct' => 'critical'],
            'performance' => ['minor' => 'low', 'major' => 'medium', 'critical' => 'medium', 'gross_misconduct' => 'high'],
            'absenteeism' => ['minor' => 'low', 'major' => 'medium', 'critical' => 'medium', 'gross_misconduct' => 'high'],
        ];

        return $riskMatrix[$caseType][$severityLevel] ?? 'medium';
    }

    /**
     * Perform legal risk analysis.
     */
    private function performLegalRiskAnalysis(array $data): array
    {
        $analysis = [
            'termination_risk' => $this->calculateTerminationRisk($data),
            'legal_compliance' => $this->checkLegalCompliance($data),
            'precedent_risk' => $this->checkPrecedentCases($data),
            'evidence_strength' => $this->assessEvidenceStrength($data),
            'recommended_actions' => $this->getRecommendedActions($data),
        ];

        return $analysis;
    }

    /**
     * Handle status transitions.
     */
    private function handleStatusTransition(Discipline $discipline, string $newStatus, $user): void
    {
        $transitions = [
            'investigation_pending' => ['from' => ['reported']],
            'investigation_ongoing' => ['from' => ['investigation_pending']],
            'show_cause_issued' => ['from' => ['investigation_ongoing']],
            'hearing_scheduled' => ['from' => ['show_cause_issued']],
            'hearing_completed' => ['from' => ['hearing_scheduled']],
            'decision_made' => ['from' => ['hearing_completed']],
            'appeal_pending' => ['from' => ['decision_made']],
            'closed' => ['from' => ['decision_made', 'appeal_pending']],
        ];

        if (!isset($transitions[$newStatus]) || !in_array($discipline->status, $transitions[$newStatus]['from'])) {
            throw ValidationException::withMessages([
                'status' => 'Invalid status transition from ' . $discipline->status . ' to ' . $newStatus
            ]);
        }

        // Set timestamps and assign investigators
        if ($newStatus === 'investigation_ongoing') {
            $discipline->investigation_start_date = now();
            $discipline->investigated_by = $user->id;
        }

        if ($newStatus === 'investigation_ongoing' && $discipline->investigation_end_date) {
            $discipline->investigation_end_date = now();
        }

        if ($newStatus === 'show_cause_issued') {
            $discipline->show_cause_issued_date = now();
            $discipline->show_cause_response_deadline = now()->addDays(7);
        }

        if ($newStatus === 'closed') {
            $discipline->case_closed_date = now();
        }
    }

    /**
     * Process disciplinary action.
     */
    private function processDisciplinaryAction(Discipline $discipline, array $data, $user): array
    {
        // Calculate termination risk score if action is termination
        if ($data['disciplinary_action'] === 'termination') {
            $data['termination_risk_score'] = $this->calculateTerminationRiskScore($discipline);
            
            if ($data['termination_risk_score'] > 70) {
                $data['decision_status'] = 'pending'; // Requires HR Admin approval
            }
        }

        // Set action effective date
        if (!isset($data['action_effective_date'])) {
            $data['action_effective_date'] = now();
        }

        return $data;
    }

    /**
     * Calculate average resolution time.
     */
    private function calculateAverageResolutionTime(int $companyId): float
    {
        $cases = Discipline::where('company_id', $companyId)
            ->whereNotNull('case_closed_date')
            ->get();

        if ($cases->isEmpty()) return 0;

        $totalDays = $cases->sum(function($case) {
            return $case->created_at->diffInDays($case->case_closed_date);
        });

        return round($totalDays / $cases->count(), 1);
    }

    /**
     * Calculate legal risk exposure.
     */
    private function calculateLegalRiskExposure(int $companyId): array
    {
        $highRiskCases = Discipline::where('company_id', $companyId)
            ->whereIn('risk_score', ['high', 'critical'])
            ->where('status', '!=', 'closed')
            ->count();

        $terminationCases = Discipline::where('company_id', $companyId)
            ->where('disciplinary_action', 'termination')
            ->where('status', '!=', 'closed')
            ->count();

        return [
            'high_risk_cases' => $highRiskCases,
            'pending_terminations' => $terminationCases,
            'total_exposure_score' => ($highRiskCases * 10) + ($terminationCases * 25),
        ];
    }

    /**
     * Calculate termination risk score.
     */
    private function calculateTerminationRiskScore(Discipline $discipline): float
    {
        $score = 0;

        // Base score from severity
        $severityScores = ['minor' => 10, 'major' => 30, 'critical' => 60, 'gross_misconduct' => 80];
        $score += $severityScores[$discipline->severity_level] ?? 30;

        // Risk from case type
        $caseTypeScores = [
            'theft' => 20, 'fraud' => 25, 'harassment' => 30, 'violence' => 35,
            'misconduct' => 10, 'performance' => 15, 'absenteeism' => 5
        ];
        $score += $caseTypeScores[$discipline->case_type] ?? 10;

        // Evidence strength (negative score reduces risk)
        if ($discipline->evidence && count($discipline->evidence) > 0) {
            $score -= min(20, count($discipline->evidence) * 5);
        }

        // Employee history (simplified)
        if ($discipline->employee->employment_category === 'permanent') {
            $score += 15;
        }

        return min(100, max(0, $score));
    }

    /**
     * Generate final documents.
     */
    private function generateFinalDocuments(Discipline $discipline): void
    {
        // This would generate PDF documents for the disciplinary action
        // Including termination letters, suspension notices, etc.
    }

    // Additional helper methods would be implemented here...
}
