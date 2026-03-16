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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('contract_number', 100)->unique();
            $table->enum('contract_type', ['fixed_term', 'indefinite', 'casual', 'probation', 'internship', 'consultancy']);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('duration_months')->nullable();
            $table->enum('renewal_type', ['auto_renew', 'manual_renew', 'non_renewable'])->default('manual_renew');
            $table->text('job_title');
            $table->text('job_description');
            $table->text('duties_responsibilities');
            $table->string('department', 255);
            $table->string('reporting_to', 255);
            $table->string('work_location', 255);
            $table->enum('work_schedule', ['full_time', 'part_time', 'flexible', 'remote']);
            $table->string('working_hours', 100);
            $table->enum('probation_period', ['none', '1_month', '2_months', '3_months', '6_months']);
            $table->date('probation_end_date')->nullable();
            $table->decimal('basic_salary', 12, 2);
            $table->json('allowances');
            $table->json('benefits');
            $table->enum('payment_frequency', ['monthly', 'bi_weekly', 'weekly']);
            $table->string('payment_method', 100);
            $table->enum('notice_period', ['1_week', '2_weeks', '1_month', '2_months', '3_months']);
            $table->enum('leave_entitlement', ['21_days', '28_days', '30_days', 'custom']);
            $table->integer('custom_leave_days')->nullable();
            $table->json('leave_conditions')->nullable();
            $table->json('termination_conditions');
            $table->json('confidentiality_clauses')->nullable();
            $table->json('non_compete_clauses')->nullable();
            $table->enum('union_membership', ['required', 'optional', 'not_applicable']);
            $table->string('union_name', 255)->nullable();
            $table->json('collective_agreement_terms')->nullable();
            $table->enum('compliance_status', ['compliant', 'non_compliant', 'pending_review']);
            $table->json('compliance_issues')->nullable();
            $table->enum('status', ['draft', 'active', 'expired', 'terminated', 'renewed']);
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->json('digital_signatures')->nullable();
            $table->text('contract_document_path')->nullable();
            $table->text('terms_conditions');
            $table->json('special_clauses')->nullable();
            $table->date('renewal_reminder_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
