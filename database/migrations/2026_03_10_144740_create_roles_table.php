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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('display_name', 255);
            $table->text('description')->nullable();
            $table->enum('role_type', ['super_admin', 'hr_admin', 'lead_hr_admin', 'hr_officer', 'finance_officer', 'line_manager', 'employee', 'external_auditor']);
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');
            $table->json('permissions')->nullable();
            $table->json('restrictions')->nullable();
            $table->integer('hierarchy_level')->default(0);
            $table->boolean('is_system_role')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
