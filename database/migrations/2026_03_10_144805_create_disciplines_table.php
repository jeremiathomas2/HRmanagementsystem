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
        Schema::create('disciplines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('case_number', 100);
            $table->enum('case_type', ['misconduct', 'performance', 'absenteeism', 'theft', 'fraud', 'harassment', 'violence', 'policy_violation', 'other']);
            $table->enum('severity_level', ['minor', 'major', 'critical', 'gross_misconduct']);
            $table->enum('risk_score', ['low', 'medium', 'high', 'critical']);
            $table->date('incident_date');
            $table->text('incident_description');
            $table->string('incident_location', 255)->nullable();
            $table->text('witness_details')->nullable();
            $table->json('evidence')->nullable();
            $table->text('evidence_documents')->nullable();
            $table->enum('status', ['reported', 'investigation_pending', 'investigation_ongoing', 'show_cause_issued', 'hearing_scheduled', 'hearing_completed', 'decision_made', 'appeal_pending', 'closed']);
            $table->foreignId('reported_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('investigated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->date('investigation_start_date')->nullable();
            $table->date('investigation_end_date')->nullable();
            $table->text('investigation_findings')->nullable();
            $table->text('show_cause_letter')->nullable();
            $table->date('show_cause_issued_date')->nullable();
            $table->date('show_cause_response_deadline')->nullable();
            $table->text('employee_response')->nullable();
            $table->date('hearing_date')->nullable();
            $table->string('hearing_location', 255)->nullable();
            $table->json('hearing_panel')->nullable();
            $table->text('hearing_notes')->nullable();
            $table->enum('disciplinary_action', ['warning', 'written_warning', 'final_warning', 'suspension', 'demotion', 'termination', 'fine', 'training_required', 'counseling']);
            $table->text('action_details')->nullable();
            $table->date('action_effective_date')->nullable();
            $table->integer('suspension_days')->nullable();
            $table->decimal('fine_amount', 12, 2)->nullable();
            $table->enum('decision_status', ['pending', 'approved_by_hr_admin', 'rejected', 'implemented']);
            $table->foreignId('hr_admin_approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('hr_admin_approved_at')->nullable();
            $table->text('hr_admin_notes')->nullable();
            $table->json('legal_risk_analysis')->nullable();
            $table->json('precedent_cases')->nullable();
            $table->decimal('termination_risk_score', 5, 2)->nullable();
            $table->text('appeal_details')->nullable();
            $table->date('appeal_filed_date')->nullable();
            $table->enum('appeal_status', ['none', 'pending', 'approved', 'rejected']);
            $table->text('final_decision')->nullable();
            $table->date('case_closed_date')->nullable();
            $table->json('case_documents')->nullable();
            $table->boolean('is_court_ready')->default(false);
            $table->text('compliance_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplines');
    }
};
