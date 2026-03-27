<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LegalCase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'employee_id',
        'initiated_by',
        'assigned_to',
        'case_number',
        'case_type',
        'case_title',
        'description',
        'severity',
        'urgency',
        'status',
        'legal_framework',
        'applicable_laws',
        'legal_basis',
        'incident_date',
        'reported_date',
        'resolution_target_date',
        'actual_resolution_date',
        'complainants',
        'respondents',
        'witnesses',
        'legal_representatives',
        'evidence_documents',
        'witness_statements',
        'digital_evidence',
        'physical_evidence',
        'evidence_summary',
        'legal_risk_score',
        'financial_risk_score',
        'reputational_risk_score',
        'risk_mitigation_plan',
        'resolution_type',
        'settlement_amount',
        'resolution_terms',
        'lessons_learned',
        'cma_ready',
        'cma_readiness_score',
        'cma_checklist',
        'cma_preparation_notes',
        'external_body',
        'case_reference_external',
        'external_filing_date',
        'communications_log',
        'legal_notices',
        'court_documents',
        'legal_costs',
        'settlement_costs',
        'court_costs',
        'other_costs',
        'prevention_actions',
        'policy_changes',
        'training_recommendations',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'reported_date' => 'date',
        'resolution_target_date' => 'date',
        'actual_resolution_date' => 'date',
        'external_filing_date' => 'date',
        'applicable_laws' => 'array',
        'complainants' => 'array',
        'respondents' => 'array',
        'witnesses' => 'array',
        'legal_representatives' => 'array',
        'evidence_documents' => 'array',
        'witness_statements' => 'array',
        'digital_evidence' => 'array',
        'physical_evidence' => 'array',
        'communications_log' => 'array',
        'legal_notices' => 'array',
        'court_documents' => 'array',
        'settlement_amount' => 'decimal:2',
        'legal_costs' => 'decimal:2',
        'settlement_costs' => 'decimal:2',
        'court_costs' => 'decimal:2',
        'other_costs' => 'decimal:2',
        'prevention_actions' => 'array',
        'policy_changes' => 'array',
        'training_recommendations' => 'array',
        'cma_checklist' => 'array',
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function initiatedBy()
    {
        return $this->belongsTo(User::class, 'initiated_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Scopes
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeHighRisk($query)
    {
        return $query->whereIn('severity', ['high', 'critical'])
                   ->orWhere('legal_risk_score', '>=', 70);
    }

    public function scopeCMAReady($query)
    {
        return $query->where('cma_ready', true);
    }

    public function scopeExternal($query)
    {
        return $query->where('external_body', '!=', 'none');
    }

    // Methods
    public function calculateRiskScores()
    {
        // Legal risk score based on case type and severity
        $legalRiskMap = [
            'termination' => ['low' => 30, 'medium' => 60, 'high' => 85, 'critical' => 95],
            'discrimination' => ['low' => 40, 'medium' => 70, 'high' => 90, 'critical' => 98],
            'harassment' => ['low' => 35, 'medium' => 65, 'high' => 88, 'critical' => 96],
            'wage_dispute' => ['low' => 25, 'medium' => 50, 'high' => 75, 'critical' => 90],
            'contract_dispute' => ['low' => 20, 'medium' => 45, 'high' => 70, 'critical' => 85],
            'safety_violation' => ['low' => 30, 'medium' => 60, 'high' => 85, 'critical' => 95],
            'other' => ['low' => 15, 'medium' => 35, 'high' => 60, 'critical' => 80],
        ];

        $this->legal_risk_score = $legalRiskMap[$this->case_type][$this->severity] ?? 50;

        // Financial risk based on potential costs
        $estimatedCosts = ($this->settlement_amount ?? 0) + 
                          ($this->legal_costs ?? 0) + 
                          ($this->court_costs ?? 0);
        
        if ($estimatedCosts > 10000000) {
            $this->financial_risk_score = 90;
        } elseif ($estimatedCosts > 5000000) {
            $this->financial_risk_score = 70;
        } elseif ($estimatedCosts > 1000000) {
            $this->financial_risk_score = 50;
        } elseif ($estimatedCosts > 500000) {
            $this->financial_risk_score = 30;
        } else {
            $this->financial_risk_score = 15;
        }

        // Reputational risk based on case type and external involvement
        $reputationalRisk = 20;
        if (in_array($this->case_type, ['discrimination', 'harassment', 'safety_violation'])) {
            $reputationalRisk += 30;
        }
        if ($this->external_body != 'none') {
            $reputationalRisk += 25;
        }
        if ($this->severity == 'critical') {
            $reputationalRisk += 25;
        }
        
        $this->reputational_risk_score = min($reputationalRisk, 100);

        $this->save();
    }

    public function calculateCMAReadiness()
    {
        $score = 0;
        $checklist = [];

        // Evidence completeness (30 points)
        if ($this->evidence_documents && count($this->evidence_documents) > 0) {
            $score += 10;
            $checklist[] = 'Evidence documents collected';
        }
        if ($this->witness_statements && count($this->witness_statements) > 0) {
            $score += 10;
            $checklist[] = 'Witness statements obtained';
        }
        if ($this->digital_evidence && count($this->digital_evidence) > 0) {
            $score += 10;
            $checklist[] = 'Digital evidence preserved';
        }

        // Legal documentation (25 points)
        if ($this->legal_basis) {
            $score += 10;
            $checklist[] = 'Legal basis documented';
        }
        if ($this->applicable_laws && count($this->applicable_laws) > 0) {
            $score += 10;
            $checklist[] = 'Applicable laws identified';
        }
        if ($this->legal_notices && count($this->legal_notices) > 0) {
            $score += 5;
            $checklist[] = 'Legal notices sent';
        }

        // Timeline and documentation (25 points)
        if ($this->incident_date) {
            $score += 5;
            $checklist[] = 'Incident date recorded';
        }
        if ($this->reported_date) {
            $score += 5;
            $checklist[] = 'Report date recorded';
        }
        if ($this->communications_log && count($this->communications_log) > 0) {
            $score += 10;
            $checklist[] = 'Communications log maintained';
        }
        if ($this->evidence_summary) {
            $score += 5;
            $checklist[] = 'Evidence summary prepared';
        }

        // Risk assessment (20 points)
        if ($this->legal_risk_score > 0) {
            $score += 5;
            $checklist[] = 'Legal risk assessed';
        }
        if ($this->financial_risk_score > 0) {
            $score += 5;
            $checklist[] = 'Financial risk assessed';
        }
        if ($this->risk_mitigation_plan) {
            $score += 10;
            $checklist[] = 'Risk mitigation plan prepared';
        }

        $this->cma_readiness_score = $score;
        $this->cma_checklist = $checklist;
        $this->cma_ready = $score >= 70;

        $this->save();
        
        return $score;
    }

    public function generateCaseFile()
    {
        return [
            'case_number' => $this->case_number,
            'title' => $this->case_title,
            'type' => $this->case_type,
            'severity' => $this->severity,
            'status' => $this->status,
            'company' => $this->company->name,
            'employee' => $this->employee ? $this->employee->full_name : 'N/A',
            'incident_date' => $this->incident_date?->format('d M Y'),
            'reported_date' => $this->reported_date->format('d M Y'),
            'legal_framework' => $this->legal_framework,
            'risk_scores' => [
                'legal' => $this->legal_risk_score,
                'financial' => $this->financial_risk_score,
                'reputational' => $this->reputational_risk_score,
            ],
            'cma_readiness' => [
                'score' => $this->cma_readiness_score,
                'ready' => $this->cma_ready,
                'checklist' => $this->cma_checklist,
            ],
            'external_body' => $this->external_body,
            'total_costs' => ($this->settlement_amount ?? 0) + ($this->legal_costs ?? 0) + ($this->court_costs ?? 0) + ($this->other_costs ?? 0),
        ];
    }

    public function escalateIfNeeded()
    {
        if ($this->severity == 'critical' || 
            $this->legal_risk_score >= 80 || 
            $this->external_body != 'none') {
            // Auto-escalate to senior management
            $this->urgency = 'urgent';
            $this->save();
            return true;
        }
        return false;
    }
}
