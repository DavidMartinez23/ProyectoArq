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
        // This migration is no longer needed as 'video_url'
        // is included in the initial 'create_courses_table' migration.
        // We leave this method empty to prevent errors.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // If you ever needed to roll back, you might check if the column
        // exists and then drop it, but only if it wasn't part of the
        // initial table schema. For simplicity now, we can leave this empty too.
        // Schema::table('courses', function (Blueprint $table) {
        //     if (Schema::hasColumn('courses', 'video_url')) {
        //         $table->dropColumn('video_url');
        //     }
        // });
    }
};