<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'display_name',
        'description',
        'module',
        'action',
        'resource',
        'conditions',
        'is_system_permission',
        'is_active'
    ];

    protected $casts = [
        'conditions' => 'array',
        'is_system_permission' => 'boolean',
        'is_active' => 'boolean'
    ];

    /**
     * Get the roles that belong to the permission.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Scope a query to only include active permissions.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by module.
     */
    public function scopeByModule($query, $module)
    {
        return $query->where('module', $module);
    }

    /**
     * Scope a query to filter by action.
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Check if permission is for HR Admin approval.
     */
    public function isApprovalPermission(): bool
    {
        return in_array($this->action, ['approve', 'reject']) &&
               in_array($this->module, ['discipline', 'contracts', 'termination']);
    }

    /**
     * Get full permission name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->module}.{$this->action}.{$this->resource}";
    }
}
