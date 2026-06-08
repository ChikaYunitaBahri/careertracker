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

            $table->foreignId('goal_id')
                ->constrained('career_goals')
                ->cascadeOnDelete();

            $table->string('title');

            $table->text('description')->nullable();

            $table->date('due_date')->nullable();

            $table->boolean('is_completed')->default(false);

            $table->timestamp('completed_at')->nullable();

            $table->unsignedTinyInteger('order_position')->default(1);

            $table->timestamps();

            $table->index(['goal_id', 'is_completed']);
            $table->index(['goal_id', 'order_position']);
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