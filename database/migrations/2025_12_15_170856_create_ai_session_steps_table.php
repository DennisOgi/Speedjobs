<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_session_steps', function (Blueprint $table) {
            $table->id();
            $table->uuid('session_id');
            $table->foreign('session_id')->references('id')->on('ai_sessions')->onDelete('cascade');
            $table->integer('step_number');
            $table->string('step_type'); // 'question', 'input', 'feedback', 'upload'
            $table->text('prompt')->nullable();   // The AI's question or prompt
            $table->text('response')->nullable(); // User's answer
            $table->json('metadata')->nullable(); // Extra data (e.g., AI feedback, score)
            $table->timestamps();

            $table->index(['session_id', 'step_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_session_steps');
    }
};
