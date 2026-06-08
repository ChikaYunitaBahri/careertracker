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
        Schema::create('application_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('note_type', ['hr_interview', 'user_interview', 'psikotest', 'general'])
                ->default('general');
            $table->dateTime('interview_date')->nullable();
            $table->string('interviewer_name')->nullable();
            $table->text('content');
            $table->text('impression')->nullable();
            $table->timestamps();

            $table->index('application_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_notes');
    }
};
