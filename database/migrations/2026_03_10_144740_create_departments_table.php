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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('name', 255);
            $table->string('code', 50)->unique();
            $table->text('description')->nullable();
            $table->foreignId('parent_department_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->foreignId('manager_id')->nullable();
            $table->enum('type', ['operational', 'support', 'strategic', 'administrative']);
            $table->integer('employee_count')->default(0);
            $table->decimal('budget', 15, 2)->nullable();
            $table->json('cost_centers')->nullable();
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
        Schema::dropIfExists('departments');
    }
};
