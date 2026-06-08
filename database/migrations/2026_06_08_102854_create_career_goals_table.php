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
        Schema::create('career_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->enum('job_type', ['full_time', 'part_time', 'internship', 'contract', 'freelance'])->nullable();
            $table->json('target_industries')->nullable();
            $table->json('target_cities')->nullable();
            $table->unsignedInteger('target_application_count')->default(20);
            $table->unsignedInteger('current_count')->default(0);
            $table->unsignedBigInteger('target_salary_min')->nullable();
            $table->date('deadline')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'achieved', 'archived'])->default('active');
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_goals');
    }
};
