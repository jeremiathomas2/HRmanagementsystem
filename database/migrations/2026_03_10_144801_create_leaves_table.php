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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('leave_number', 100);
            $table->enum('leave_type', ['annual', 'sick', 'maternity', 'paternity', 'compassionate', 'study', 'unpaid', 'emergency', 'sabbatical']);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_days');
            $table->enum('duration_type', ['full_day', 'half_day_morning', 'half_day_afternoon', 'hours']);
            $table->decimal('hours_requested', 5, 2)->nullable();
            $table->text('reason');
            $table->text('emergency_details')->nullable();
            $table->string('contact_address', 500)->nullable();
            $table->string('contact_phone', 50)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled', 'taken', 'expired']);
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->text('approval_notes')->nullable();
            $table->foreignId('rejected_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->decimal('available_balance_before', 5, 2);
            $table->decimal('available_balance_after', 5, 2);
            $table->decimal('accrual_rate', 5, 2)->default(0);
            $table->date('balance_reset_date')->nullable();
            $table->json('leave_policy')->nullable();
            $table->enum('compliance_status', ['compliant', 'non_compliant', 'needs_review']);
            $table->json('compliance_issues')->nullable();
            $table->boolean('is_paid_leave')->default(true);
            $table->boolean('requires_documentation')->default(false);
            $table->text('supporting_documents')->nullable();
            $table->date('return_to_work_date')->nullable();
            $table->boolean('handover_completed')->default(false);
            $table->text('handover_notes')->nullable();
            $table->foreignId('handover_to')->nullable()->constrained('employees')->onDelete('set null');
            $table->json('emergency_coverage')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
