<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('from_company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('to_company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('initiated_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('hr_admin_approved_by')->nullable()->constrained('users')->onDelete('set null');
            
            // Transfer details
            $table->enum('transfer_type', ['permanent', 'temporary', 'contractual', 'secondment']);
            $table->date('effective_date');
            $table->date('end_date')->nullable();
            $table->text('reason')->nullable();
            $table->text('terms_and_conditions')->nullable();
            
            // Contract handling
            $table->foreignId('old_contract_id')->nullable()->constrained('contracts')->onDelete('set null');
            $table->foreignId('new_contract_id')->nullable()->constrained('contracts')->onDelete('set null');
            $table->boolean('contract_terminated')->default(false);
            $table->date('contract_termination_date')->nullable();
            
            // Status and workflow
            $table->enum('status', ['pending', 'from_company_approved', 'to_company_approved', 'hr_admin_approved', 'rejected', 'completed', 'cancelled'])->default('pending');
            $table->text('rejection_reason')->nullable();
            
            // Risk assessment
            $table->json('risk_assessment')->nullable();
            $table->integer('risk_score')->default(0);
            $table->text('risk_flags')->nullable();
            
            // Compliance checks
            $table->boolean('disciplinary_clearance')->default(false);
            $table->boolean('payroll_clearance')->default(false);
            $table->boolean('compliance_clearance')->default(false);
            $table->text('compliance_notes')->nullable();
            
            // Documents
            $table->json('transfer_documents')->nullable();
            $table->json('digital_signatures')->nullable();
            
            // Audit trail
            $table->timestamp('from_company_approved_at')->nullable();
            $table->timestamp('to_company_approved_at')->nullable();
            $table->timestamp('hr_admin_approved_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_transfers');
    }
};
