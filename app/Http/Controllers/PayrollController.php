<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class PayrollController extends Controller
{
    // Tanzania PAYE tax bands (2024 rates)
    private const PAYE_BANDS = [
        ['min' => 0, 'max' => 270000, 'rate' => 0, 'amount' => 0],
        ['min' => 270001, 'max' => 520000, 'rate' => 8, 'amount' => 0],
        ['min' => 520001, 'max' => 760000, 'rate' => 20, 'amount' => 20000],
        ['min' => 760001, 'max' => 1000000, 'rate' => 30, 'amount' => 68000],
        ['min' => 1000001, 'max' => PHP_FLOAT_MAX, 'rate' => 36, 'amount' => 140000],
    ];

    // NSSF rates (2024)
    private const NSSF_RATE = 0.10; // 10% of gross salary
    private const NSSF_EMPLOYEE_RATE = 0.05; // 5% employee contribution
    private const NSSF_EMPLOYER_RATE = 0.05; // 5% employer contribution
    private const NSSF_MAX_SALARY = 1000000; // Maximum salary for NSSF calculation

    // WCF rates (2024)
    private const WCF_EMPLOYEE_RATE = 0.01; // 1% employee contribution
    private const WCF_EMPLOYER_RATE = 0.01; // 1% employer contribution
    private const WCF_MAX_SALARY = 1000000; // Maximum salary for WCF calculation

    /**
     * Display a listing of payrolls.
     */
    public function index(Request $request)
    {
        $query = Payroll::with(['employee', 'company'])
            ->where('company_id', $request->user()->company_id);

        // Apply filters
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('payroll_number', 'like', '%' . $request->search . '%')
                  ->orWhereHas('employee', function($subQ) use ($request) {
                      $subQ->where('first_name', 'like', '%' . $request->search . '%')
                           ->orWhere('last_name', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->pay_period_start) {
            $query->where('pay_period_start', '>=', $request->pay_period_start);
        }

        if ($request->pay_period_end) {
            $query->where('pay_period_end', '<=', $request->pay_period_end);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $payrolls = $query->orderBy('payment_date', 'desc')->paginate(20);

        return response()->json($payrolls);
    }

    /**
     * Store a newly created payroll.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'pay_period_start' => 'required|date',
            'pay_period_end' => 'required|date|after:pay_period_start',
            'payment_date' => 'required|date|after_or_equal:pay_period_end',
            'payment_frequency' => 'required|in:monthly,bi_weekly,weekly',
            'basic_salary' => 'required|numeric|min:0',
            'house_allowance' => 'nullable|numeric|min:0',
            'transport_allowance' => 'nullable|numeric|min:0',
            'medical_allowance' => 'nullable|numeric|min:0',
            'other_allowances' => 'nullable|numeric|min:0',
            'overtime_pay' => 'nullable|numeric|min:0',
            'holiday_pay' => 'nullable|numeric|min:0',
            'leave_encashment' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'commission' => 'nullable|numeric|min:0',
            'other_earnings' => 'nullable|numeric|min:0',
            'heslb_deduction' => 'nullable|numeric|min:0',
            'pension_employee' => 'nullable|numeric|min:0',
            'pension_employer' => 'nullable|numeric|min:0',
            'loan_deduction' => 'nullable|numeric|min:0',
            'salary_advance' => 'nullable|numeric|min:0',
            'other_deductions' => 'nullable|numeric|min:0',
            'payment_method' => 'required|string|max:100',
            'bank_account' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $data = $validator->validated();
        $data['company_id'] = $request->user()->company_id;
        $data['payroll_number'] = $this->generatePayrollNumber($request->user()->company_id);

        // Calculate payroll
        $calculatedPayroll = $this->calculatePayroll($data, $request->employee_id);
        
        // Merge calculated values with input data
        $data = array_merge($data, $calculatedPayroll);

        // Check compliance
        $complianceChecks = $this->checkPayrollCompliance($data);
        $data['compliance_checks'] = $complianceChecks;
        $data['compliance_status'] = $complianceChecks['is_compliant'] ? 'compliant' : 'needs_review';

        $payroll = Payroll::create($data);

        return response()->json([
            'message' => 'Payroll created successfully',
            'payroll' => $payroll->load(['employee', 'company'])
        ], 201);
    }

    /**
     * Display the specified payroll.
     */
    public function show(Request $request, Payroll $payroll)
    {
        if ($payroll->company_id !== $request->user()->company_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($payroll->load(['employee', 'company']));
    }

    /**
     * Update the specified payroll.
     */
    public function update(Request $request, Payroll $payroll)
    {
        if ($payroll->company_id !== $request->user()->company_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($payroll->status === 'paid') {
            return response()->json(['message' => 'Cannot update paid payroll'], 422);
        }

        $validator = Validator::make($request->all(), [
            'basic_salary' => 'sometimes|required|numeric|min:0',
            'house_allowance' => 'sometimes|nullable|numeric|min:0',
            'transport_allowance' => 'sometimes|nullable|numeric|min:0',
            'medical_allowance' => 'sometimes|nullable|numeric|min:0',
            'other_allowances' => 'sometimes|nullable|numeric|min:0',
            'overtime_pay' => 'sometimes|nullable|numeric|min:0',
            'holiday_pay' => 'sometimes|nullable|numeric|min:0',
            'leave_encashment' => 'sometimes|nullable|numeric|min:0',
            'bonus' => 'sometimes|nullable|numeric|min:0',
            'commission' => 'sometimes|nullable|numeric|min:0',
            'other_earnings' => 'sometimes|nullable|numeric|min:0',
            'heslb_deduction' => 'sometimes|nullable|numeric|min:0',
            'pension_employee' => 'sometimes|nullable|numeric|min:0',
            'pension_employer' => 'sometimes|nullable|numeric|min:0',
            'loan_deduction' => 'sometimes|nullable|numeric|min:0',
            'salary_advance' => 'sometimes|nullable|numeric|min:0',
            'other_deductions' => 'sometimes|nullable|numeric|min:0',
            'status' => 'sometimes|required|in:draft,calculated,approved,processed,paid,cancelled',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $data = $validator->validated();

        // Recalculate if financial values changed
        if ($this->hasFinancialChanges($data)) {
            $calculatedPayroll = $this->calculatePayroll($data, $payroll->employee_id);
            $data = array_merge($data, $calculatedPayroll);
            
            // Recheck compliance
            $complianceChecks = $this->checkPayrollCompliance($data);
            $data['compliance_checks'] = $complianceChecks;
            $data['compliance_status'] = $complianceChecks['is_compliant'] ? 'compliant' : 'needs_review';
        }

        $payroll->update($data);

        return response()->json([
            'message' => 'Payroll updated successfully',
            'payroll' => $payroll->load(['employee', 'company'])
        ]);
    }

    /**
     * Process payroll batch.
     */
    public function processBatch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employee_ids' => 'required|array',
            'employee_ids.*' => 'exists:employees,id',
            'pay_period_start' => 'required|date',
            'pay_period_end' => 'required|date|after:pay_period_start',
            'payment_date' => 'required|date|after_or_equal:pay_period_end',
            'payment_frequency' => 'required|in:monthly,bi_weekly,weekly',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $data = $validator->validated();
        $results = [];
        $errors = [];

        foreach ($data['employee_ids'] as $employeeId) {
            try {
                $employee = Employee::find($employeeId);
                
                $payrollData = [
                    'employee_id' => $employeeId,
                    'company_id' => $request->user()->company_id,
                    'pay_period_start' => $data['pay_period_start'],
                    'pay_period_end' => $data['pay_period_end'],
                    'payment_date' => $data['payment_date'],
                    'payment_frequency' => $data['payment_frequency'],
                    'basic_salary' => $employee->basic_salary,
                    'payroll_number' => $this->generatePayrollNumber($request->user()->company_id),
                ];

                // Calculate payroll
                $calculatedPayroll = $this->calculatePayroll($payrollData, $employeeId);
                $payrollData = array_merge($payrollData, $calculatedPayroll);

                // Check compliance
                $complianceChecks = $this->checkPayrollCompliance($payrollData);
                $payrollData['compliance_checks'] = $complianceChecks;
                $payrollData['compliance_status'] = $complianceChecks['is_compliant'] ? 'compliant' : 'needs_review';

                $payroll = Payroll::create($payrollData);
                $results[] = $payroll->load(['employee']);

            } catch (\Exception $e) {
                $errors[] = [
                    'employee_id' => $employeeId,
                    'error' => $e->getMessage()
                ];
            }
        }

        return response()->json([
            'message' => 'Batch processing completed',
            'processed' => count($results),
            'errors' => count($errors),
            'results' => $results,
            'error_details' => $errors
        ]);
    }

    /**
     * Generate statutory reports.
     */
    public function generateReports(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'report_type' => 'required|in:paye_return,nssf_schedule,wcf_declaration,sdl_summary,employer_cost',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after:period_start',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $data = $validator->validated();
        $companyId = $request->user()->company_id;

        $report = match($data['report_type']) {
            'paye_return' => $this->generatePAYEReturn($companyId, $data['period_start'], $data['period_end']),
            'nssf_schedule' => $this->generateNSSFSchedule($companyId, $data['period_start'], $data['period_end']),
            'wcf_declaration' => $this->generateWCFDeclaration($companyId, $data['period_start'], $data['period_end']),
            'sdl_summary' => $this->generateSDLSummary($companyId, $data['period_start'], $data['period_end']),
            'employer_cost' => $this->generateEmployerCostAnalysis($companyId, $data['period_start'], $data['period_end']),
            default => ['error' => 'Invalid report type']
        };

        return response()->json($report);
    }

    /**
     * Calculate payroll with Tanzanian statutory deductions.
     */
    private function calculatePayroll(array $data, int $employeeId): array
    {
        $employee = Employee::find($employeeId);
        
        // Calculate gross pay
        $grossPay = $data['basic_salary'] 
                  + ($data['house_allowance'] ?? 0)
                  + ($data['transport_allowance'] ?? 0)
                  + ($data['medical_allowance'] ?? 0)
                  + ($data['other_allowances'] ?? 0)
                  + ($data['overtime_pay'] ?? 0)
                  + ($data['holiday_pay'] ?? 0)
                  + ($data['leave_encashment'] ?? 0)
                  + ($data['bonus'] ?? 0)
                  + ($data['commission'] ?? 0)
                  + ($data['other_earnings'] ?? 0);

        // Calculate PAYE tax
        $payeTax = $this->calculatePAYE($grossPay);
        $taxableIncome = $grossPay - 270000; // First 270,000 is tax-free
        if ($taxableIncome < 0) $taxableIncome = 0;
        
        $taxBand = $this->getTaxBand($grossPay);
        $taxRate = $this->getTaxRate($grossPay);

        // Calculate NSSF contributions
        $nssfBase = min($grossPay, self::NSSF_MAX_SALARY);
        $nssfEmployee = $nssfBase * self::NSSF_EMPLOYEE_RATE;
        $nssfEmployer = $nssfBase * self::NSSF_EMPLOYER_RATE;

        // Calculate WCF contributions
        $wcfBase = min($grossPay, self::WCF_MAX_SALARY);
        $wcfEmployee = $wcfBase * self::WCF_EMPLOYEE_RATE;
        $wcfEmployer = $wcfBase * self::WCF_EMPLOYER_RATE;

        // Calculate total deductions
        $totalDeductions = $payeTax 
                          + $nssfEmployee 
                          + $wcfEmployee 
                          + ($data['heslb_deduction'] ?? 0)
                          + ($data['pension_employee'] ?? 0)
                          + ($data['loan_deduction'] ?? 0)
                          + ($data['salary_advance'] ?? 0)
                          + ($data['other_deductions'] ?? 0);

        // Calculate net pay and total cost to employer
        $netPay = $grossPay - $totalDeductions;
        $totalCostToEmployer = $grossPay + $nssfEmployer + $wcfEmployer + ($data['pension_employer'] ?? 0);

        return [
            'gross_pay' => $grossPay,
            'paye_tax' => $payeTax,
            'nssf_employee' => $nssfEmployee,
            'nssf_employer' => $nssfEmployer,
            'wcf_employee' => $wcfEmployee,
            'wcf_employer' => $wcfEmployer,
            'total_deductions' => $totalDeductions,
            'net_pay' => $netPay,
            'total_cost_to_employer' => $totalCostToEmployer,
            'tax_band' => $taxBand,
            'taxable_income' => $taxableIncome,
            'tax_rate' => $taxRate,
            'tax_calculation_breakdown' => $this->getTaxCalculationBreakdown($grossPay),
            'allowance_breakdown' => $this->getAllowanceBreakdown($data),
            'deduction_breakdown' => $this->getDeductionBreakdown($data, $payeTax, $nssfEmployee, $wcfEmployee),
        ];
    }

    /**
     * Calculate PAYE tax using Tanzanian tax bands.
     */
    private function calculatePAYE(float $grossPay): float
    {
        $taxableIncome = max(0, $grossPay - 270000); // First 270,000 is tax-free
        
        foreach (self::PAYE_BANDS as $band) {
            if ($taxableIncome > $band['min'] && $taxableIncome <= $band['max']) {
                $excess = $taxableIncome - $band['min'];
                return ($excess * $band['rate'] / 100) + $band['amount'];
            }
        }
        
        return 0;
    }

    /**
     * Get tax band for given income.
     */
    private function getTaxBand(float $grossPay): string
    {
        $taxableIncome = max(0, $grossPay - 270000);
        
        foreach (self::PAYE_BANDS as $index => $band) {
            if ($taxableIncome > $band['min'] && $taxableIncome <= $band['max']) {
                return 'Band ' . ($index + 1);
            }
        }
        
        return 'Band 1';
    }

    /**
     * Get tax rate for given income.
     */
    private function getTaxRate(float $grossPay): float
    {
        $taxableIncome = max(0, $grossPay - 270000);
        
        foreach (self::PAYE_BANDS as $band) {
            if ($taxableIncome > $band['min'] && $taxableIncome <= $band['max']) {
                return $band['rate'] / 100;
            }
        }
        
        return 0;
    }

    /**
     * Check payroll compliance.
     */
    private function checkPayrollCompliance(array $data): array
    {
        $issues = [];
        $warnings = [];

        // Check minimum wage compliance
        if ($data['basic_salary'] < 300000) { // Example minimum wage
            $warnings[] = 'Basic salary is below recommended minimum wage';
        }

        // Check NSSF compliance
        if ($data['nssf_employee'] === 0 && $data['gross_pay'] > 0) {
            $issues[] = 'NSSF employee contribution is missing';
        }

        // Check WCF compliance
        if ($data['wcf_employee'] === 0 && $data['gross_pay'] > 0) {
            $issues[] = 'WCF employee contribution is missing';
        }

        // Check PAYE compliance
        if ($data['paye_tax'] === 0 && $data['gross_pay'] > 270000) {
            $issues[] = 'PAYE tax calculation may be incorrect';
        }

        return [
            'is_compliant' => empty($issues),
            'issues' => $issues,
            'warnings' => $warnings,
        ];
    }

    /**
     * Generate payroll number.
     */
    private function generatePayrollNumber(int $companyId): string
    {
        $prefix = 'PAY';
        $sequence = Payroll::where('company_id', $companyId)->count() + 1;
        $yearMonth = date('Ym');
        
        return $prefix . '-' . $yearMonth . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Check if financial values changed.
     */
    private function hasFinancialChanges(array $data): bool
    {
        $financialFields = [
            'basic_salary', 'house_allowance', 'transport_allowance', 'medical_allowance',
            'other_allowances', 'overtime_pay', 'holiday_pay', 'leave_encashment',
            'bonus', 'commission', 'other_earnings', 'heslb_deduction',
            'pension_employee', 'pension_employer', 'loan_deduction',
            'salary_advance', 'other_deductions'
        ];

        foreach ($financialFields as $field) {
            if (array_key_exists($field, $data)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get tax calculation breakdown.
     */
    private function getTaxCalculationBreakdown(float $grossPay): array
    {
        return [
            'gross_income' => $grossPay,
            'tax_free_amount' => 270000,
            'taxable_income' => max(0, $grossPay - 270000),
            'tax_bands_applied' => self::PAYE_BANDS,
        ];
    }

    /**
     * Get allowance breakdown.
     */
    private function getAllowanceBreakdown(array $data): array
    {
        return [
            'house_allowance' => $data['house_allowance'] ?? 0,
            'transport_allowance' => $data['transport_allowance'] ?? 0,
            'medical_allowance' => $data['medical_allowance'] ?? 0,
            'other_allowances' => $data['other_allowances'] ?? 0,
            'overtime_pay' => $data['overtime_pay'] ?? 0,
            'holiday_pay' => $data['holiday_pay'] ?? 0,
            'leave_encashment' => $data['leave_encashment'] ?? 0,
            'bonus' => $data['bonus'] ?? 0,
            'commission' => $data['commission'] ?? 0,
            'other_earnings' => $data['other_earnings'] ?? 0,
        ];
    }

    /**
     * Get deduction breakdown.
     */
    private function getDeductionBreakdown(array $data, float $payeTax, float $nssfEmployee, float $wcfEmployee): array
    {
        return [
            'paye_tax' => $payeTax,
            'nssf_employee' => $nssfEmployee,
            'wcf_employee' => $wcfEmployee,
            'heslb_deduction' => $data['heslb_deduction'] ?? 0,
            'pension_employee' => $data['pension_employee'] ?? 0,
            'loan_deduction' => $data['loan_deduction'] ?? 0,
            'salary_advance' => $data['salary_advance'] ?? 0,
            'other_deductions' => $data['other_deductions'] ?? 0,
        ];
    }

    /**
     * Generate PAYE return report.
     */
    private function generatePAYEReturn(int $companyId, string $periodStart, string $periodEnd): array
    {
        $payrolls = Payroll::where('company_id', $companyId)
            ->whereBetween('payment_date', [$periodStart, $periodEnd])
            ->get();

        return [
            'report_type' => 'PAYE Return',
            'period' => $periodStart . ' to ' . $periodEnd,
            'total_employees' => $payrolls->count(),
            'total_gross_pay' => $payrolls->sum('gross_pay'),
            'total_paye_tax' => $payrolls->sum('paye_tax'),
            'total_taxable_income' => $payrolls->sum('taxable_income'),
            'employees' => $payrolls->map(function($payroll) {
                return [
                    'employee_name' => $payroll->employee->full_name,
                    'tax_number' => $payroll->employee->tax_number,
                    'gross_pay' => $payroll->gross_pay,
                    'paye_tax' => $payroll->paye_tax,
                    'taxable_income' => $payroll->taxable_income,
                ];
            })
        ];
    }

    /**
     * Generate NSSF schedule report.
     */
    private function generateNSSFSchedule(int $companyId, string $periodStart, string $periodEnd): array
    {
        $payrolls = Payroll::where('company_id', $companyId)
            ->whereBetween('payment_date', [$periodStart, $periodEnd])
            ->get();

        return [
            'report_type' => 'NSSF Schedule',
            'period' => $periodStart . ' to ' . $periodEnd,
            'total_employees' => $payrolls->count(),
            'total_employee_contributions' => $payrolls->sum('nssf_employee'),
            'total_employer_contributions' => $payrolls->sum('nssf_employer'),
            'total_contributions' => $payrolls->sum('nssf_employee') + $payrolls->sum('nssf_employer'),
        ];
    }

    /**
     * Generate WCF declaration report.
     */
    private function generateWCFDeclaration(int $companyId, string $periodStart, string $periodEnd): array
    {
        $payrolls = Payroll::where('company_id', $companyId)
            ->whereBetween('payment_date', [$periodStart, $periodEnd])
            ->get();

        return [
            'report_type' => 'WCF Declaration',
            'period' => $periodStart . ' to ' . $periodEnd,
            'total_employees' => $payrolls->count(),
            'total_employee_contributions' => $payrolls->sum('wcf_employee'),
            'total_employer_contributions' => $payrolls->sum('wcf_employer'),
            'total_contributions' => $payrolls->sum('wcf_employee') + $payrolls->sum('wcf_employer'),
        ];
    }

    /**
     * Generate SDL summary report.
     */
    private function generateSDLSummary(int $companyId, string $periodStart, string $periodEnd): array
    {
        $payrolls = Payroll::where('company_id', $companyId)
            ->whereBetween('payment_date', [$periodStart, $periodEnd])
            ->get();

        // SDL is typically 4% of gross payroll
        $totalGrossPayroll = $payrolls->sum('gross_pay');
        $sdlContribution = $totalGrossPayroll * 0.04;

        return [
            'report_type' => 'SDL Summary',
            'period' => $periodStart . ' to ' . $periodEnd,
            'total_gross_payroll' => $totalGrossPayroll,
            'sdl_rate' => '4%',
            'sdl_contribution' => $sdlContribution,
        ];
    }

    /**
     * Generate employer cost analysis report.
     */
    private function generateEmployerCostAnalysis(int $companyId, string $periodStart, string $periodEnd): array
    {
        $payrolls = Payroll::where('company_id', $companyId)
            ->whereBetween('payment_date', [$periodStart, $periodEnd])
            ->get();

        return [
            'report_type' => 'Employer Cost Analysis',
            'period' => $periodStart . ' to ' . $periodEnd,
            'total_employees' => $payrolls->count(),
            'total_gross_pay' => $payrolls->sum('gross_pay'),
            'total_nssf_employer' => $payrolls->sum('nssf_employer'),
            'total_wcf_employer' => $payrolls->sum('wcf_employer'),
            'total_pension_employer' => $payrolls->sum('pension_employer'),
            'total_cost_to_employer' => $payrolls->sum('total_cost_to_employer'),
            'average_cost_per_employee' => $payrolls->avg('total_cost_to_employer'),
        ];
    }
}
