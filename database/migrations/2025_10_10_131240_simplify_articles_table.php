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
            // Remove unnecessary columns for simplified article management
            $table->dropColumn([
                'featured_image',
                'tags',
                'is_featured',
                'published_at'
            ]);

            // Update category enum to remove 'su_kien'
            $table->dropColumn('category');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->enum('category', ['tin_tuc', 'huong_dan', 'thong_bao'])->default('tin_tuc')->comment('Danh mục');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Add back the removed columns
            $table->string('featured_image')->nullable()->comment('Ảnh đại diện');
            $table->json('tags')->nullable()->comment('Thẻ tag');
            $table->boolean('is_featured')->default(false)->comment('Bài viết nổi bật');
            $table->timestamp('published_at')->nullable()->comment('Thời gian xuất bản');

            // Restore original category enum
            $table->dropColumn('category');
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->enum('category', ['tin_tuc', 'huong_dan', 'thong_bao', 'su_kien'])->default('tin_tuc')->comment('Danh mục');
        });
    }
};
