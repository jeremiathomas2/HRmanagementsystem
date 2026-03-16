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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('registration_number', 100)->unique();
            $table->string('tax_identification_number', 50)->unique();
            $table->enum('sector', ['manufacturing', 'services', 'agriculture', 'mining', 'construction', 'tourism', 'technology', 'healthcare', 'education', 'government', 'other']);
            $table->enum('risk_level', ['low', 'medium', 'high', 'critical']);
            $table->string('address', 500);
            $table->string('city', 100);
            $table->string('region', 100);
            $table->string('postal_code', 20);
            $table->string('phone', 50);
            $table->string('email', 255);
            $table->string('website', 255)->nullable();
            $table->enum('union_status', ['unionized', 'non_unionized', 'partial']);
            $table->string('union_name', 255)->nullable();
            $table->string('collective_agreement', 255)->nullable();
            $table->integer('employee_count')->default(0);
            $table->date('registration_date');
            $table->boolean('is_active')->default(true);
            $table->json('compliance_settings')->nullable();
            $table->json('labor_law_settings')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
