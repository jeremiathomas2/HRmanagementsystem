<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;

class LogActivity
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only log if user is authenticated and it's not a GET request
        if (Auth::check() && $request->method() !== 'GET') {
            $this->logActivity($request);
        }

        return $response;
    }

    /**
     * Log user activity.
     */
    private function logActivity(Request $request)
    {
        $user = Auth::user();
        $route = $request->route();
        
        if (!$route) return;

        $action = $this->getActionFromMethod($request->method());
        $module = $this->getModuleFromRoute($route->getName());
        $description = $this->generateDescription($request, $action, $module);

        AuditLog::create([
            'user_id' => $user->id,
            'company_id' => $user->company_id,
            'action' => $action,
            'module' => $module,
            'record_id' => $request->id ?? null,
            'record_type' => $this->getRecordType($module),
            'description' => $description,
            'old_values' => $this->getOldValues($request),
            'new_values' => $this->getNewValues($request),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'browser' => $this->getBrowser($request->userAgent()),
            'platform' => $this->getPlatform($request->userAgent()),
            'timestamp' => now(),
            'risk_level' => $this->assessRiskLevel($action, $module),
        ]);
    }

    /**
     * Get action from HTTP method.
     */
    private function getActionFromMethod(string $method): string
    {
        return match($method) {
            'POST' => 'create',
            'PUT', 'PATCH' => 'update',
            'DELETE' => 'delete',
            default => 'unknown'
        };
    }

    /**
     * Get module from route name.
     */
    private function getModuleFromRoute(?string $routeName): string
    {
        if (!$routeName) return 'unknown';
        
        $parts = explode('.', $routeName);
        return $parts[0] ?? 'unknown';
    }

    /**
     * Generate activity description.
     */
    private function generateDescription(Request $request, string $action, string $module): string
    {
        $user = Auth::user();
        $resource = $request->route('id') ? "ID: {$request->route('id')}" : '';
        
        return "{$user->full_name} {$action}d {$module} {$resource}";
    }

    /**
     * Get record type from module.
     */
    private function getRecordType(string $module): string
    {
        return match($module) {
            'employees' => 'Employee',
            'companies' => 'Company',
            'departments' => 'Department',
            'contracts' => 'Contract',
            'payrolls' => 'Payroll',
            'leaves' => 'Leave',
            'disciplines' => 'Discipline',
            'attendances' => 'Attendance',
            'recruitments' => 'Recruitment',
            'performances' => 'Performance',
            'trainings' => 'Training',
            'compliances' => 'Compliance',
            default => ucfirst($module)
        };
    }

    /**
     * Get old values for audit trail.
     */
    private function getOldValues(Request $request): ?array
    {
        if ($request->method() === 'PUT' || $request->method() === 'PATCH') {
            // This would be implemented based on your specific needs
            return null;
        }
        return null;
    }

    /**
     * Get new values for audit trail.
     */
    private function getNewValues(Request $request): ?array
    {
        if ($request->method() === 'POST' || $request->method() === 'PUT' || $request->method() === 'PATCH') {
            $data = $request->all();
            
            // Remove sensitive data from audit trail
            unset($data['password'], $data['password_confirmation']);
            
            return $data;
        }
        return null;
    }

    /**
     * Get browser from user agent.
     */
    private function getBrowser(string $userAgent): ?string
    {
        if (preg_match('/Firefox/i', $userAgent)) return 'Firefox';
        if (preg_match('/Chrome/i', $userAgent)) return 'Chrome';
        if (preg_match('/Safari/i', $userAgent)) return 'Safari';
        if (preg_match('/Edge/i', $userAgent)) return 'Edge';
        
        return null;
    }

    /**
     * Get platform from user agent.
     */
    private function getPlatform(string $userAgent): ?string
    {
        if (preg_match('/Windows/i', $userAgent)) return 'Windows';
        if (preg_match('/Mac/i', $userAgent)) return 'MacOS';
        if (preg_match('/Linux/i', $userAgent)) return 'Linux';
        if (preg_match('/Android/i', $userAgent)) return 'Android';
        if (preg_match('/iOS/i', $userAgent)) return 'iOS';
        
        return null;
    }

    /**
     * Assess risk level based on action and module.
     */
    private function assessRiskLevel(string $action, string $module): string
    {
        $highRiskModules = ['disciplines', 'payrolls', 'employees', 'companies'];
        $highRiskActions = ['delete', 'approve', 'reject'];
        
        if (in_array($module, $highRiskModules) && in_array($action, $highRiskActions)) {
            return 'high';
        }
        
        if (in_array($module, $highRiskModules) || in_array($action, $highRiskActions)) {
            return 'medium';
        }
        
        return 'low';
    }
}
