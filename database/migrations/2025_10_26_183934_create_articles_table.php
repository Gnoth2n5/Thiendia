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
            $table->string('title')->comment('Tiêu đề');
            $table->string('slug')->unique()->comment('Slug URL');
            $table->longText('content')->comment('Nội dung');
            $table->string('featured_image')->nullable()->comment('Ảnh đại diện');
            $table->enum('status', ['draft', 'published'])->default('published')->comment('Trạng thái');
            $table->string('category')->nullable()->comment('Danh mục');
            $table->unsignedBigInteger('views')->default(0)->comment('Lượt xem');
            $table->timestamps();

            $table->index(['status', 'category']);
            $table->index('created_at');
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
