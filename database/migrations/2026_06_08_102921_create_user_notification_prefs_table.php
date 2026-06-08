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
        Schema::create('user_notification_prefs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->boolean('email_enabled')->default(true);
            $table->boolean('push_enabled')->default(true);
            $table->boolean('interview_reminder_email')->default(true);
            $table->boolean('interview_reminder_push')->default(true);
            $table->boolean('idle_application_email')->default(true);
            $table->boolean('idle_application_push')->default(false);
            $table->boolean('goal_milestone_push')->default(true);
            $table->boolean('weekly_summary_email')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_notification_prefs');
    }
};
