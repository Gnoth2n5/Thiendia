<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Tiêu đề bài viết');
            $table->string('slug')->unique()->comment('URL slug');
            $table->text('excerpt')->nullable()->comment('Tóm tắt bài viết');
            $table->longText('content')->comment('Nội dung bài viết');
            $table->string('featured_image')->nullable()->comment('Ảnh đại diện');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft')->comment('Trạng thái');
            $table->enum('category', ['tin_tuc', 'huong_dan', 'thong_bao', 'su_kien'])->default('tin_tuc')->comment('Danh mục');
            $table->json('tags')->nullable()->comment('Thẻ tag');
            $table->integer('views')->default(0)->comment('Lượt xem');
            $table->boolean('is_featured')->default(false)->comment('Bài viết nổi bật');
            $table->foreignId('author_id')->constrained('users')->comment('Tác giả');
            $table->timestamp('published_at')->nullable()->comment('Thời gian xuất bản');
            $table->timestamps();

            $table->index(['status', 'published_at']);
            $table->index(['category', 'status']);
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
