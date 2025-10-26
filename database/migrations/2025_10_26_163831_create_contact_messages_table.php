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
    Schema::create('contact_messages', function (Blueprint $table) {
      $table->id();
      $table->string('name')->comment('Họ và tên');
      $table->string('phone')->comment('Số điện thoại');
      $table->string('email')->nullable()->comment('Email');
      $table->string('subject')->comment('Chủ đề');
      $table->text('message')->comment('Nội dung tin nhắn');
      $table->enum('status', ['pending', 'read', 'replied', 'closed'])->default('pending')->comment('Trạng thái');
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
