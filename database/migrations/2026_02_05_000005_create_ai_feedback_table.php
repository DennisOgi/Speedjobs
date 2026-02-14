<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('message_id')->constrained('ai_messages')->onDelete('cascade');
            $table->integer('rating')->nullable();
            $table->text('feedback_text')->nullable();
            $table->boolean('is_helpful')->default(true);
            $table->timestamp('created_at');

            $table->index(['message_id', 'rating']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_feedback');
    }
};
