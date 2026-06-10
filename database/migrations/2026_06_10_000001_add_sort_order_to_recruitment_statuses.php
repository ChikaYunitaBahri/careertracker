<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recruitment_statuses', function (Blueprint $table) {
            $table->unsignedTinyInteger('sort_order')->default(0)->after('slug');
        });

        // Isi urutan sesuai flow rekrutmen
        $order = [
            'wishlist'  => 1,
            'applied'   => 2,
            'hr_screen' => 3,
            'interview' => 4,
            'offering'  => 5,
            'accepted'  => 6,
            'rejected'  => 7,
        ];

        foreach ($order as $slug => $sortOrder) {
            DB::table('recruitment_statuses')
                ->where('slug', $slug)
                ->update(['sort_order' => $sortOrder]);
        }
    }

    public function down(): void
    {
        Schema::table('recruitment_statuses', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};