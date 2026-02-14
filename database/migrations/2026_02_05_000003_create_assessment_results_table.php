<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('assessment_type', ['personality', 'skills', 'interest', 'aptitude']);
            $table->json('questions_data');
            $table->json('answers_data');
            $table->text('ai_analysis')->nullable();
            $table->json('scores')->nullable();
            $table->json('recommendations')->nullable();
            $table->timestamp('completed_at');
            $table->timestamps();

            $table->index(['user_id', 'assessment_type']);
            $table->index('completed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_results');
    }
};
