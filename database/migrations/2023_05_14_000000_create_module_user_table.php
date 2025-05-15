<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('module_user')) {
            Schema::create('module_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('module_id')->constrained()->onDelete('cascade');
                $table->foreignId('course_id')->constrained()->onDelete('cascade');
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();
                
                // Índice único para evitar duplicados
                $table->unique(['user_id', 'module_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('module_user');
    }
};