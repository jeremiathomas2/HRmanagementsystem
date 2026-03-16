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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
            $table->string('employee_number', 50)->unique();
            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100);
            $table->string('email', 255)->unique();
            $table->string('phone', 50);
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed']);
            $table->string('national_id', 50)->unique();
            $table->string('passport_number', 50)->nullable();
            $table->enum('citizenship', ['citizen', 'non_citizen']);
            $table->string('work_permit_number', 50)->nullable();
            $table->date('work_permit_expiry')->nullable();
            $table->enum('employment_category', ['permanent', 'probation', 'contract', 'casual', 'intern', 'consultant']);
            $table->date('hire_date');
            $table->date('confirmation_date')->nullable();
            $table->date('termination_date')->nullable();
            $table->enum('termination_reason', ['resignation', 'termination', 'retirement', 'contract_end', 'death'])->nullable();
            $table->string('job_title', 255);
            $table->text('job_description')->nullable();
            $table->string('reporting_to', 255)->nullable();
            $table->string('employment_type', 255);
            $table->decimal('basic_salary', 12, 2)->nullable();
            $table->json('allowances')->nullable();
            $table->json('benefits')->nullable();
            $table->string('bank_name', 255)->nullable();
            $table->string('bank_account', 50)->nullable();
            $table->string('tax_number', 50)->nullable();
            $table->string('nssf_number', 50)->nullable();
            $table->string('wcf_number', 50)->nullable();
            $table->text('address', 500);
            $table->string('city', 100);
            $table->string('region', 100);
            $table->string('postal_code', 20);
            $table->string('emergency_contact_name', 255);
            $table->string('emergency_contact_phone', 50);
            $table->string('emergency_contact_relationship', 100);
            $table->json('medical_information')->nullable();
            $table->json('dependents')->nullable();
            $table->json('education_history')->nullable();
            $table->json('employment_history')->nullable();
            $table->json('skills')->nullable();
            $table->json('certifications')->nullable();
            $table->json('languages')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_on_probation')->default(false);
            $table->date('probation_end_date')->nullable();
            $table->json('digital_signature')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
