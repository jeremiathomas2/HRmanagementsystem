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
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('payroll_number', 100);
            $table->date('pay_period_start');
            $table->date('pay_period_end');
            $table->date('payment_date');
            $table->enum('payment_frequency', ['monthly', 'bi_weekly', 'weekly']);
            $table->decimal('basic_salary', 12, 2);
            $table->decimal('house_allowance', 12, 2)->default(0);
            $table->decimal('transport_allowance', 12, 2)->default(0);
            $table->decimal('medical_allowance', 12, 2)->default(0);
            $table->decimal('other_allowances', 12, 2)->default(0);
            $table->decimal('overtime_pay', 12, 2)->default(0);
            $table->decimal('holiday_pay', 12, 2)->default(0);
            $table->decimal('leave_encashment', 12, 2)->default(0);
            $table->decimal('bonus', 12, 2)->default(0);
            $table->decimal('commission', 12, 2)->default(0);
            $table->decimal('other_earnings', 12, 2)->default(0);
            $table->decimal('gross_pay', 12, 2);
            $table->decimal('paye_tax', 12, 2)->default(0);
            $table->decimal('nssf_employee', 12, 2)->default(0);
            $table->decimal('nssf_employer', 12, 2)->default(0);
            $table->decimal('wcf_employee', 12, 2)->default(0);
            $table->decimal('wcf_employer', 12, 2)->default(0);
            $table->decimal('heslb_deduction', 12, 2)->default(0);
            $table->decimal('pension_employee', 12, 2)->default(0);
            $table->decimal('pension_employer', 12, 2)->default(0);
            $table->decimal('loan_deduction', 12, 2)->default(0);
            $table->decimal('salary_advance', 12, 2)->default(0);
            $table->decimal('other_deductions', 12, 2)->default(0);
            $table->decimal('total_deductions', 12, 2);
            $table->decimal('net_pay', 12, 2);
            $table->decimal('total_cost_to_employer', 12, 2);
            $table->string('tax_band', 50);
            $table->decimal('taxable_income', 12, 2);
            $table->decimal('tax_rate', 5, 4);
            $table->json('tax_calculation_breakdown')->nullable();
            $table->json('allowance_breakdown')->nullable();
            $table->json('deduction_breakdown')->nullable();
            $table->enum('status', ['draft', 'calculated', 'approved', 'processed', 'paid', 'cancelled']);
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('processed_at')->nullable();
            $table->string('payment_method', 100);
            $table->string('bank_account', 50);
            $table->string('transaction_reference', 100)->nullable();
            $table->text('payslip_path')->nullable();
            $table->json('compliance_checks')->nullable();
            $table->enum('compliance_status', ['compliant', 'non_compliant', 'needs_review']);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
