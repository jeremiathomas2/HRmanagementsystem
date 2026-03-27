<?php

namespace App\Http\Controllers;

use App\Models\EmployeeTransfer;
use App\Models\Employee;
use App\Models\Contract;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EmployeeTransferController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $transfers = EmployeeTransfer::with(['employee', 'fromCompany', 'toCompany'])
            ->when($user->company_id, function ($query) use ($user) {
                return $query->where(function ($q) use ($user) {
                    $q->where('from_company_id', $user->company_id)
                      ->orWhere('to_company_id', $user->company_id);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('employee-transfers.index', compact('transfers'));
    }

    public function create()
    {
        $companies = Company::where('is_active', true)->get();
        $employees = Employee::where('is_active', true)->get();
        
        return view('employee-transfers.create', compact('companies', 'employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'from_company_id' => 'required|exists:companies,id',
            'to_company_id' => 'required|exists:companies,id|different:from_company_id',
            'transfer_type' => ['required', Rule::in(['permanent', 'temporary', 'contractual', 'secondment'])],
            'effective_date' => 'required|date|after:today',
            'end_date' => 'nullable|date|after:effective_date',
            'reason' => 'required|string|max:1000',
            'terms_and_conditions' => 'nullable|string|max:2000',
        ]);

        try {
            DB::beginTransaction();

            $employee = Employee::findOrFail($request->employee_id);
            
            // Validate employee belongs to from_company
            if ($employee->company_id != $request->from_company_id) {
                return back()->withErrors(['employee_id' => 'Employee does not belong to the selected from company.']);
            }

            // Check for existing transfers
            $existingTransfer = EmployeeTransfer::where('employee_id', $request->employee_id)
                ->whereIn('status', ['pending', 'from_company_approved', 'to_company_approved', 'hr_admin_approved'])
                ->first();

            if ($existingTransfer) {
                return back()->withErrors(['employee_id' => 'Employee already has an active transfer request.']);
            }

            $transfer = EmployeeTransfer::create([
                'employee_id' => $request->employee_id,
                'from_company_id' => $request->from_company_id,
                'to_company_id' => $request->to_company_id,
                'initiated_by' => Auth::id(),
                'transfer_type' => $request->transfer_type,
                'effective_date' => $request->effective_date,
                'end_date' => $request->end_date,
                'reason' => $request->reason,
                'terms_and_conditions' => $request->terms_and_conditions,
                'status' => 'pending',
            ]);

            // Perform initial risk assessment
            $transfer->calculateRiskScore();

            // Check clearances
            $this->checkClearances($transfer);

            DB::commit();

            return redirect()->route('employee-transfers.show', $transfer)
                ->with('success', 'Transfer request created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create transfer request: ' . $e->getMessage()]);
        }
    }

    public function show(EmployeeTransfer $transfer)
    {
        $transfer->load(['employee', 'fromCompany', 'toCompany', 'initiatedBy', 'approvedBy', 'hrAdminApprovedBy']);
        
        return view('employee-transfers.show', compact('transfer'));
    }

    public function approve(Request $request, EmployeeTransfer $transfer)
    {
        $user = Auth::user();
        
        // Check if user can approve
        if (!$this->canApprove($transfer, $user)) {
            return back()->withErrors(['error' => 'You are not authorized to approve this transfer.']);
        }

        try {
            DB::beginTransaction();

            if ($transfer->from_company_id == $user->company_id && $transfer->status == 'pending') {
                $transfer->updateStatus('from_company_approved', $user->id);
            } elseif ($transfer->to_company_id == $user->company_id && $transfer->status == 'from_company_approved') {
                $transfer->updateStatus('to_company_approved', $user->id);
            } elseif ($user->hasRole('hr_admin') && $transfer->status == 'to_company_approved') {
                if (!$transfer->canBeApprovedByHRAdmin()) {
                    return back()->withErrors(['error' => 'All clearances must be completed before HR Admin approval.']);
                }
                $transfer->updateStatus('hr_admin_approved', $user->id);
                $this->executeTransfer($transfer);
            }

            DB::commit();

            return back()->with('success', 'Transfer approved successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to approve transfer: ' . $e->getMessage()]);
        }
    }

    public function reject(Request $request, EmployeeTransfer $transfer)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        
        if (!$this->canApprove($transfer, $user)) {
            return back()->withErrors(['error' => 'You are not authorized to reject this transfer.']);
        }

        $transfer->updateStatus('rejected', $user->id, $request->rejection_reason);

        return back()->with('success', 'Transfer rejected.');
    }

    public function cancel(EmployeeTransfer $transfer)
    {
        $user = Auth::user();
        
        // Only initiator or HR admin can cancel
        if ($transfer->initiated_by != $user->id && !$user->hasRole('hr_admin')) {
            return back()->withErrors(['error' => 'You are not authorized to cancel this transfer.']);
        }

        // Can only cancel pending transfers
        if (!in_array($transfer->status, ['pending', 'from_company_approved', 'to_company_approved'])) {
            return back()->withErrors(['error' => 'Cannot cancel transfer in current status.']);
        }

        $transfer->updateStatus('cancelled');

        return back()->with('success', 'Transfer cancelled successfully.');
    }

    private function canApprove(EmployeeTransfer $transfer, $user)
    {
        if ($user->hasRole('hr_admin')) {
            return in_array($transfer->status, ['to_company_approved']);
        }

        if ($transfer->from_company_id == $user->company_id && $transfer->status == 'pending') {
            return true;
        }

        if ($transfer->to_company_id == $user->company_id && $transfer->status == 'from_company_approved') {
            return true;
        }

        return false;
    }

    private function checkClearances(EmployeeTransfer $transfer)
    {
        $employee = $transfer->employee;

        // Check disciplinary clearance
        $activeDisciplines = $employee->disciplines()
            ->whereIn('status', ['active', 'under_investigation'])
            ->count();
        
        $transfer->disciplinary_clearance = $activeDisciplines == 0;

        // Check payroll clearance
        $pendingPayroll = $employee->payrolls()
            ->where('status', 'pending')
            ->count();
        
        $transfer->payroll_clearance = $pendingPayroll == 0;

        // Check compliance clearance
        $nonCompliantIssues = $employee->complianceIssues()
            ->where('status', 'non_compliant')
            ->count();
        
        $transfer->compliance_clearance = $nonCompliantIssues == 0;

        $transfer->save();
    }

    private function executeTransfer(EmployeeTransfer $transfer)
    {
        $employee = $transfer->employee;
        $effectiveDate = $transfer->effective_date;

        // Terminate old contract if exists
        if ($transfer->old_contract_id) {
            $oldContract = Contract::find($transfer->old_contract_id);
            if ($oldContract) {
                $oldContract->update([
                    'end_date' => $effectiveDate->subDay(),
                    'termination_reason' => 'transfer',
                    'status' => 'terminated',
                ]);
                $transfer->update(['contract_terminated' => true, 'contract_termination_date' => $effectiveDate->subDay()]);
            }
        }

        // Create new contract
        $newContract = Contract::create([
            'employee_id' => $employee->id,
            'company_id' => $transfer->to_company_id,
            'contract_type' => $transfer->transfer_type,
            'start_date' => $effectiveDate,
            'end_date' => $transfer->end_date,
            'job_title' => $employee->job_title,
            'basic_salary' => $employee->basic_salary,
            'status' => 'active',
            'transfer_reference' => $transfer->id,
        ]);

        $transfer->update(['new_contract_id' => $newContract->id]);

        // Update employee company
        $employee->update(['company_id' => $transfer->to_company_id]);

        // Update transfer status
        $transfer->updateStatus('completed');

        // Generate transfer agreement
        $transferAgreement = $transfer->generateTransferAgreement();
        
        // Log the transfer
        activity()
            ->causedBy(Auth::user())
            ->performedOn($transfer)
            ->withProperties([
                'action' => 'employee_transfer_completed',
                'employee' => $employee->full_name,
                'from_company' => $transfer->fromCompany->name,
                'to_company' => $transfer->toCompany->name,
                'effective_date' => $effectiveDate,
            ])
            ->log('Employee transfer completed');
    }

    public function riskAssessment(EmployeeTransfer $transfer)
    {
        $transfer->calculateRiskScore();
        
        return view('employee-transfers.risk-assessment', compact('transfer'));
    }

    public function documents(EmployeeTransfer $transfer)
    {
        return view('employee-transfers.documents', compact('transfer'));
    }
}
