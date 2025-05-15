<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('modules')) {
            Schema::table('modules', function (Blueprint $table) {
                // Verificar si la columna content ya existe
                if (!Schema::hasColumn('modules', 'content')) {
                    $table->text('content')->nullable();
                }
                
                // Añadir columna video_url
                if (!Schema::hasColumn('modules', 'video_url')) {
                    $table->string('video_url')->nullable();
                }
                
                // Añadir columna duration
                if (!Schema::hasColumn('modules', 'duration')) {
                    $table->string('duration')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('modules')) {
            Schema::table('modules', function (Blueprint $table) {
                // Eliminar columnas añadidas
                $table->dropColumn(['content', 'video_url', 'duration']);
            });
        }
    }
};