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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->date('attendance_date');
            $table->time('clock_in');
            $table->time('clock_out')->nullable();
            $table->time('break_start')->nullable();
            $table->time('break_end')->nullable();
            $table->decimal('total_hours', 5, 2)->nullable();
            $table->decimal('overtime_hours', 5, 2)->default(0);
            $table->enum('overtime_type', ['regular', 'weekend', 'holiday', 'night_shift'])->nullable();
            $table->enum('attendance_status', ['present', 'absent', 'late', 'early_departure', 'half_day', 'on_leave', 'holiday', 'weekend']);
            $table->text('absence_reason')->nullable();
            $table->enum('late_reason', ['traffic', 'family_emergency', 'medical', 'transport_issue', 'weather', 'other'])->nullable();
            $table->text('notes')->nullable();
            $table->string('shift_type', 100);
            $table->string('biometric_device_id', 50)->nullable();
            $table->string('location', 255)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->json('gps_coordinates')->nullable();
            $table->enum('approval_status', ['pending', 'approved', 'rejected']);
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->text('approval_notes')->nullable();
            $table->enum('compliance_status', ['compliant', 'non_compliant', 'needs_review']);
            $table->json('compliance_issues')->nullable();
            $table->decimal('productivity_score', 5, 2)->nullable();
            $table->json('performance_metrics')->nullable();
            $table->boolean('is_manual_entry')->default(false);
            $table->foreignId('entered_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
