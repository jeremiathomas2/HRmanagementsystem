<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use App\Models\Department;
use App\Models\Contract;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index(Request $request)
    {
        $query = Employee::with(['company', 'department', 'contracts'])
            ->where('company_id', $request->user()->company_id);

        // Apply filters
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%')
                  ->orWhere('employee_number', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->department_id) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->employment_category) {
            $query->where('employment_category', $request->employment_category);
        }

        if ($request->status === 'active') {
            $query->where('is_active', true);
        } elseif ($request->status === 'inactive') {
            $query->where('is_active', false);
        }

        $employees = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json($employees);
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'email' => 'required|email|unique:employees',
            'phone' => 'required|string|max:50',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'national_id' => 'required|string|unique:employees',
            'passport_number' => 'nullable|string|unique:employees',
            'citizenship' => 'required|in:citizen,non_citizen',
            'work_permit_number' => 'nullable|string',
            'work_permit_expiry' => 'nullable|date|after:today',
            'employment_category' => 'required|in:permanent,probation,contract,casual,intern,consultant',
            'hire_date' => 'required|date|before_or_equal:today',
            'job_title' => 'required|string|max:255',
            'job_description' => 'nullable|string',
            'reporting_to' => 'nullable|string|max:255',
            'employment_type' => 'required|string|max:255',
            'basic_salary' => 'required|numeric|min:0',
            'allowances' => 'nullable|array',
            'benefits' => 'nullable|array',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:50',
            'tax_number' => 'nullable|string|max:50',
            'nssf_number' => 'nullable|string|max:50',
            'wcf_number' => 'nullable|string|max:50',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'region' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:50',
            'emergency_contact_relationship' => 'required|string|max:100',
            'medical_information' => 'nullable|array',
            'dependents' => 'nullable|array',
            'education_history' => 'nullable|array',
            'employment_history' => 'nullable|array',
            'skills' => 'nullable|array',
            'certifications' => 'nullable|array',
            'languages' => 'nullable|array',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        // Generate employee number
        $employeeNumber = $this->generateEmployeeNumber($request->company_id);

        $data = $validator->validated();
        $data['employee_number'] = $employeeNumber;
        $data['company_id'] = $request->user()->company_id;

        // Check compliance for non-citizens
        if ($data['citizenship'] === 'non_citizen') {
            if (!$data['work_permit_number'] || !$data['work_permit_expiry']) {
                return response()->json([
                    'message' => 'Work permit number and expiry are required for non-citizens',
                    'compliance_status' => 'non_compliant'
                ], 422);
            }
        }

        // Check probation requirements
        if ($data['employment_category'] === 'probation') {
            $data['is_on_probation'] = true;
            $data['probation_end_date'] = Carbon::parse($data['hire_date'])->addMonths(3);
        }

        $employee = Employee::create($data);

        // Create initial contract if contract data provided
        if ($request->has('contract')) {
            $this->createInitialContract($employee, $request->contract);
        }

        return response()->json([
            'message' => 'Employee created successfully',
            'employee' => $employee->load(['company', 'department', 'contracts'])
        ], 201);
    }

    /**
     * Display the specified employee.
     */
    public function show(Request $request, Employee $employee)
    {
        if ($employee->company_id !== $request->user()->company_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($employee->load([
            'company',
            'department',
            'contracts',
            'attendances',
            'payrolls',
            'leaves',
            'disciplines',
            'performances',
            'trainings'
        ]));
    }

    /**
     * Update the specified employee.
     */
    public function update(Request $request, Employee $employee)
    {
        if ($employee->company_id !== $request->user()->company_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'sometimes|required|string|max:100',
            'last_name' => 'sometimes|required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'email' => 'sometimes|required|email|unique:employees,email,' . $employee->id,
            'phone' => 'sometimes|required|string|max:50',
            'job_title' => 'sometimes|required|string|max:255',
            'job_description' => 'nullable|string',
            'reporting_to' => 'nullable|string|max:255',
            'employment_type' => 'sometimes|required|string|max:255',
            'basic_salary' => 'sometimes|required|numeric|min:0',
            'allowances' => 'nullable|array',
            'benefits' => 'nullable|array',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:50',
            'tax_number' => 'nullable|string|max:50',
            'nssf_number' => 'nullable|string|max:50',
            'wcf_number' => 'nullable|string|max:50',
            'address' => 'sometimes|required|string|max:500',
            'city' => 'sometimes|required|string|max:100',
            'region' => 'sometimes|required|string|max:100',
            'postal_code' => 'sometimes|required|string|max:20',
            'emergency_contact_name' => 'sometimes|required|string|max:255',
            'emergency_contact_phone' => 'sometimes|required|string|max:50',
            'emergency_contact_relationship' => 'sometimes|required|string|max:100',
            'department_id' => 'nullable|exists:departments,id',
            'is_active' => 'sometimes|boolean',
            'termination_date' => 'nullable|date',
            'termination_reason' => 'nullable|in:resignation,termination,retirement,contract_end,death',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }

        $data = $validator->validated();

        // Handle termination
        if (isset($data['termination_date']) && $data['termination_date']) {
            $data['is_active'] = false;
            
            // Create termination compliance record
            $this->createTerminationRecord($employee, $data);
        }

        $employee->update($data);

        return response()->json([
            'message' => 'Employee updated successfully',
            'employee' => $employee->load(['company', 'department', 'contracts'])
        ]);
    }

    /**
     * Remove the specified employee.
     */
    public function destroy(Request $request, Employee $employee)
    {
        if ($employee->company_id !== $request->user()->company_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Check if employee can be deleted (no active contracts, payrolls, etc.)
        $activeContracts = $employee->contracts()->where('status', 'active')->count();
        $recentPayrolls = $employee->payrolls()->where('payment_date', '>=', now()->subMonths(6))->count();

        if ($activeContracts > 0 || $recentPayrolls > 0) {
            return response()->json([
                'message' => 'Cannot delete employee with active contracts or recent payroll records',
                'active_contracts' => $activeContracts,
                'recent_payrolls' => $recentPayrolls
            ], 422);
        }

        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully']);
    }

    /**
     * Get employee analytics.
     */
    public function analytics(Request $request)
    {
        $companyId = $request->user()->company_id;

        $analytics = [
            'total_employees' => Employee::where('company_id', $companyId)->count(),
            'active_employees' => Employee::where('company_id', $companyId)->where('is_active', true)->count(),
            'on_probation' => Employee::where('company_id', $companyId)->where('is_on_probation', true)->count(),
            'by_department' => Employee::join('departments', 'employees.department_id', '=', 'departments.id')
                ->where('employees.company_id', $companyId)
                ->groupBy('departments.name')
                ->selectRaw('departments.name as department, COUNT(*) as count')
                ->get(),
            'by_employment_category' => Employee::where('company_id', $companyId)
                ->groupBy('employment_category')
                ->selectRaw('employment_category, COUNT(*) as count')
                ->get(),
            'by_gender' => Employee::where('company_id', $companyId)
                ->groupBy('gender')
                ->selectRaw('gender, COUNT(*) as count')
                ->get(),
            'citizenship_breakdown' => Employee::where('company_id', $companyId)
                ->groupBy('citizenship')
                ->selectRaw('citizenship, COUNT(*) as count')
                ->get(),
            'recent_hires' => Employee::where('company_id', $companyId)
                ->where('hire_date', '>=', now()->subMonths(3))
                ->count(),
            'upcoming_probation_end' => Employee::where('company_id', $companyId)
                ->where('is_on_probation', true)
                ->where('probation_end_date', '<=', now()->addDays(30))
                ->count(),
        ];

        return response()->json($analytics);
    }

    /**
     * Generate unique employee number.
     */
    private function generateEmployeeNumber(int $companyId): string
    {
        $company = Company::find($companyId);
        $prefix = strtoupper(substr($company->name, 0, 3));
        $sequence = Employee::where('company_id', $companyId)->count() + 1;
        
        return $prefix . '-' . str_pad($sequence, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Create initial contract for employee.
     */
    private function createInitialContract(Employee $employee, array $contractData): Contract
    {
        $contractData['employee_id'] = $employee->id;
        $contractData['company_id'] = $employee->company_id;
        $contractData['contract_number'] = 'CNT-' . $employee->employee_number . '-' . date('Y');
        
        return Contract::create($contractData);
    }

    /**
     * Create termination compliance record.
     */
    private function createTerminationRecord(Employee $employee, array $data): void
    {
        // This would create compliance records for termination
        // Including final pay calculations, notice period verification, etc.
    }
}
