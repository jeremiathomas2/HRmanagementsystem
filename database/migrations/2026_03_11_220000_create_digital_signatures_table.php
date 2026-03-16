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
        Schema::create('digital_signatures', function (Blueprint $table) {
            $table->id();
            $table->string('signable_type', 100); // Polymorphic relationship
            $table->unsignedBigInteger('signable_id'); // Polymorphic relationship
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('signature_data'); // Signature data (image, text, etc.)
            $table->enum('signature_type', ['digital', 'typed', 'drawn', 'biometric'])->default('digital');
            $table->string('ip_address', 45);
            $table->text('user_agent');
            $table->string('location', 255)->nullable();
            $table->json('gps_coordinates')->nullable();
            $table->timestamp('signed_at');
            $table->boolean('is_valid')->default(true);
            $table->string('verification_hash', 255); // SHA-256 hash for integrity
            $table->json('certificate_data')->nullable(); // Digital certificate info
            $table->string('purpose', 255)->nullable(); // Purpose of signing
            $table->text('legal_disclaimer')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['signable_type', 'signable_id']);
            $table->index('user_id');
            $table->index('signed_at');
            $table->index('is_valid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_signatures');
    }
};
