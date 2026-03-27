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
        Schema::create('risk_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('employee_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('assessed_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            
            // Assessment identification
            $table->string('assessment_reference', 50)->unique();
            $table->enum('assessment_type', ['termination', 'contract', 'payroll', 'safety', 'compliance', 'data_privacy', 'transfer', 'disciplinary', 'other']);
            $table->string('assessment_title');
            $table->text('assessment_purpose');
            
            // Risk categorization
            $table->enum('risk_category', ['legal', 'financial', 'operational', 'reputational', 'regulatory', 'safety', 'data_security']);
            $table->enum('risk_level', ['low', 'medium', 'high', 'critical']);
            $table->integer('risk_score')->default(0);
            $table->integer('probability_score')->default(0);
            $table->integer('impact_score')->default(0);
            
            // Risk factors
            $table->json('risk_factors')->nullable();
            $table->json('legal_violations')->nullable();
            $table->json('compliance_gaps')->nullable();
            $table->text('risk_description')->nullable();
            
            // Legal framework
            $table->enum('legal_framework', ['elra', 'osha', 'employment_act', 'tax_act', 'data_protection', 'immigration_act', 'other']);
            $table->json('applicable_laws')->nullable();
            $table->text('legal_implications')->nullable();
            
            // Timeline
            $table->date('assessment_date');
            $table->date('review_date')->nullable();
            $table->date('mitigation_deadline')->nullable();
            $table->date('next_assessment_date')->nullable();
            
            // Mitigation strategies
            $table->json('mitigation_strategies')->nullable();
            $table->json('control_measures')->nullable();
            $table->json('preventive_actions')->nullable();
            $table->text('mitigation_plan')->nullable();
            
            // Financial impact
            $table->decimal('potential_loss', 12, 2)->nullable();
            $table->decimal('mitigation_cost', 12, 2)->nullable();
            $table->decimal('insurance_coverage', 12, 2)->nullable();
            $table->text('cost_benefit_analysis')->nullable();
            
            // Monitoring
            $table->json('monitoring_indicators')->nullable();
            $table->json('early_warning_signs')->nullable();
            $table->json('reporting_requirements')->nullable();
            
            // Approval workflow
            $table->enum('status', ['draft', 'submitted', 'under_review', 'approved', 'rejected', 'implemented', 'closed'])->default('draft');
            $table->text('rejection_reason')->nullable();
            $table->json('approval_chain')->nullable();
            
            // Documentation
            $table->json('assessment_documents')->nullable();
            $table->json('evidence_files')->nullable();
            $table->json('expert_opinions')->nullable();
            $table->text('assessment_summary')->nullable();
            
            // Recommendations
            $table->json('recommendations')->nullable();
            $table->json('action_items')->nullable();
            $table->json('policy_changes')->nullable();
            $table->json('training_needs')->nullable();
            
            // Follow-up
            $table->boolean('mitigation_implemented')->default(false);
            $table->date('implementation_date')->nullable();
            $table->json('implementation_evidence')->nullable();
            $table->text('follow_up_notes')->nullable();
            
            // External factors
            $table->json('external_risks')->nullable();
            $table->json('market_conditions')->nullable();
            $table->json('regulatory_changes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('risk_assessments');
    }
};
