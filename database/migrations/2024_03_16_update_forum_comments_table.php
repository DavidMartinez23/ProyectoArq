<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('forum_comments')) {
            Schema::table('forum_comments', function (Blueprint $table) {
                // Solo agregamos las columnas nuevas
                if (!Schema::hasColumn('forum_comments', 'likes_count')) {
                    $table->integer('likes_count')->default(0);
                }
                if (!Schema::hasColumn('forum_comments', 'is_pinned')) {
                    $table->boolean('is_pinned')->default(false);
                }
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('forum_comments')) {
            Schema::table('forum_comments', function (Blueprint $table) {
                $table->dropColumn(['likes_count', 'is_pinned']);
            });
        }
    }
};