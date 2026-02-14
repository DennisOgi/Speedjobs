<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resume_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_name');
            $table->longText('resume_text');
            $table->text('job_description')->nullable();
            $table->longText('ai_analysis');
            $table->integer('ats_score')->default(0);
            $table->timestamp('analyzed_at');
            $table->timestamps();

            $table->index('user_id');
            $table->index('ats_score');
            $table->index('analyzed_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resume_analyses');
    }
};
