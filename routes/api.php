<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DisciplineController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\RecruitmentController;
use App\Http\Controllers\PerformanceController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\ComplianceController;
use App\Http\Controllers\AnalyticsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentication Routes
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:web');
Route::get('/auth/me', [AuthenticatedSessionController::class, 'me']);

// Protected Routes
Route::middleware(['auth:web'])->group(function () {
    
    // Company Routes
    Route::get('/companies', [CompanyController::class, 'index']);
    Route::post('/companies', [CompanyController::class, 'store']);
    Route::get('/companies/{company}', [CompanyController::class, 'show']);
    Route::put('/companies/{company}', [CompanyController::class, 'update']);
    Route::delete('/companies/{company}', [CompanyController::class, 'destroy']);
    Route::get('/companies/{company}/analytics', [CompanyController::class, 'analytics']);

    // Department Routes
    Route::get('/departments', [DepartmentController::class, 'index']);
    Route::post('/departments', [DepartmentController::class, 'store'])->middleware('permission:departments.create');
    Route::get('/departments/{department}', [DepartmentController::class, 'show']);
    Route::put('/departments/{department}', [DepartmentController::class, 'update'])->middleware('permission:departments.update');
    Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->middleware('permission:departments.delete');

    // Employee Routes
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/employees', [EmployeeController::class, 'store'])->middleware('permission:employees.create');
    Route::get('/employees/{employee}', [EmployeeController::class, 'show']);
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->middleware('permission:employees.update');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->middleware('permission:employees.delete');
    Route::get('/employees/analytics', [EmployeeController::class, 'analytics']);
    Route::get('/employees/export', [EmployeeController::class, 'export'])->middleware('permission:employees.export');

    // Contract Routes
    Route::get('/contracts', [ContractController::class, 'index']);
    Route::post('/contracts', [ContractController::class, 'store'])->middleware('permission:contracts.create');
    Route::get('/contracts/{contract}', [ContractController::class, 'show']);
    Route::put('/contracts/{contract}', [ContractController::class, 'update'])->middleware('permission:contracts.update');
    Route::delete('/contracts/{contract}', [ContractController::class, 'destroy'])->middleware('permission:contracts.delete');
    Route::post('/contracts/{contract}/approve', [ContractController::class, 'approve'])->middleware('role:hr_admin');
    Route::post('/contracts/{contract}/renew', [ContractController::class, 'renew'])->middleware('permission:contracts.update');

    // Attendance Routes
    Route::get('/attendances', [AttendanceController::class, 'index']);
    Route::post('/attendances', [AttendanceController::class, 'store']);
    Route::get('/attendances/{attendance}', [AttendanceController::class, 'show']);
    Route::put('/attendances/{attendance}', [AttendanceController::class, 'update']);
    Route::delete('/attendances/{attendance}', [AttendanceController::class, 'delete']);
    Route::post('/attendances/clock-in', [AttendanceController::class, 'clockIn']);
    Route::post('/attendances/clock-out', [AttendanceController::class, 'clockOut']);
    Route::get('/attendances/analytics', [AttendanceController::class, 'analytics']);

    // Leave Routes
    Route::get('/leaves', [LeaveController::class, 'index']);
    Route::post('/leaves', [LeaveController::class, 'store'])->middleware('permission:leaves.create');
    Route::get('/leaves/{leave}', [LeaveController::class, 'show']);
    Route::put('/leaves/{leave}', [LeaveController::class, 'update'])->middleware('permission:leaves.update');
    Route::delete('/leaves/{leave}', [LeaveController::class, 'destroy'])->middleware('permission:leaves.delete');
    Route::post('/leaves/{leave}/approve', [LeaveController::class, 'approve'])->middleware('role:hr_admin');
    Route::post('/leaves/{leave}/reject', [LeaveController::class, 'reject'])->middleware('role:hr_admin');
    Route::get('/leaves/balance', [LeaveController::class, 'getBalance']);
    Route::get('/leaves/analytics', [LeaveController::class, 'analytics']);

    // Recruitment Routes
    Route::get('/recruitments', [RecruitmentController::class, 'index']);
    Route::post('/recruitments', [RecruitmentController::class, 'store'])->middleware('permission:recruitments.create');
    Route::get('/recruitments/{recruitment}', [RecruitmentController::class, 'show']);
    Route::put('/recruitments/{recruitment}', [RecruitmentController::class, 'update'])->middleware('permission:recruitments.update');
    Route::delete('/recruitments/{recruitment}', [RecruitmentController::class, 'destroy'])->middleware('permission:recruitments.delete');
    Route::get('/recruitments/analytics', [RecruitmentController::class, 'analytics']);
    Route::get('/recruitments/active', [RecruitmentController::class, 'activePostings']);
    Route::get('/recruitments/pipeline', [RecruitmentController::class, 'pipelineStats']);

    // Performance Routes
    Route::get('/performances', [PerformanceController::class, 'index']);
    Route::post('/performances', [PerformanceController::class, 'store'])->middleware('permission:performance.create');
    Route::get('/performances/{performance}', [PerformanceController::class, 'show']);
    Route::put('/performances/{performance}', [PerformanceController::class, 'update'])->middleware('permission:performance.update');
    Route::delete('/performances/{performance}', [PerformanceController::class, 'destroy'])->middleware('permission:performance.delete');
    Route::post('/performances/{performance}/submit', [PerformanceController::class, 'submit']);
    Route::post('/performances/{performance}/approve', [PerformanceController::class, 'approve'])->middleware('role:hr_manager');
    Route::post('/performances/{performance}/reject', [PerformanceController::class, 'reject'])->middleware('role:hr_manager');
    Route::get('/performances/analytics', [PerformanceController::class, 'analytics']);
    Route::get('/performances/employee/{employee_id}', [PerformanceController::class, 'employeeHistory']);
    Route::get('/performances/summary', [PerformanceController::class, 'summary']);

    // Training Routes
    Route::get('/trainings', [TrainingController::class, 'index']);
    Route::post('/trainings', [TrainingController::class, 'store'])->middleware('permission:trainings.create');
    Route::get('/trainings/{training}', [TrainingController::class, 'show']);
    Route::put('/trainings/{training}', [TrainingController::class, 'update'])->middleware('permission:trainings.update');
    Route::delete('/trainings/{training}', [TrainingController::class, 'destroy'])->middleware('permission:trainings.delete');
    Route::post('/trainings/{training}/enroll', [TrainingController::class, 'enroll']);
    Route::get('/trainings/analytics', [TrainingController::class, 'analytics']);
    Route::get('/trainings/upcoming', [TrainingController::class, 'upcoming']);
    Route::get('/trainings/employee/{employee_id}', [TrainingController::class, 'employeeHistory']);
    Route::get('/trainings/calendar', [TrainingController::class, 'calendar']);
    Route::get('/trainings/compliance/requirements', [TrainingController::class, 'complianceRequirements']);
    Route::get('/trainings/compliance/status', [TrainingController::class, 'complianceStatus']);

    // Compliance Routes
    Route::get('/compliances', [ComplianceController::class, 'index']);
    Route::post('/compliances', [ComplianceController::class, 'store'])->middleware('permission:compliances.create');
    Route::get('/compliances/{compliance}', [ComplianceController::class, 'show']);
    Route::put('/compliances/{compliance}', [ComplianceController::class, 'update'])->middleware('permission:compliances.update');
    Route::delete('/compliances/{compliance}', [ComplianceController::class, 'destroy'])->middleware('permission:compliances.delete');
    Route::get('/compliances/deadlines', [ComplianceController::class, 'upcomingDeadlines']);
    Route::get('/compliances/overdue', [ComplianceController::class, 'overdue']);
    Route::get('/compliances/analytics', [ComplianceController::class, 'analytics']);
    Route::post('/compliances/check', [ComplianceController::class, 'runCheck']);

    // Analytics Routes
    Route::get('/analytics/dashboard', [AnalyticsController::class, 'dashboard']);
    Route::get('/analytics/export', [AnalyticsController::class, 'export']);
    Route::get('/attendances/analytics', [AttendanceController::class, 'analytics']);

    // Payroll Routes
    Route::get('/payrolls', [PayrollController::class, 'index']);
    Route::post('/payrolls', [PayrollController::class, 'store'])->middleware('permission:payrolls.create');
    Route::get('/payrolls/{payroll}', [PayrollController::class, 'show']);
    Route::put('/payrolls/{payroll}', [PayrollController::class, 'update'])->middleware('permission:payrolls.update');
    Route::delete('/payrolls/{payroll}', [PayrollController::class, 'destroy'])->middleware('permission:payrolls.delete');
    Route::post('/payrolls/batch', [PayrollController::class, 'processBatch'])->middleware('permission:payrolls.create');
    Route::post('/payrolls/{payroll}/approve', [PayrollController::class, 'approve'])->middleware('role:hr_admin');
    Route::post('/payrolls/{payroll}/process', [PayrollController::class, 'process'])->middleware('permission:payrolls.process');
    Route::get('/payrolls/reports', [PayrollController::class, 'generateReports'])->middleware('permission:payrolls.export');

    // Leave Routes
    Route::get('/leaves', [LeaveController::class, 'index']);
    Route::post('/leaves', [LeaveController::class, 'store']);
    Route::get('/leaves/{leave}', [LeaveController::class, 'show']);
    Route::put('/leaves/{leave}', [LeaveController::class, 'update']);
    Route::delete('/leaves/{leave}', [LeaveController::class, 'delete']);
    Route::post('/leaves/{leave}/approve', [LeaveController::class, 'approve'])->middleware('permission:leaves.approve');
    Route::post('/leaves/{leave}/reject', [LeaveController::class, 'reject'])->middleware('permission:leaves.approve');
    Route::get('/leaves/balance/{employee}', [LeaveController::class, 'getBalance']);
    Route::get('/leaves/analytics', [LeaveController::class, 'analytics']);

    // Discipline Routes
    Route::get('/disciplines', [DisciplineController::class, 'index']);
    Route::post('/disciplines', [DisciplineController::class, 'store'])->middleware('permission:disciplines.create');
    Route::get('/disciplines/{discipline}', [DisciplineController::class, 'show']);
    Route::put('/disciplines/{discipline}', [DisciplineController::class, 'update'])->middleware('permission:disciplines.update');
    Route::delete('/disciplines/{discipline}', [DisciplineController::class, 'destroy'])->middleware('permission:disciplines.delete');
    Route::post('/disciplines/{discipline}/approve', [DisciplineController::class, 'approve'])->middleware('role:hr_admin');
    Route::post('/disciplines/{discipline}/reject', [DisciplineController::class, 'reject'])->middleware('role:hr_admin');
    Route::get('/disciplines/analytics', [DisciplineController::class, 'analytics']);
    Route::get('/disciplines/recent', [DisciplineController::class, 'recent']);

    // Recruitment Routes
    Route::get('/recruitments', [RecruitmentController::class, 'index']);
    Route::post('/recruitments', [RecruitmentController::class, 'store'])->middleware('permission:recruitments.create');
    Route::get('/recruitments/{recruitment}', [RecruitmentController::class, 'show']);
    Route::put('/recruitments/{recruitment}', [RecruitmentController::class, 'update'])->middleware('permission:recruitments.update');
    Route::delete('/recruitments/{recruitment}', [RecruitmentController::class, 'destroy'])->middleware('permission:recruitments.delete');
    Route::post('/recruitments/{recruitment}/approve', [RecruitmentController::class, 'approve'])->middleware('permission:recruitments.approve');
    Route::get('/recruitments/analytics', [RecruitmentController::class, 'analytics']);

    // Performance Routes
    Route::get('/performances', [PerformanceController::class, 'index']);
    Route::post('/performances', [PerformanceController::class, 'store'])->middleware('permission:performances.create');
    Route::get('/performances/{performance}', [PerformanceController::class, 'show']);
    Route::put('/performances/{performance}', [PerformanceController::class, 'update'])->middleware('permission:performances.update');
    Route::delete('/performances/{performance}', [PerformanceController::class, 'destroy'])->middleware('permission:performances.delete');
    Route::post('/performances/{performance}/approve', [PerformanceController::class, 'approve'])->middleware('permission:performances.approve');
    Route::get('/performances/analytics', [PerformanceController::class, 'analytics']);

    // Training Routes
    Route::get('/trainings', [TrainingController::class, 'index']);
    Route::post('/trainings', [TrainingController::class, 'store'])->middleware('permission:trainings.create');
    Route::get('/trainings/{training}', [TrainingController::class, 'show']);
    Route::put('/trainings/{training}', [TrainingController::class, 'update'])->middleware('permission:trainings.update');
    Route::delete('/trainings/{training}', [TrainingController::class, 'destroy'])->middleware('permission:trainings.delete');
    Route::post('/trainings/{training}/enroll', [TrainingController::class, 'enroll']);
    Route::post('/trainings/{training}/complete', [TrainingController::class, 'complete']);
    Route::get('/trainings/analytics', [TrainingController::class, 'analytics']);

    // Compliance Routes
    Route::get('/compliances', [ComplianceController::class, 'index']);
    Route::post('/compliances', [ComplianceController::class, 'store'])->middleware('permission:compliances.create');
    Route::get('/compliances/{compliance}', [ComplianceController::class, 'show']);
    Route::put('/compliances/{compliance}', [ComplianceController::class, 'update'])->middleware('permission:compliances.update');
    Route::delete('/compliances/{compliance}', [ComplianceController::class, 'destroy'])->middleware('permission:compliances.delete');
    Route::post('/compliances/{compliance}/approve', [ComplianceController::class, 'approve'])->middleware('role:hr_admin');
    Route::get('/compliances/upcoming', [ComplianceController::class, 'upcoming']);
    Route::get('/compliances/analytics', [ComplianceController::class, 'analytics']);

    // Analytics Routes
    Route::get('/analytics/dashboard', [AnalyticsController::class, 'dashboard']);
    Route::get('/analytics/turnover', [AnalyticsController::class, 'turnover']);
    Route::get('/analytics/absenteeism', [AnalyticsController::class, 'absenteeism']);
    Route::get('/analytics/compliance', [AnalyticsController::class, 'compliance']);
    Route::get('/analytics/payroll', [AnalyticsController::class, 'payroll']);
    Route::get('/analytics/performance', [AnalyticsController::class, 'performance']);
    Route::get('/analytics/predictive', [AnalyticsController::class, 'predictive']);

    // Alert Routes
    Route::get('/alerts/high-risk', [AnalyticsController::class, 'highRiskAlerts']);
    Route::get('/alerts/compliance', [AnalyticsController::class, 'complianceAlerts']);
    Route::get('/alerts/expiring', [AnalyticsController::class, 'expiringAlerts']);

    // Report Routes
    Route::get('/reports/employees', [AnalyticsController::class, 'employeeReport'])->middleware('permission:reports.export');
    Route::get('/reports/payroll', [AnalyticsController::class, 'payrollReport'])->middleware('permission:reports.export');
    Route::get('/reports/compliance', [AnalyticsController::class, 'complianceReport'])->middleware('permission:reports.export');
    Route::get('/reports/discipline', [AnalyticsController::class, 'disciplineReport'])->middleware('permission:reports.export');
    Route::get('/reports/attendance', [AnalyticsController::class, 'attendanceReport'])->middleware('permission:reports.export');

    // User Management Routes (Admin only) - TODO: Create UserController
    /*
    Route::middleware('role:super_admin,hr_admin')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::get('/users/{user}', [UserController::class, 'show']);
        Route::put('/users/{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'delete']);
        Route::post('/users/{user}/roles', [UserController::class, 'assignRole']);
        Route::delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole']);
    });
    */

    // Role and Permission Routes - TODO: Create RoleController and PermissionController
    /*
    Route::get('/roles', [RoleController::class, 'index']);
    Route::post('/roles', [RoleController::class, 'store'])->middleware('role:super_admin');
    Route::get('/roles/{role}', [RoleController::class, 'show']);
    Route::put('/roles/{role}', [RoleController::class, 'update'])->middleware('role:super_admin');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->middleware('role:super_admin');
    
    Route::get('/permissions', [PermissionController::class, 'index']);
    Route::post('/permissions', [PermissionController::class, 'store'])->middleware('role:super_admin');
    Route::get('/permissions/{permission}', [PermissionController::class, 'show']);
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->middleware('role:super_admin');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->middleware('role:super_admin');
    */

    // Audit Trail Routes - TODO: Create AuditLogController
    /*
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->middleware('permission:audit_logs.read');
    Route::get('/audit-logs/{auditLog}', [AuditLogController::class, 'show'])->middleware('permission:audit_logs.read');
    Route::get('/audit-logs/analytics', [AuditLogController::class, 'analytics'])->middleware('permission:audit_logs.read');
    */

    // System Settings Routes - TODO: Create SettingsController
    /*
    Route::get('/settings', [SettingsController::class, 'index'])->middleware('role:super_admin');
    Route::put('/settings', [SettingsController::class, 'update'])->middleware('role:super_admin');
    Route::get('/settings/labor-laws', [SettingsController::class, 'laborLaws'])->middleware('role:hr_admin');
    */
});

// Public Routes (for things like password reset, email verification, etc.)
Route::prefix('public')->group(function () {
    // Add public routes here
});
