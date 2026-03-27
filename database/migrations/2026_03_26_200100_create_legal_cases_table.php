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
        Schema::create('legal_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('employee_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('initiated_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            
            // Case identification
            $table->string('case_number', 50)->unique();
            $table->enum('case_type', ['termination', 'discrimination', 'harassment', 'wage_dispute', 'contract_dispute', 'safety_violation', 'other']);
            $table->string('case_title');
            $table->text('description');
            
            // Classification
            $table->enum('severity', ['low', 'medium', 'high', 'critical']);
            $table->enum('urgency', ['low', 'medium', 'high', 'urgent']);
            $table->enum('status', ['open', 'investigating', 'mediating', 'legal_review', 'court_filed', 'settled', 'dismissed', 'closed'])->default('open');
            
            // Legal framework
            $table->enum('legal_framework', ['elra', 'osha', 'employment_act', 'tax_act', 'data_protection', 'other']);
            $table->json('applicable_laws')->nullable();
            $table->text('legal_basis')->nullable();
            
            // Timeline
            $table->date('incident_date')->nullable();
            $table->date('reported_date');
            $table->date('resolution_target_date')->nullable();
            $table->date('actual_resolution_date')->nullable();
            
            // Parties involved
            $table->json('complainants')->nullable();
            $table->json('respondents')->nullable();
            $table->json('witnesses')->nullable();
            $table->json('legal_representatives')->nullable();
            
            // Evidence management
            $table->json('evidence_documents')->nullable();
            $table->json('witness_statements')->nullable();
            $table->json('digital_evidence')->nullable();
            $table->json('physical_evidence')->nullable();
            $table->text('evidence_summary')->nullable();
            
            // Risk assessment
            $table->integer('legal_risk_score')->default(0);
            $table->integer('financial_risk_score')->default(0);
            $table->integer('reputational_risk_score')->default(0);
            $table->text('risk_mitigation_plan')->nullable();
            
            // Resolution
            $table->enum('resolution_type', ['settlement', 'court_judgment', 'mediation', 'withdrawal', 'dismissal'])->nullable();
            $table->decimal('settlement_amount', 12, 2)->nullable();
            $table->text('resolution_terms')->nullable();
            $table->text('lessons_learned')->nullable();
            
            // CMA readiness
            $table->boolean('cma_ready')->default(false);
            $table->integer('cma_readiness_score')->default(0);
            $table->json('cma_checklist')->nullable();
            $table->text('cma_preparation_notes')->nullable();
            
            // External involvement
            $table->enum('external_body', ['none', 'cma', 'labour_court', 'high_court', 'tribunal', 'arbitration'])->default('none');
            $table->string('case_reference_external')->nullable();
            $table->date('external_filing_date')->nullable();
            
            // Communications
            $table->json('communications_log')->nullable();
            $table->json('legal_notices')->nullable();
            $table->json('court_documents')->nullable();
            
            // Costs
            $table->decimal('legal_costs', 12, 2)->default(0);
            $table->decimal('settlement_costs', 12, 2)->default(0);
            $table->decimal('court_costs', 12, 2)->default(0);
            $table->decimal('other_costs', 12, 2)->default(0);
            
            // Prevention measures
            $table->json('prevention_actions')->nullable();
            $table->json('policy_changes')->nullable();
            $table->json('training_recommendations')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_cases');
    }
};
