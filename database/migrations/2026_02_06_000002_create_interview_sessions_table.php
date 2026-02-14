<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interview_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('role');
            $table->enum('experience_level', ['entry', 'mid', 'senior']);
            $table->json('questions_data');
            $table->json('answers_data')->nullable();
            $table->json('evaluations_data')->nullable();
            $table->json('scores')->nullable();
            $table->integer('questions_count')->default(0);
            $table->decimal('average_score', 5, 2)->nullable();
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('started_at');
            $table->index('completed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interview_sessions');
    }
};
