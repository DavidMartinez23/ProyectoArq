<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('forum_comments')) {
            Schema::create('forum_comments', function (Blueprint $table) {
                $table->id();
                $table->text('content');
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('user_type');
                $table->foreignId('parent_id')->nullable()->constrained('forum_comments')->onDelete('cascade');
                $table->integer('likes_count')->default(0);
                $table->boolean('is_pinned')->default(false);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('forum_comments');
    }
};