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
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name')->default('My Resume');
            $table->string('template')->default('professional');
            $table->string('color_scheme')->default('blue');
            $table->string('photo')->nullable();
            
            // Personal Information
            $table->string('full_name')->nullable();
            $table->string('job_title')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('website')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->text('summary')->nullable();
            
            // Structured Data (JSON)
            $table->json('experience')->nullable();
            $table->json('education')->nullable();
            $table->json('skills')->nullable();
            $table->json('languages')->nullable();
            $table->json('certifications')->nullable();
            $table->json('projects')->nullable();
            $table->json('awards')->nullable();
            $table->json('references')->nullable();
            
            // Settings
            $table->json('section_order')->nullable();
            $table->json('visible_sections')->nullable();
            
            $table->boolean('is_primary')->default(false);
            $table->timestamp('last_edited_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
