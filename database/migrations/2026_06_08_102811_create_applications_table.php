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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('status_id')
                ->constrained('recruitment_statuses')
                ->restrictOnDelete();
            $table->string('position_name');
            $table->string('company_name');       // redundant, untuk fallback
            $table->date('applied_date');
            $table->string('job_post_url', 500)->nullable();
            $table->string('source', 100)->nullable();
            $table->unsignedBigInteger('salary_min')->nullable();
            $table->unsignedBigInteger('salary_max')->nullable();
            $table->enum('job_type', ['full_time', 'part_time', 'internship', 'contract', 'freelance'])->nullable();
            $table->enum('work_location_type', ['onsite', 'remote', 'hybrid'])->nullable();
            $table->string('location')->nullable();
            $table->string('referral_code', 100)->nullable();
            $table->text('initial_notes')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
