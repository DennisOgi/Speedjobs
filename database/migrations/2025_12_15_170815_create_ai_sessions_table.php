<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('module', ['career_assessment', 'interview_prep', 'resume_review']);
            $table->enum('status', ['in_progress', 'completed', 'abandoned'])->default('in_progress');
            $table->integer('current_step')->default(0);
            $table->integer('total_steps')->default(0);
            $table->json('context_data')->nullable(); // Pre-filled user profile data
            $table->json('report_data')->nullable();   // Final AI-generated report
            $table->timestamps();
            
            $table->index(['user_id', 'module', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_sessions');
    }
};
