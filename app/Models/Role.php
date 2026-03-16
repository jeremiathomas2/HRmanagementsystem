<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'role_type',
        'company_id',
        'permissions',
        'restrictions',
        'hierarchy_level',
        'is_system_role',
        'is_active'
    ];

    protected $casts = [
        'permissions' => 'array',
        'restrictions' => 'array',
        'is_system_role' => 'boolean',
        'is_active' => 'boolean',
        'hierarchy_level' => 'integer'
    ];

    /**
     * Get the users that belong to the role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['assigned_at', 'assigned_by', 'expires_at', 'is_active'])
            ->withTimestamps();
    }

    /**
     * Get the permissions that belong to the role.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * Check if role has a specific permission.
     */
    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('name', $permission)->exists() ||
               in_array($permission, $this->permissions ?? []);
    }

    /**
     * Check if role is HR Admin type.
     */
    public function isHRAdmin(): bool
    {
        return in_array($this->role_type, ['super_admin', 'hr_admin', 'lead_hr_admin']);
    }

    /**
     * Check if role can approve sensitive decisions.
     */
    public function canApprove(): bool
    {
        return $this->isHRAdmin();
    }

    /**
     * Scope a query to only include active roles.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include HR Admin roles.
     */
    public function scopeHRAdmin($query)
    {
        return $query->whereIn('role_type', ['super_admin', 'hr_admin', 'lead_hr_admin']);
    }

    /**
     * Get hierarchy level for role-based access.
     */
    public function getHierarchyLevel(): int
    {
        $levels = [
            'employee' => 1,
            'line_manager' => 2,
            'finance_officer' => 3,
            'hr_officer' => 4,
            'external_auditor' => 5,
            'lead_hr_admin' => 6,
            'hr_admin' => 7,
            'super_admin' => 8
        ];

        return $levels[$this->role_type] ?? 0;
    }
}
