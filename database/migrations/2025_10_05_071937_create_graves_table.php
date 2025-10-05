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
        Schema::create('graves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cemetery_id')->constrained()->onDelete('cascade');
            $table->string('grave_number')->comment('Số lăng mộ');
            $table->string('owner_name')->comment('Tên chủ lăng mộ');
            $table->json('deceased_persons')->nullable()->comment('Danh sách người đã khuất (JSON)');
            $table->date('burial_date')->nullable()->comment('Ngày an táng');
            $table->enum('grave_type', ['đất', 'xi_măng', 'đá', 'gỗ', 'khác'])->default('đất')->comment('Loại lăng mộ');
            $table->enum('status', ['còn_trống', 'đã_sử_dụng', 'bảo_trì', 'ngừng_sử_dụng'])->default('còn_trống')->comment('Trạng thái');
            $table->text('location_description')->nullable()->comment('Mô tả vị trí');
            $table->json('contact_info')->nullable()->comment('Thông tin liên hệ (JSON)');
            $table->text('notes')->nullable()->comment('Ghi chú');
            $table->timestamps();

            $table->index(['cemetery_id', 'grave_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('graves');
    }
};
