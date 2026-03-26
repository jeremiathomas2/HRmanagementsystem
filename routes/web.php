<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

// Public routes (no authentication required)
Route::get('/', function () {
    return view('login');
})->name('login');

Route::get('/login', function () {
    return view('login');
})->name('login.page');

Route::get('/splash', function () {
    return view('splash');
})->name('splash');

// Login process route (accessible without auth)
Route::post('/login/process', function (Request $request) {
    $credentials = $request->validate([
        'username' => 'required|string|max:255',
        'password' => 'required|string|min:6',
        'remember' => 'boolean'
    ]);

    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();
        
        return redirect()->intended('dashboard')
            ->with('success', 'Login successful!');
    }

    // If login fails, redirect back with error
    return redirect()->back()
        ->withErrors([
            'username' => 'The provided credentials do not match our records.',
            'password' => 'The provided password is incorrect.',
        ])
        ->withInput($request->only('username', 'remember'));
})->name('login.process');

// Protected routes (authentication required)
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Logout route
    Route::post('/logout', function () {
        Auth::logout();
        
        Session::flash('success', 'You have been logged out successfully.');
        
        return redirect()->route('login');
    })->name('logout');
    
    // Employee Management routes
    Route::get('/employees', function () {
        return view('employees.index');
    })->name('employees');
    
    Route::get('/employees/add', function () {
        return view('employees.create');
    })->name('employees.add');
    
    Route::get('/employees/contracts', function () {
        return view('employees.contracts');
    })->name('employees.contracts');
    
    Route::get('/employees/departments', function () {
        return view('employees.departments');
    })->name('employees.departments');
    
    // Payroll Management routes
    Route::get('/payroll', function () {
        return view('payroll.index');
    })->name('payroll');
    
    Route::get('/payroll/history', function () {
        return view('payroll.history');
    })->name('payroll.history');
    
    Route::get('/payroll/statutory', function () {
        return view('payroll.statutory');
    })->name('payroll.statutory');
    
    Route::get('/payroll/reports', function () {
        return view('payroll.reports');
    })->name('payroll.reports');
    
    // Discipline Management routes
    Route::get('/discipline', function () {
        return view('discipline.index');
    })->name('discipline');
    
    Route::get('/discipline/new', function () {
        return view('discipline.create');
    })->name('discipline.new');
    
    Route::get('/discipline/hearings', function () {
        return view('discipline.hearings');
    })->name('discipline.hearings');
    
    Route::get('/discipline/actions', function () {
        return view('discipline.actions');
    })->name('discipline.actions');
    
    // Compliance Management routes
    Route::get('/compliance', function () {
        return view('compliance.index');
    })->name('compliance');
    
    Route::get('/compliance/inspections', function () {
        return view('compliance.inspections');
    })->name('compliance.inspections');
    
    Route::get('/compliance/licenses', function () {
        return view('compliance.licenses');
    })->name('compliance.licenses');
    
    Route::get('/compliance/audits', function () {
        return view('compliance.audits');
    })->name('compliance.audits');
    
    // Attendance Management routes
    Route::get('/attendance', function () {
        return view('attendance.index');
    })->name('attendance');
    
    Route::get('/attendance/schedule', function () {
        return view('attendance.schedule');
    })->name('attendance.schedule');
    
    Route::get('/attendance/overtime', function () {
        return view('attendance.overtime');
    })->name('attendance.overtime');
    
    Route::get('/attendance/reports', function () {
        return view('attendance.reports');
    })->name('attendance.reports');
    
    // Leave Management routes
    Route::get('/leave', function () {
        return view('leave.index');
    })->name('leave');
    
    Route::get('/leave/balances', function () {
        return view('leave.balances');
    })->name('leave.balances');
    
    Route::get('/leave/policy', function () {
        return view('leave.policy');
    })->name('leave.policy');
    
    Route::get('/leave/calendar', function () {
        return view('leave.calendar');
    })->name('leave.calendar');
    
    // Recruitment Management routes
    Route::get('/recruitment', function () {
        return view('recruitment.index');
    })->name('recruitment');
    
    Route::get('/recruitment/applications', function () {
        return view('recruitment.applications');
    })->name('recruitment.applications');
    
    Route::get('/recruitment/interviews', function () {
        return view('recruitment.interviews');
    })->name('recruitment.interviews');
    
    Route::get('/recruitment/onboarding', function () {
        return view('recruitment.onboarding');
    })->name('recruitment.onboarding');
    
    // Performance Management routes
    Route::get('/performance', function () {
        return view('performance.index');
    })->name('performance');
    
    Route::get('/performance/goals', function () {
        return view('performance.goals');
    })->name('performance.goals');
    
    Route::get('/performance/feedback', function () {
        return view('performance.feedback');
    })->name('performance.feedback');
    
    Route::get('/performance/analytics', function () {
        return view('performance.analytics');
    })->name('performance.analytics');
    
    // Training Management routes
    Route::get('/training', function () {
        return view('training.index');
    })->name('training');
    
    Route::get('/training/courses', function () {
        return view('training.courses');
    })->name('training.courses');
    
    Route::get('/training/enrollments', function () {
        return view('training.enrollments');
    })->name('training.enrollments');
    
    Route::get('/training/certificates', function () {
        return view('training.certificates');
    })->name('training.certificates');
    
    // System Management routes
    Route::get('/system', function () {
        return view('system.index');
    })->name('system');
    
    Route::get('/system/settings', function () {
        return view('system.settings');
    })->name('system.settings');
    
    Route::get('/system/users', function () {
        return view('system.users');
    })->name('system.users');
    
    Route::get('/system/roles', function () {
        return view('system.roles');
    })->name('system.roles');
    
    Route::get('/system/backup', function () {
        return view('system.backup');
    })->name('system.backup');
    
    Route::get('/system/logs', function () {
        return view('system.logs');
    })->name('system.logs');
    
    Route::get('/system/maintenance', function () {
        return view('system.maintenance');
    })->name('system.maintenance');
    
    Route::get('/system/integrations', function () {
        return view('system.integrations');
    })->name('system.integrations');
    
    Route::get('/system/security', function () {
        return view('system.security');
    })->name('system.security');
    
    // Convenience redirects
    Route::get('/settings', function () {
        return redirect()->route('system.settings');
    })->name('settings.redirect');
    
    Route::get('/users', function () {
        return redirect()->route('system.users');
    })->name('users.redirect');
    
    Route::get('/roles', function () {
        return redirect()->route('system.roles');
    })->name('roles.redirect');
    
    // Catch-all route for SPA-like behavior
    Route::get('/{any?}', function () {
        return view('app');
    })->where('any', '^(?!login|dashboard|splash).*');
});
