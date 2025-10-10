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
        Schema::table('articles', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['author_id']);
            // Remove excerpt and author_id columns
            $table->dropColumn(['excerpt', 'author_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Add back the removed columns
            $table->text('excerpt')->nullable()->comment('Tóm tắt bài viết');
            $table->foreignId('author_id')->constrained('users')->comment('Tác giả');
        });
    }
};
