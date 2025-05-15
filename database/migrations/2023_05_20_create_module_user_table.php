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
        // This migration is a duplicate or no longer needed.
        // The module_user table is created by another migration.
        // We leave this method empty to prevent errors.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Correspondingly, the down method can also be empty.
        // Or, if you want to be very specific, you could check if the
        // table exists before trying to drop it, but it's generally
        // handled by the "correct" migration's down method.
        // Schema::dropIfExists('module_user'); // Be cautious if multiple migrations manage this.
    }
};