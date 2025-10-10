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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('Tiêu đề bài viết');
            $table->string('slug')->unique()->comment('URL slug');
            $table->longText('content')->comment('Nội dung bài viết');
            $table->string('featured_image')->nullable()->comment('Ảnh đại diện');
            $table->enum('status', ['draft', 'published'])->default('draft')->comment('Trạng thái');
            $table->enum('category', ['tin_tuc', 'huong_dan', 'thong_bao'])->default('tin_tuc')->comment('Danh mục');
            $table->integer('views')->default(0)->comment('Lượt xem');
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['category', 'status']);
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
