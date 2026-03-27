<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeTransfer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'from_company_id',
        'to_company_id',
        'initiated_by',
        'approved_by',
        'hr_admin_approved_by',
        'transfer_type',
        'effective_date',
        'end_date',
        'reason',
        'terms_and_conditions',
        'old_contract_id',
        'new_contract_id',
        'contract_terminated',
        'contract_termination_date',
        'status',
        'rejection_reason',
        'risk_assessment',
        'risk_score',
        'risk_flags',
        'disciplinary_clearance',
        'payroll_clearance',
        'compliance_clearance',
        'compliance_notes',
        'transfer_documents',
        'digital_signatures',
        'from_company_approved_at',
        'to_company_approved_at',
        'hr_admin_approved_at',
        'completed_at',
    ];

    protected $casts = [
        'effective_date' => 'date',
        'end_date' => 'date',
        'contract_termination_date' => 'date',
        'risk_assessment' => 'array',
        'risk_flags' => 'array',
        'transfer_documents' => 'array',
        'digital_signatures' => 'array',
        'from_company_approved_at' => 'datetime',
        'to_company_approved_at' => 'datetime',
        'hr_admin_approved_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function fromCompany()
    {
        return $this->belongsTo(Company::class, 'from_company_id');
    }

    public function toCompany()
    {
        return $this->belongsTo(Company::class, 'to_company_id');
    }

    public function initiatedBy()
    {
        return $this->belongsTo(User::class, 'initiated_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function hrAdminApprovedBy()
    {
        return $this->belongsTo(User::class, 'hr_admin_approved_by');
    }

    public function oldContract()
    {
        return $this->belongsTo(Contract::class, 'old_contract_id');
    }

    public function newContract()
    {
        return $this->belongsTo(Contract::class, 'new_contract_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->whereIn('status', ['from_company_approved', 'to_company_approved', 'hr_admin_approved']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeHighRisk($query)
    {
        return $query->where('risk_score', '>=', 70);
    }

    // Methods
    public function canBeApprovedByCompany($companyId)
    {
        if ($this->from_company_id == $companyId && $this->status == 'pending') {
            return true;
        }
        if ($this->to_company_id == $companyId && $this->status == 'from_company_approved') {
            return true;
        }
        return false;
    }

    public function canBeApprovedByHRAdmin()
    {
        return in_array($this->status, ['to_company_approved']) && 
               $this->disciplinary_clearance && 
               $this->payroll_clearance && 
               $this->compliance_clearance;
    }

    public function calculateRiskScore()
    {
        $score = 0;
        
        // Check disciplinary issues
        $employee = $this->employee;
        if ($employee->disciplines()->where('status', 'active')->count() > 0) {
            $score += 30;
        }
        
        // Check contract type
        if ($this->transfer_type == 'temporary' || $this->transfer_type == 'contractual') {
            $score += 20;
        }
        
        // Check duration
        if ($this->end_date && $this->end_date->diffInDays($this->effective_date) < 30) {
            $score += 15;
        }
        
        // Check compliance issues
        if (!$this->disciplinary_clearance || !$this->payroll_clearance || !$this->compliance_clearance) {
            $score += 25;
        }
        
        $this->risk_score = min($score, 100);
        $this->save();
        
        return $this->risk_score;
    }

    public function generateTransferAgreement()
    {
        // Implementation for generating PDF transfer agreement
        return [
            'reference' => $this->id,
            'employee' => $this->employee->full_name,
            'from_company' => $this->fromCompany->name,
            'to_company' => $this->toCompany->name,
            'effective_date' => $this->effective_date->format('d M Y'),
            'transfer_type' => $this->transfer_type,
            'terms' => $this->terms_and_conditions,
        ];
    }

    public function updateStatus($newStatus, $userId = null, $reason = null)
    {
        $this->status = $newStatus;
        
        if ($newStatus == 'from_company_approved') {
            $this->from_company_approved_at = now();
            $this->approved_by = $userId;
        } elseif ($newStatus == 'to_company_approved') {
            $this->to_company_approved_at = now();
        } elseif ($newStatus == 'hr_admin_approved') {
            $this->hr_admin_approved_at = now();
            $this->hr_admin_approved_by = $userId;
        } elseif ($newStatus == 'completed') {
            $this->completed_at = now();
        } elseif ($newStatus == 'rejected') {
            $this->rejection_reason = $reason;
        }
        
        $this->save();
    }
}
