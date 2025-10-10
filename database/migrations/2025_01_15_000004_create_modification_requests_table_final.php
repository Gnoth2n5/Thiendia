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
        Schema::create('modification_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grave_id')->constrained()->onDelete('cascade');
            $table->string('requester_name')->comment('Tên người yêu cầu');
            $table->string('requester_phone')->comment('Số điện thoại');
            $table->string('requester_email')->nullable()->comment('Email');
            $table->string('requester_relationship')->nullable()->comment('Mối quan hệ với người đã khuất');
            $table->enum('request_type', ['sửa_thông_tin', 'thêm_người', 'xóa_người', 'sửa_vị_trí', 'khác'])->comment('Loại yêu cầu');
            $table->json('current_data')->nullable()->comment('Dữ liệu hiện tại (JSON)');
            $table->json('requested_data')->comment('Dữ liệu yêu cầu sửa đổi (JSON)');
            $table->text('reason')->comment('Lý do yêu cầu');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->comment('Trạng thái');
            $table->text('admin_notes')->nullable()->comment('Ghi chú của admin');
            $table->foreignId('processed_by')->nullable()->constrained('users')->comment('Admin xử lý');
            $table->timestamp('processed_at')->nullable()->comment('Thời gian xử lý');
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['grave_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modification_requests');
    }
};
