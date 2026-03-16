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
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('display_name', 255);
            $table->text('description')->nullable();
            $table->enum('module', ['organization', 'employees', 'contracts', 'attendance', 'payroll', 'leave', 'discipline', 'recruitment', 'performance', 'training', 'compliance', 'reports', 'system']);
            $table->enum('action', ['create', 'read', 'update', 'delete', 'approve', 'reject', 'export', 'import', 'manage']);
            $table->string('resource', 255);
            $table->json('conditions')->nullable();
            $table->boolean('is_system_permission')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
