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
        Schema::create('compliance_monitoring', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('employee_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('monitored_by')->constrained('users')->onDelete('cascade');
            
            // Compliance area
            $table->enum('compliance_area', ['contracts', 'payroll', 'working_hours', 'safety', 'data_protection', 'tax', 'immigration', 'training', 'licenses', 'other']);
            $table->string('compliance_item', 255);
            $table->text('description')->nullable();
            
            // Compliance requirements
            $table->enum('legal_requirement', ['mandatory', 'recommended', 'optional']);
            $table->string('applicable_law', 255);
            $table->text('compliance_criteria')->nullable();
            
            // Monitoring schedule
            $table->enum('frequency', ['daily', 'weekly', 'monthly', 'quarterly', 'annually', 'event_based']);
            $table->date('next_review_date');
            $table->date('last_review_date')->nullable();
            
            // Status
            $table->enum('status', ['compliant', 'non_compliant', 'pending_review', 'exempt', 'not_applicable'])->default('pending_review');
            $table->integer('compliance_score')->default(0);
            $table->text('non_compliance_details')->nullable();
            
            // Risk assessment
            $table->enum('risk_level', ['low', 'medium', 'high', 'critical']);
            $table->integer('risk_score')->default(0);
            $table->text('risk_factors')->nullable();
            $table->text('mitigation_measures')->nullable();
            
            // Evidence and documentation
            $table->json('compliance_documents')->nullable();
            $table->json('evidence_files')->nullable();
            $table->json('certificates')->nullable();
            $table->text('audit_trail')->nullable();
            
            // Actions taken
            $table->json('corrective_actions')->nullable();
            $table->json('preventive_actions')->nullable();
            $table->date('action_deadline')->nullable();
            $table->boolean('actions_completed')->default(false);
            
            // Notifications and alerts
            $table->json('alerts_sent')->nullable();
            $table->date('next_alert_date')->nullable();
            $table->boolean('escalation_required')->default(false);
            $table->text('escalation_reason')->nullable();
            
            // External compliance
            $table->string('external_authority')->nullable();
            $table->string('permit_number')->nullable();
            $table->date('permit_issue_date')->nullable();
            $table->date('permit_expiry_date')->nullable();
            $table->enum('permit_status', ['valid', 'expired', 'suspended', 'revoked', 'pending'])->nullable();
            
            // Audit findings
            $table->json('audit_findings')->nullable();
            $table->json('audit_recommendations')->nullable();
            $table->decimal('financial_impact', 12, 2)->nullable();
            
            // Reporting
            $table->json('reports_generated')->nullable();
            $table->date('last_report_date')->nullable();
            $table->json('stakeholder_notifications')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compliance_monitoring');
    }
};
