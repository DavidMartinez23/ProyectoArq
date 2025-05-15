<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            if (!Schema::hasColumn('modules', 'video_url')) {
                $table->string('video_url')->nullable();
            }
            if (!Schema::hasColumn('modules', 'duration')) {
                $table->string('duration')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn(['video_url', 'duration']);
        });
    }
};