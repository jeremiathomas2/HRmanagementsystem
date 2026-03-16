<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Traits\EncryptsSensitiveData;

class Employee extends Model
{
    use EncryptsSensitiveData;
    protected $fillable = [
        'company_id',
        'department_id',
        'employee_number',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'marital_status',
        'national_id',
        'passport_number',
        'citizenship',
        'work_permit_number',
        'work_permit_expiry',
        'employment_category',
        'hire_date',
        'confirmation_date',
        'termination_date',
        'termination_reason',
        'job_title',
        'job_description',
        'reporting_to',
        'employment_type',
        'basic_salary',
        'allowances',
        'benefits',
        'bank_name',
        'bank_account',
        'tax_number',
        'nssf_number',
        'wcf_number',
        'address',
        'city',
        'region',
        'postal_code',
        'emergency_contact_name',
        'emergency_contact_phone',
        'emergency_contact_relationship',
        'medical_information',
        'dependents',
        'education_history',
        'employment_history',
        'skills',
        'certifications',
        'languages',
        'is_active',
        'is_on_probation',
        'probation_end_date',
        'digital_signature'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'hire_date' => 'date',
        'confirmation_date' => 'date',
        'termination_date' => 'date',
        'work_permit_expiry' => 'date',
        'probation_end_date' => 'date',
        'basic_salary' => 'decimal:2',
        'allowances' => 'array',
        'benefits' => 'array',
        'medical_information' => 'array',
        'dependents' => 'array',
        'education_history' => 'array',
        'employment_history' => 'array',
        'skills' => 'array',
        'certifications' => 'array',
        'languages' => 'array',
        'digital_signature' => 'array',
        'is_active' => 'boolean',
        'is_on_probation' => 'boolean'
    ];

    /**
     * Get the company that owns the employee.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the department that belongs to the employee.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Get the contracts for the employee.
     */
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * Get the payrolls for the employee.
     */
    public function payrolls(): HasMany
    {
        return $this->hasMany(Payroll::class);
    }

    /**
     * Get the discipline cases for the employee.
     */
    public function disciplines(): HasMany
    {
        return $this->hasMany(Discipline::class);
    }

    /**
     * Get the attendances for the employee.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the leaves for the employee.
     */
    public function leaves(): HasMany
    {
        return $this->hasMany(Leave::class);
    }

    /**
     * Get the digital signatures for the employee.
     */
    public function digitalSignatures(): MorphMany
    {
        return $this->morphMany(DigitalSignature::class, 'signable');
    }

    /**
     * Get full name attribute.
     */
    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . ($this->middle_name ? $this->middle_name . ' ' : '') . $this->last_name);
    }

    /**
     * Get age attribute.
     */
    public function getAgeAttribute(): int
    {
        return $this->date_of_birth->age;
    }

    /**
     * Get years of service attribute.
     */
    public function getYearsOfServiceAttribute(): int
    {
        return $this->hire_date->diffInYears(now());
    }

    /**
     * Check if employee is on probation.
     */
    public function isOnProbation(): bool
    {
        return $this->is_on_probation && 
               $this->probation_end_date && 
               $this->probation_end_date->isFuture();
    }

    /**
     * Check if work permit is expiring soon (30 days).
     */
    public function isWorkPermitExpiringSoon(): bool
    {
        return $this->citizenship === 'non_citizen' &&
               $this->work_permit_expiry &&
               $this->work_permit_expiry->diffInDays(now()) <= 30;
    }

    /**
     * Scope a query to only include active employees.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include permanent employees.
     */
    public function scopePermanent($query)
    {
        return $query->where('employment_category', 'permanent');
    }

    /**
     * Scope a query to only include employees on probation.
     */
    public function scopeOnProbation($query)
    {
        return $query->where('is_on_probation', true);
    }
}
