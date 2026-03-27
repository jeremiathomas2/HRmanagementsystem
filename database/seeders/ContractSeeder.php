<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContractSeeder extends Seeder
{
    public function run()
    {
        $contracts = [];
        $contractId = 1;

        // Get all employees to create contracts for
        $employees = DB::table('employees')->pluck('id', 'company_id');

        foreach ($employees as $companyId => $employeeIds) {
            if (is_array($employeeIds)) {
                foreach ($employeeIds as $employeeId) {
                    $contracts[] = $this->createContract($employeeId, $companyId, $contractId++);
                }
            }
        }

        DB::table('contracts')->insert($contracts);
    }

    private function createContract($employeeId, $companyId, $contractId)
    {
        $employee = DB::table('employees')->where('id', $employeeId)->first();
        
        $contractTypes = ['permanent', 'contract', 'probation', 'casual'];
        $contractType = $employee->employment_category ?? $contractTypes[array_rand($contractTypes)];
        
        $startDate = Carbon::parse($employee->hire_date);
        $endDate = null;
        
        if ($contractType === 'contract') {
            $endDate = $startDate->copy()->addMonths(rand(6, 24));
        } elseif ($contractType === 'probation') {
            $endDate = $startDate->copy()->addMonths(6);
        } elseif ($contractType === 'casual') {
            $endDate = $startDate->copy()->addMonths(rand(1, 3));
        }

        // Calculate compliance score based on various factors
        $complianceScore = 100;
        
        // Deduct points for missing or expiring documents
        if (!$employee->work_permit_number && $employee->citizenship === 'non_citizen') {
            $complianceScore -= 20;
        }
        
        if ($employee->work_permit_expiry && Carbon::parse($employee->work_permit_expiry)->isWithinDays(90)) {
            $complianceScore -= 15;
        }
        
        // Deduct points for contract nearing expiry
        if ($endDate && $endDate->isWithinDays(30)) {
            $complianceScore -= 10;
        }
        
        // Add some randomness for demonstration
        $complianceScore -= rand(0, 15);
        $complianceScore = max(0, $complianceScore);

        return [
            'id' => $contractId,
            'employee_id' => $employeeId,
            'company_id' => $companyId,
            'contract_type' => $contractType,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate ? $endDate->format('Y-m-d') : null,
            'job_title' => $employee->job_title,
            'job_description' => $employee->job_description,
            'basic_salary' => $employee->basic_salary,
            'allowances' => $employee->allowances,
            'benefits' => $employee->benefits,
            'working_hours' => '08:00 - 17:00',
            'working_days' => 'Monday - Friday',
            'probation_period' => $contractType === 'probation' ? 6 : null,
            'notice_period' => rand(30, 90),
            'status' => $this->getContractStatus($startDate, $endDate),
            'compliance_score' => $complianceScore,
            'legal_framework' => 'ELRA',
            'applicable_laws' => json_encode(['Employment and Labour Relations Act', 'Non-Citizen Employment Act']),
            'digital_signature' => json_encode([
                'employee_signed' => true,
                'employee_signed_date' => $startDate->format('Y-m-d'),
                'company_signed' => true,
                'company_signed_date' => $startDate->addDays(3)->format('Y-m-d'),
                'witness_signed' => true,
                'witness_signed_date' => $startDate->addDays(5)->format('Y-m-d'),
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function getContractStatus($startDate, $endDate)
    {
        $now = now();
        
        if ($now->lt($startDate)) {
            return 'pending';
        } elseif ($endDate && $now->gt($endDate)) {
            return 'expired';
        } elseif ($endDate && $now->copy()->addDays(30)->gte($endDate)) {
            return 'expiring_soon';
        } else {
            return 'active';
        }
    }
}
