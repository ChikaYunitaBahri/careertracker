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
        Schema::create('recruitment_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 50)->unique();
            $table->string('label', 100);
            $table->string('color', 7);          // hex: #3498DB
            $table->unsignedTinyInteger('order_position');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_statuses');
    }
};
