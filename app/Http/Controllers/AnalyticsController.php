<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Discipline;
use App\Models\Compliance;
use App\Models\Attendance;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Get dashboard analytics.
     */
    public function dashboard(Request $request): JsonResponse
    {
        $companyId = $request->get('company_id');
        
        if (!$companyId) {
            return response()->json([
                'success' => false,
                'message' => 'Company ID is required'
            ], 400);
        }

        $company = Company::find($companyId);

        $analytics = [
            'overview' => $this->getOverviewAnalytics($company),
            'employees' => $this->getEmployeeAnalytics($company),
            'payroll' => $this->getPayrollAnalytics($company),
            'discipline' => $this->getDisciplineAnalytics($company),
            'compliance' => $this->getComplianceAnalytics($company),
            'attendance' => $this->getAttendanceAnalytics($company),
            'financial' => $this->getFinancialAnalytics($company),
        ];

        return response()->json([
            'success' => true,
            'data' => $analytics
        ]);
    }

    /**
     * Get overview analytics.
     */
    private function getOverviewAnalytics(Company $company): array
    {
        return [
            'total_employees' => $company->employees()->count(),
            'active_employees' => $company->employees()->where('is_active', true)->count(),
            'total_departments' => $company->departments()->count(),
            'employee_growth' => $this->getEmployeeGrowth($company),
            'turnover_rate' => $this->getTurnoverRate($company),
            'avg_tenure' => $this->getAverageTenure($company),
            'gender_distribution' => $this->getGenderDistribution($company),
        ];
    }

    /**
     * Get employee analytics.
     */
    private function getEmployeeAnalytics(Company $company): array
    {
        return [
            'by_employment_category' => $company->employees()
                ->selectRaw('employment_category, COUNT(*) as count')
                ->groupBy('employment_category')
                ->get(),
            'by_department' => $company->employees()
                ->selectRaw('department, COUNT(*) as count')
                ->groupBy('department')
                ->get(),
            'by_age_group' => $this->getAgeDistribution($company),
            'by_experience' => $this->getExperienceDistribution($company),
            'by_location' => $company->employees()
                ->selectRaw('region, COUNT(*) as count')
                ->groupBy('region')
                ->get(),
            'non_citizens' => $company->employees()
                ->where('citizenship', '!=', 'tanzanian')
                ->count(),
        ];
    }

    /**
     * Get payroll analytics.
     */
    private function getPayrollAnalytics(Company $company): array
    {
        $currentMonth = now()->format('Y-m');
        
        return [
            'monthly_payroll_cost' => Payroll::where('company_id', $company->id)
                ->where('pay_period', $currentMonth)
                ->sum('net_pay'),
            'ytd_payroll_cost' => Payroll::where('company_id', $company->id)
                ->whereYear('pay_period', now()->year)
                ->sum('net_pay'),
            'avg_monthly_salary' => $company->employees()
                ->where('is_active', true)
                ->avg('basic_salary'),
            'statutory_contributions' => [
                'paye' => Payroll::where('company_id', $company->id)
                    ->whereYear('pay_period', now()->year)
                    ->sum('paye_deduction'),
                'nssf' => Payroll::where('company_id', $company->id)
                    ->whereYear('pay_period', now()->year)
                    ->sum('nssf_deduction'),
                'wcf' => Payroll::where('company_id', $company->id)
                    ->whereYear('pay_period', now()->year)
                    ->sum('wcf_deduction'),
                'sdl' => Payroll::where('company_id', $company->id)
                    ->whereYear('pay_period', now()->year)
                    ->sum('sdl_deduction'),
                'heslb' => Payroll::where('company_id', $company->id)
                    ->whereYear('pay_period', now()->year)
                    ->sum('heslb_deduction'),
            ],
            'salary_ranges' => $this->getSalaryRanges($company),
            'overtime_trends' => $this->getOvertimeTrends($company),
        ];
    }

    /**
     * Get discipline analytics.
     */
    private function getDisciplineAnalytics(Company $company): array
    {
        return [
            'total_cases' => Discipline::where('company_id', $company->id)->count(),
            'by_severity' => Discipline::where('company_id', $company->id)
                ->selectRaw('severity_level, COUNT(*) as count')
                ->groupBy('severity_level')
                ->get(),
            'by_status' => Discipline::where('company_id', $company->id)
                ->selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get(),
            'by_type' => Discipline::where('company_id', $company->id)
                ->selectRaw('case_type, COUNT(*) as count')
                ->groupBy('case_type')
                ->get(),
            'risk_distribution' => Discipline::where('company_id', $company->id)
                ->selectRaw('risk_score, COUNT(*) as count')
                ->groupBy('risk_score')
                ->get(),
            'resolution_time' => $this->getAverageResolutionTime($company),
            'hr_admin_approval_rate' => Discipline::where('company_id', $company->id)
                ->whereNotNull('hr_admin_approval')
                ->count() / max(Discipline::where('company_id', $company->id)->count(), 1) * 100,
        ];
    }

    /**
     * Get compliance analytics.
     */
    private function getComplianceAnalytics(Company $company): array
    {
        return [
            'total_compliances' => Compliance::where('company_id', $company->id)->count(),
            'by_status' => Compliance::where('company_id', $company->id)
                ->selectRaw('status, COUNT(*) as count')
                ->groupBy('status')
                ->get(),
            'by_risk_level' => Compliance::where('company_id', $company->id)
                ->selectRaw('risk_level, COUNT(*) as count')
                ->groupBy('risk_level')
                ->get(),
            'by_type' => Compliance::where('company_id', $company->id)
                ->selectRaw('compliance_type, COUNT(*) as count')
                ->groupBy('compliance_type')
                ->get(),
            'overdue_items' => Compliance::where('company_id', $company->id)
                ->where('due_date', '<', now())
                ->where('status', '!=', 'resolved')
                ->count(),
            'upcoming_deadlines' => Compliance::where('company_id', $company->id)
                ->whereBetween('due_date', [now(), now()->addDays(30)])
                ->where('status', '!=', 'resolved')
                ->count(),
            'compliance_score' => $this->getComplianceScore($company),
        ];
    }

    /**
     * Get attendance analytics.
     */
    private function getAttendanceAnalytics(Company $company): array
    {
        $currentMonth = now()->format('Y-m');
        
        return [
            'monthly_attendance_rate' => $this->getAttendanceRate($company, $currentMonth),
            'average_daily_hours' => Attendance::where('company_id', $company->id)
                ->whereMonth('date', now()->month)
                ->avg('total_hours'),
            'overtime_hours' => Attendance::where('company_id', $company->id)
                ->whereMonth('date', now()->month)
                ->sum('overtime_hours'),
            'absenteeism_rate' => $this->getAbsenteeismRate($company),
            'late_arrivals' => Attendance::where('company_id', $company->id)
                ->whereMonth('date', now()->month)
                ->where('status', 'late')
                ->count(),
            'by_day' => $this->getAttendanceByDay($company),
            'compliance_rate' => Attendance::where('company_id', $company->id)
                ->where('compliance', true)
                ->count() / max(Attendance::where('company_id', $company->id)->count(), 1) * 100,
        ];
    }

    /**
     * Get financial analytics.
     */
    private function getFinancialAnalytics(Company $company): array
    {
        return [
            'payroll_costs' => [
                'current_month' => Payroll::where('company_id', $company->id)
                    ->where('pay_period', now()->format('Y-m'))
                    ->sum('net_pay'),
                'ytd' => Payroll::where('company_id', $company->id)
                    ->whereYear('pay_period', now()->year)
                    ->sum('net_pay'),
                'last_12_months' => $this->get12MonthPayrollCost($company),
            ],
            'cost_per_employee' => Payroll::where('company_id', $company->id)
                ->where('pay_period', now()->format('Y-m'))
                ->sum('net_pay') / max($company->employees()->where('is_active', true)->count(), 1),
            'benefits_cost' => $this->getBenefitsCost($company),
            'training_investment' => $this->getTrainingInvestment($company),
        ];
    }

    /**
     * Helper methods for analytics calculations
     */
    private function getEmployeeGrowth(Company $company): array
    {
        $growth = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = $company->employees()
                ->whereMonth('created_at', $month)
                ->count();
            $growth[] = [
                'month' => $month->format('Y-m'),
                'count' => $count
            ];
        }
        return $growth;
    }

    private function getTurnoverRate(Company $company): float
    {
        $totalEmployees = $company->employees()->count();
        if ($totalEmployees === 0) return 0;
        
        $terminatedLastYear = $company->employees()
            ->where('status', 'terminated')
            ->where('termination_date', '>=', now()->subYear())
            ->count();
            
        return ($terminatedLastYear / $totalEmployees) * 100;
    }

    private function getAverageTenure(Company $company): float
    {
        return $company->employees()
            ->whereNotNull('hire_date')
            ->avg('hire_date')
            ->diffInDays(now()) / 365;
    }

    private function getGenderDistribution(Company $company): array
    {
        return [
            'male' => $company->employees()->where('gender', 'male')->count(),
            'female' => $company->employees()->where('gender', 'female')->count(),
            'other' => $company->employees()->whereNotIn('gender', ['male', 'female'])->count(),
        ];
    }

    private function getAgeDistribution(Company $company): array
    {
        $distribution = [
            '18-25' => 0,
            '26-35' => 0,
            '36-45' => 0,
            '46-55' => 0,
            '56+' => 0,
        ];

        foreach ($company->employees as $employee) {
            $age = $employee->date_of_birth ? Carbon::parse($employee->date_of_birth)->age : 0;
            
            if ($age >= 18 && $age <= 25) $distribution['18-25']++;
            elseif ($age >= 26 && $age <= 35) $distribution['26-35']++;
            elseif ($age >= 36 && $age <= 45) $distribution['36-45']++;
            elseif ($age >= 46 && $age <= 55) $distribution['46-55']++;
            elseif ($age > 55) $distribution['56+']++;
        }

        return $distribution;
    }

    private function getExperienceDistribution(Company $company): array
    {
        return [
            '0-2 years' => $company->employees()->where('experience_years', '<=', 2)->count(),
            '3-5 years' => $company->employees()->where('experience_years', '>', 2)->where('experience_years', '<=', 5)->count(),
            '6-10 years' => $company->employees()->where('experience_years', '>', 5)->where('experience_years', '<=', 10)->count(),
            '10+ years' => $company->employees()->where('experience_years', '>', 10)->count(),
        ];
    }

    private function getSalaryRanges(Company $company): array
    {
        $salaries = $company->employees()->pluck('basic_salary')->toArray();
        
        return [
            '0-100k' => count(array_filter($salaries, fn($s) => $s <= 100000)),
            '100k-300k' => count(array_filter($salaries, fn($s) => $s > 100000 && $s <= 300000)),
            '300k-500k' => count(array_filter($salaries, fn($s) => $s > 300000 && $s <= 500000)),
            '500k-1M' => count(array_filter($salaries, fn($s) => $s > 500000 && $s <= 1000000)),
            '1M+' => count(array_filter($salaries, fn($s) => $s > 1000000)),
        ];
    }

    private function getOvertimeTrends(Company $company): array
    {
        $trends = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $overtime = Attendance::where('company_id', $company->id)
                ->whereMonth('date', $month)
                ->sum('overtime_hours');
            $trends[] = [
                'month' => $month->format('Y-m'),
                'overtime_hours' => $overtime
            ];
        }
        return $trends;
    }

    private function getAverageResolutionTime(Company $company): float
    {
        $resolved = Discipline::where('company_id', $company->id)
            ->where('status', 'resolved')
            ->whereNotNull('created_at')
            ->whereNotNull('resolved_at')
            ->get();

        if ($resolved->isEmpty()) return 0;

        $totalDays = $resolved->sum(function ($case) {
            return Carbon::parse($case->resolved_at)->diffInDays($case->created_at);
        });

        return $totalDays / $resolved->count();
    }

    private function getComplianceScore(Company $company): float
    {
        $compliances = Compliance::where('company_id', $company->id)->get();
        
        if ($compliances->isEmpty()) return 100;

        $totalScore = $compliances->sum('score');
        $maxPossibleScore = $compliances->count() * 100;

        return ($totalScore / $maxPossibleScore) * 100;
    }

    private function getAttendanceRate(Company $company, string $month): float
    {
        $workingDays = Carbon::parse($month . '-01')->daysInMonth();
        $totalPossible = $company->employees()->count() * $workingDays;
        
        if ($totalPossible === 0) return 0;

        $presentDays = Attendance::where('company_id', $company->id)
            ->whereMonth('date', Carbon::parse($month)->month)
            ->whereYear('date', Carbon::parse($month)->year)
            ->where('status', 'present')
            ->count();
        
        return ($presentDays / $totalPossible) * 100;
    }

    private function getAbsenteeismRate(Company $company): float
    {
        $currentMonth = now()->format('Y-m');
        $workingDays = Carbon::parse($currentMonth . '-01')->daysInMonth();
        $totalPossible = $company->employees()->count() * $workingDays;
        
        if ($totalPossible === 0) return 0;

        $absentDays = Attendance::where('company_id', $company->id)
            ->whereMonth('date', now()->month)
            ->where('status', 'absent')
            ->count();
        
        return ($absentDays / $totalPossible) * 100;
    }

    private function getAttendanceByDay(Company $company): array
    {
        $attendance = [];
        for ($day = 1; $day <= now()->daysInMonth(); $day++) {
            $date = now()->format('Y-m-' . str_pad($day, 2, '0', STR_PAD_LEFT));
            $attendance[] = [
                'date' => $date,
                'present' => Attendance::where('company_id', $company->id)
                    ->where('date', $date)
                    ->where('status', 'present')
                    ->count(),
                'absent' => Attendance::where('company_id', $company->id)
                    ->where('date', $date)
                    ->where('status', 'absent')
                    ->count(),
                'late' => Attendance::where('company_id', $company->id)
                    ->where('date', $date)
                    ->where('status', 'late')
                    ->count(),
            ];
        }
        return $attendance;
    }

    private function get12MonthPayrollCost(Company $company): float
    {
        $total = 0;
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $total += Payroll::where('company_id', $company->id)
                ->where('pay_period', $month)
                ->sum('net_pay');
        }
        return $total;
    }

    private function getBenefitsCost(Company $company): float
    {
        // This would calculate total benefits cost
        // For now, return a placeholder
        return 0;
    }

    private function getTrainingInvestment(Company $company): float
    {
        // This would calculate total training investment
        // For now, return a placeholder
        return 0;
    }

    /**
     * Export analytics data.
     */
    public function export(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:dashboard,employees,payroll,discipline,compliance,attendance',
            'format' => 'required|in:json,csv,xlsx',
            'period' => 'required|in:week,month,year',
            'company_id' => 'required|exists:companies,id',
        ]);

        // Implementation would depend on the specific export requirements
        return response()->json([
            'success' => true,
            'message' => 'Export functionality not yet implemented',
        ]);
    }
}
