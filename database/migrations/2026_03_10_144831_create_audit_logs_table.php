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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->enum('action', ['create', 'read', 'update', 'delete', 'login', 'logout', 'approve', 'reject', 'export', 'import', 'print', 'download', 'upload']);
            $table->string('module', 100);
            $table->string('record_id', 100)->nullable();
            $table->string('record_type', 100)->nullable();
            $table->text('description');
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45);
            $table->string('user_agent', 500);
            $table->string('browser', 255)->nullable();
            $table->string('platform', 255)->nullable();
            $table->string('location', 255)->nullable();
            $table->json('gps_coordinates')->nullable();
            $table->enum('risk_level', ['low', 'medium', 'high', 'critical'])->default('low');
            $table->boolean('is_suspicious')->default(false);
            $table->text('security_notes')->nullable();
            $table->json('session_data')->nullable();
            $table->timestamp('timestamp');
            $table->index(['user_id', 'timestamp']);
            $table->index(['company_id', 'timestamp']);
            $table->index(['module', 'action']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
