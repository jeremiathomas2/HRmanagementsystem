<?php

namespace App\Http\Controllers;

use App\Models\LegalCase;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LegalCaseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cases = LegalCase::with(['company', 'employee', 'assignedTo'])
            ->when($user->company_id, function ($query) use ($user) {
                return $query->where('company_id', $user->company_id);
            })
            ->when(request('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when(request('severity'), function ($query, $severity) {
                return $query->where('severity', $severity);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('legal-cases.index', compact('cases'));
    }

    public function create()
    {
        $employees = Employee::where('is_active', true)->get();
        
        return view('legal-cases.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'nullable|exists:employees,id',
            'case_type' => ['required', Rule::in(['termination', 'discrimination', 'harassment', 'wage_dispute', 'contract_dispute', 'safety_violation', 'other'])],
            'case_title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'severity' => ['required', Rule::in(['low', 'medium', 'high', 'critical'])],
            'urgency' => ['required', Rule::in(['low', 'medium', 'high', 'urgent'])],
            'legal_framework' => ['required', Rule::in(['elra', 'osha', 'employment_act', 'tax_act', 'data_protection', 'other'])],
            'incident_date' => 'nullable|date|before_or_equal:today',
            'resolution_target_date' => 'nullable|date|after:today',
        ]);

        try {
            DB::beginTransaction();

            // Generate unique case number
            $caseNumber = $this->generateCaseNumber();

            $case = LegalCase::create([
                'company_id' => Auth::user()->company_id,
                'employee_id' => $request->employee_id,
                'initiated_by' => Auth::id(),
                'case_number' => $caseNumber,
                'case_type' => $request->case_type,
                'case_title' => $request->case_title,
                'description' => $request->description,
                'severity' => $request->severity,
                'urgency' => $request->urgency,
                'status' => 'open',
                'legal_framework' => $request->legal_framework,
                'incident_date' => $request->incident_date,
                'reported_date' => now(),
                'resolution_target_date' => $request->resolution_target_date,
            ]);

            // Calculate initial risk scores
            $case->calculateRiskScores();

            // Check if escalation is needed
            $case->escalateIfNeeded();

            DB::commit();

            return redirect()->route('legal-cases.show', $case)
                ->with('success', 'Legal case created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create legal case: ' . $e->getMessage()]);
        }
    }

    public function show(LegalCase $case)
    {
        $case->load(['company', 'employee', 'initiatedBy', 'assignedTo']);
        
        return view('legal-cases.show', compact('case'));
    }

    public function edit(LegalCase $case)
    {
        $this->authorize('update', $case);
        
        return view('legal-cases.edit', compact('case'));
    }

    public function update(Request $request, LegalCase $case)
    {
        $this->authorize('update', $case);

        $request->validate([
            'case_title' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
            'severity' => ['required', Rule::in(['low', 'medium', 'high', 'critical'])],
            'urgency' => ['required', Rule::in(['low', 'medium', 'high', 'urgent'])],
            'resolution_target_date' => 'nullable|date|after:today',
        ]);

        $case->update($request->only([
            'case_title', 'description', 'severity', 'urgency', 'resolution_target_date'
        ]));

        // Recalculate risk scores
        $case->calculateRiskScores();

        return redirect()->route('legal-cases.show', $case)
            ->with('success', 'Legal case updated successfully.');
    }

    public function assign(Request $request, LegalCase $case)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $case->update(['assigned_to' => $request->assigned_to]);

        return back()->with('success', 'Case assigned successfully.');
    }

    public function updateStatus(Request $request, LegalCase $case)
    {
        $request->validate([
            'status' => ['required', Rule::in(['open', 'investigating', 'mediating', 'legal_review', 'court_filed', 'settled', 'dismissed', 'closed'])],
            'status_notes' => 'nullable|string|max:2000',
        ]);

        $case->update([
            'status' => $request->status,
            'actual_resolution_date' => in_array($request->status, ['settled', 'dismissed', 'closed']) ? now() : null,
        ]);

        if ($request->status_notes) {
            $this->addCommunicationLog($case, 'Status updated to ' . $request->status, $request->status_notes);
        }

        return back()->with('success', 'Case status updated successfully.');
    }

    public function addEvidence(Request $request, LegalCase $case)
    {
        $request->validate([
            'evidence_type' => ['required', Rule::in(['document', 'witness_statement', 'digital', 'physical'])],
            'evidence_description' => 'required|string|max:1000',
            'evidence_file' => 'nullable|file|max:10240', // 10MB max
        ]);

        $evidenceData = [
            'type' => $request->evidence_type,
            'description' => $request->evidence_description,
            'added_by' => Auth::id(),
            'added_date' => now()->toISOString(),
        ];

        if ($request->hasFile('evidence_file')) {
            $file = $request->file('evidence_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->store('legal-evidence', 'public');
            $evidenceData['file_path'] = $path;
            $evidenceData['original_name'] = $file->getClientOriginalName();
        }

        $evidenceField = match($request->evidence_type) {
            'document' => 'evidence_documents',
            'witness_statement' => 'witness_statements',
            'digital' => 'digital_evidence',
            'physical' => 'physical_evidence',
        };

        $currentEvidence = $case->{$evidenceField} ?? [];
        $currentEvidence[] = $evidenceData;
        
        $case->update([$evidenceField => $currentEvidence]);

        return back()->with('success', 'Evidence added successfully.');
    }

    public function cmaReadiness(LegalCase $case)
    {
        $readinessScore = $case->calculateCMAReadiness();
        
        return view('legal-cases.cma-readiness', compact('case', 'readinessScore'));
    }

    public function generateCaseFile(LegalCase $case)
    {
        $caseFile = $case->generateCaseFile();
        
        return view('legal-cases.case-file', compact('case', 'caseFile'));
    }

    public function escalate(LegalCase $case)
    {
        $case->update([
            'urgency' => 'urgent',
            'assigned_to' => $this->findSeniorLegalCounsel(),
        ]);

        $this->addCommunicationLog($case, 'Case escalated', 'Case escalated to senior legal counsel due to high risk/urgency.');

        return back()->with('success', 'Case escalated successfully.');
    }

    public function resolve(Request $request, LegalCase $case)
    {
        $request->validate([
            'resolution_type' => ['required', Rule::in(['settlement', 'court_judgment', 'mediation', 'withdrawal', 'dismissal'])],
            'resolution_terms' => 'required|string|max:5000',
            'settlement_amount' => 'nullable|numeric|min:0',
            'lessons_learned' => 'nullable|string|max:2000',
        ]);

        $case->update([
            'status' => 'closed',
            'resolution_type' => $request->resolution_type,
            'resolution_terms' => $request->resolution_terms,
            'settlement_amount' => $request->settlement_amount,
            'lessons_learned' => $request->lessons_learned,
            'actual_resolution_date' => now(),
        ]);

        // Generate prevention recommendations
        $this->generatePreventionRecommendations($case);

        return back()->with('success', 'Case resolved successfully.');
    }

    private function generateCaseNumber()
    {
        $prefix = 'LC';
        $year = date('Y');
        $sequence = LegalCase::whereYear('created_at', $year)->count() + 1;
        
        return sprintf('%s-%s-%04d', $prefix, $year, $sequence);
    }

    private function addCommunicationLog(LegalCase $case, $action, $details)
    {
        $log = [
            'date' => now()->toISOString(),
            'action' => $action,
            'details' => $details,
            'user' => Auth::user()->name,
            'user_id' => Auth::id(),
        ];

        $currentLog = $case->communications_log ?? [];
        $currentLog[] = $log;
        
        $case->update(['communications_log' => $currentLog]);
    }

    private function findSeniorLegalCounsel()
    {
        // Find user with senior legal counsel role
        return \App\Models\User::whereHas('roles', function ($query) {
            $query->where('name', 'senior_legal_counsel');
        })->first()?->id;
    }

    private function generatePreventionRecommendations(LegalCase $case)
    {
        $recommendations = [];

        // Based on case type
        switch ($case->case_type) {
            case 'termination':
                $recommendations[] = [
                    'type' => 'policy',
                    'description' => 'Review and strengthen termination procedures',
                    'priority' => 'high',
                ];
                $recommendations[] = [
                    'type' => 'training',
                    'description' => 'Train managers on proper termination protocols',
                    'priority' => 'medium',
                ];
                break;
            
            case 'discrimination':
                $recommendations[] = [
                    'type' => 'policy',
                    'description' => 'Update anti-discrimination policies',
                    'priority' => 'critical',
                ];
                $recommendations[] = [
                    'type' => 'training',
                    'description' => 'Mandatory diversity and inclusion training',
                    'priority' => 'high',
                ];
                break;
            
            case 'harassment':
                $recommendations[] = [
                    'type' => 'policy',
                    'description' => 'Strengthen harassment reporting mechanisms',
                    'priority' => 'critical',
                ];
                $recommendations[] = [
                    'type' => 'training',
                    'description' => 'Harassment prevention training for all staff',
                    'priority' => 'high',
                ];
                break;
        }

        $case->update(['prevention_actions' => $recommendations]);
    }
}
