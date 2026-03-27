<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Starting database seeding...');
        
        // Seed core data
        $this->command->info('Seeding companies...');
        $this->call(CompanySeeder::class);
        
        $this->command->info('Seeding departments...');
        $this->call(DepartmentSeeder::class);
        
        $this->command->info('Seeding users...');
        $this->call(UserSeeder::class);
        
        $this->command->info('Seeding employees...');
        $this->call(EmployeeSeeder::class);
        
        $this->command->info('Seeding contracts...');
        $this->call(ContractSeeder::class);
        
        // Create sample data for demonstration
        $this->command->info('Creating sample transfers...');
        $this->createSampleTransfers();
        
        $this->command->info('Creating sample legal cases...');
        $this->createSampleLegalCases();
        
        $this->command->info('Creating sample compliance monitoring...');
        $this->createSampleComplianceMonitoring();
        
        $this->command->info('Creating sample risk assessments...');
        $this->createSampleRiskAssessments();
        
        $this->command->info('Database seeding completed successfully!');
        
        // Display login credentials
        $this->displayLoginCredentials();
    }
    
    private function createSampleTransfers()
    {
        // Create sample employee transfers
        $transfers = [
            [
                'employee_id' => 1, // John Smith from HR System
                'from_company_id' => 1,
                'to_company_id' => 2, // Transfer to TCC
                'initiated_by' => 1,
                'transfer_type' => 'permanent',
                'effective_date' => now()->addDays(15),
                'reason' => 'Career advancement opportunity',
                'terms_and_conditions' => 'Standard transfer terms with salary adjustment',
                'status' => 'pending',
                'risk_score' => 25,
                'disciplinary_clearance' => true,
                'payroll_clearance' => true,
                'compliance_clearance' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'employee_id' => 5, // Ali Mkapa from TCC
                'from_company_id' => 2,
                'to_company_id' => 3, // Transfer to TBL
                'initiated_by' => 2,
                'transfer_type' => 'temporary',
                'effective_date' => now()->addDays(30),
                'end_date' => now()->addDays(120),
                'reason' => 'Secondment for knowledge transfer',
                'terms_and_conditions' => 'Temporary secondment with return guarantee',
                'status' => 'from_company_approved',
                'risk_score' => 15,
                'disciplinary_clearance' => true,
                'payroll_clearance' => true,
                'compliance_clearance' => true,
                'from_company_approved_at' => now()->subDays(2),
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(2),
            ],
        ];
        
        DB::table('employee_transfers')->insert($transfers);
    }
    
    private function createSampleLegalCases()
    {
        $cases = [
            [
                'company_id' => 2, // TCC
                'employee_id' => 7, // Peter Kimaro
                'initiated_by' => 2,
                'case_number' => 'LC-TCC-2024-001',
                'case_type' => 'termination',
                'case_title' => 'Unfair Termination - Peter Kimaro',
                'description' => 'Employee claims unfair termination without proper procedure',
                'severity' => 'high',
                'urgency' => 'high',
                'status' => 'investigating',
                'legal_framework' => 'elra',
                'incident_date' => now()->subDays(10),
                'reported_date' => now()->subDays(5),
                'legal_risk_score' => 75,
                'financial_risk_score' => 60,
                'reputational_risk_score' => 50,
                'cma_ready' => false,
                'cma_readiness_score' => 45,
                'external_body' => 'none',
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(2),
            ],
            [
                'company_id' => 4, // NMB Bank
                'employee_id' => 15, // Sophia Kassim
                'initiated_by' => 4,
                'case_number' => 'LC-NMB-2024-002',
                'case_type' => 'discrimination',
                'case_title' => 'Gender Discrimination Claim',
                'description' => 'Employee claims gender-based discrimination in promotion',
                'severity' => 'critical',
                'urgency' => 'urgent',
                'status' => 'legal_review',
                'legal_framework' => 'elra',
                'incident_date' => now()->subDays(20),
                'reported_date' => now()->subDays(15),
                'legal_risk_score' => 85,
                'financial_risk_score' => 80,
                'reputational_risk_score' => 90,
                'cma_ready' => true,
                'cma_readiness_score' => 75,
                'external_body' => 'cma',
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(3),
            ],
        ];
        
        DB::table('legal_cases')->insert($cases);
    }
    
    private function createSampleComplianceMonitoring()
    {
        $monitoring = [
            [
                'company_id' => 1,
                'employee_id' => 1,
                'monitored_by' => 1,
                'compliance_area' => 'contracts',
                'compliance_item' => 'Contract Renewal',
                'legal_requirement' => 'mandatory',
                'applicable_law' => 'ELRA',
                'frequency' => 'monthly',
                'next_review_date' => now()->addDays(30),
                'last_review_date' => now()->subDays(30),
                'status' => 'compliant',
                'compliance_score' => 95,
                'risk_level' => 'low',
                'risk_score' => 10,
                'created_at' => now()->subDays(30),
                'updated_at' => now()->subDays(1),
            ],
            [
                'company_id' => 2,
                'employee_id' => 5,
                'monitored_by' => 2,
                'compliance_area' => 'payroll',
                'compliance_item' => 'Statutory Deductions',
                'legal_requirement' => 'mandatory',
                'applicable_law' => 'Income Tax Act',
                'frequency' => 'monthly',
                'next_review_date' => now()->addDays(15),
                'last_review_date' => now()->subDays(15),
                'status' => 'non_compliant',
                'compliance_score' => 70,
                'risk_level' => 'medium',
                'risk_score' => 35,
                'non_compliance_details' => 'NSSF contributions underpaid',
                'created_at' => now()->subDays(45),
                'updated_at' => now()->subDays(2),
            ],
        ];
        
        DB::table('compliance_monitoring')->insert($monitoring);
    }
    
    private function createSampleRiskAssessments()
    {
        $assessments = [
            [
                'company_id' => 1,
                'employee_id' => 1,
                'assessed_by' => 1,
                'assessment_reference' => 'RA-HR-2024-001',
                'assessment_type' => 'termination',
                'assessment_title' => 'Termination Risk Assessment - John Smith',
                'assessment_purpose' => 'Assess legal risks before contract termination',
                'risk_category' => 'legal',
                'risk_level' => 'medium',
                'risk_score' => 45,
                'probability_score' => 3,
                'impact_score' => 6,
                'legal_framework' => 'elra',
                'assessment_date' => now()->subDays(10),
                'status' => 'approved',
                'created_at' => now()->subDays(12),
                'updated_at' => now()->subDays(8),
            ],
            [
                'company_id' => 3,
                'employee_id' => 11,
                'assessed_by' => 3,
                'assessment_reference' => 'RA-TBL-2024-002',
                'assessment_type' => 'contract',
                'assessment_title' => 'Contract Compliance Risk - Esther Kileo',
                'assessment_purpose' => 'Evaluate contract compliance risks',
                'risk_category' => 'legal',
                'risk_level' => 'low',
                'risk_score' => 20,
                'probability_score' => 2,
                'impact_score' => 4,
                'legal_framework' => 'elra',
                'assessment_date' => now()->subDays(5),
                'status' => 'completed',
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(3),
            ],
        ];
        
        DB::table('risk_assessments')->insert($assessments);
    }
    
    private function displayLoginCredentials()
    {
        $this->command->info("\n=== LOGIN CREDENTIALS ===");
        $this->command->info("\n🔑 SUPER ADMIN ACCESS:");
        $this->command->info("   Email: admin@hrsystem.co.tz");
        $this->command->info("   Password: admin123");
        
        $this->command->info("\n🏢 COMPANY LOGIN EXAMPLES:");
        $this->command->info("\n   Tanzania Cigarette Company (TCC):");
        $this->command->info("   HR Manager: hr.manager@tcc.co.tz / hrmanager123");
        $this->command->info("   Lead HR-ADMIN: lead.hradmin@tcc.co.tz / leadadmin123");
        $this->command->info("   HR Officer: hr.officer@tcc.co.tz / hrofficer123");
        $this->command->info("   Payroll: payroll@tcc.co.tz / payroll123");
        $this->command->info("   Manager: manager@tcc.co.tz / manager123");
        $this->command->info("   Employee: employee@tcc.co.tz / employee123");
        
        $this->command->info("\n   NMB Bank:");
        $this->command->info("   HR Manager: hr.manager@nmbbank.co.tz / hrmanager123");
        $this->command->info("   Lead HR-ADMIN: lead.hradmin@nmbbank.co.tz / leadadmin123");
        
        $this->command->info("\n🔍 EXTERNAL AUDITOR:");
        $this->command->info("   Email: auditor@external.co.tz");
        $this->command->info("   Password: auditor123");
        
        $this->command->info("\n📊 SYSTEM FEATURES TO TEST:");
        $this->command->info("   • Employee transfers between companies");
        $this->command->info("   • Legal case management (CMA ready)");
        $this->command->info("   • Compliance monitoring");
        $this->command->info("   • Risk assessments");
        $this->command->info("   • Multi-tenant company switching");
        $this->command->info("   • Role-based access control");
        
        $this->command->info("\n========================\n");
    }
}
