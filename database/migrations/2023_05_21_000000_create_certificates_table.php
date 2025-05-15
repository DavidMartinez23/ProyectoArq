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
        if (!Schema::hasTable('certificates')) {
            Schema::create('certificates', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('course_id')->constrained()->onDelete('cascade');
                $table->string('full_name'); // <-- ASEGÚRATE DE QUE ESTA LÍNEA ESTÉ EXACTAMENTE ASÍ
                $table->string('email');
                $table->timestamp('issued_at');
                $table->timestamps();
                
                $table->unique(['user_id', 'course_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};