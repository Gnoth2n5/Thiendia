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
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Tên người gửi');
            $table->string('phone')->nullable()->comment('Số điện thoại');
            $table->string('email')->comment('Email');
            $table->string('subject')->comment('Tiêu đề');
            $table->text('message')->comment('Nội dung');
            $table->enum('status', ['pending', 'replied', 'closed'])->default('pending')->comment('Trạng thái');
            $table->text('admin_reply')->nullable()->comment('Phản hồi từ admin');
            $table->timestamp('replied_at')->nullable()->comment('Thời gian phản hồi');
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
    }
};
