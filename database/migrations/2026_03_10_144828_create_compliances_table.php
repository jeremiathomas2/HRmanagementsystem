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
        Schema::create('compliances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('compliance_number', 100);
            $table->enum('compliance_type', ['elra', 'labour_institutions_act', 'osha', 'data_protection', 'work_permit', 'tax_compliance', 'nssf', 'wcf', 'collective_bargaining', 'policy_compliance']);
            $table->enum('risk_level', ['low', 'medium', 'high', 'critical']);
            $table->string('title', 255);
            $table->text('description');
            $table->enum('status', ['compliant', 'non_compliant', 'pending_review', 'in_progress', 'overdue']);
            $table->date('due_date');
            $table->date('completed_date')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->json('requirements')->nullable();
            $table->json('checklist')->nullable();
            $table->json('evidence')->nullable();
            $table->text('supporting_documents')->nullable();
            $table->json('compliance_score')->nullable();
            $table->decimal('score_percentage', 5, 2)->nullable();
            $table->json('violations')->nullable();
            $table->text('corrective_actions')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->enum('frequency', ['one_time', 'monthly', 'quarterly', 'semi_annual', 'annual']);
            $table->json('reminders')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_critical')->default(false);
            $table->json('legal_references')->nullable();
            $table->json('audit_trail')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compliances');
    }
};
