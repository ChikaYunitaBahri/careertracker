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
        Schema::create('goal_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goal_id')->constrained('career_goals')->cascadeOnDelete();
            $table->string('title');
            $table->unsignedInteger('target_count');
            $table->boolean('is_achieved')->default(false);
            $table->timestamp('achieved_at')->nullable();
            $table->unsignedTinyInteger('order_position')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goal_milestones');
    }
};
