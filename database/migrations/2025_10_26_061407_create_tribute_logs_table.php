<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * Creates the tribute_logs table to store memorial tributes for graves.
   * Includes rate limiting indexes to prevent spam (1 tribute per IP per grave per day).
   */
  public function up(): void
  {
    Schema::create('tribute_logs', function (Blueprint $table) {
      $table->id();

      // Foreign key to graves table
      $table->foreignId('grave_id')->constrained('graves')->onDelete('cascade');

      // Tribute information
      $table->string('name', 255)->nullable()->comment('Tên người thắp hương (có thể để trống để ẩn danh)');
      $table->text('message')->nullable()->comment('Lời tưởng niệm (tối đa 500 ký tự)');

      // User identification for rate limiting
      $table->string('user_ip', 45)->comment('IP address của người dùng để giới hạn spam');

      $table->timestamps();

      // Indexes for performance and rate limiting
      $table->index('grave_id');
      $table->index(['grave_id', 'user_ip', 'created_at'], 'tribute_rate_limit_idx');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('tribute_logs');
  }
};
