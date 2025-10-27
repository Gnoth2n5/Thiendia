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
            $table->foreignId('cemetery_id')->constrained()->cascadeOnDelete()->comment('Nghĩa trang');
            $table->foreignId('plot_id')->nullable()->constrained('cemetery_plots')->nullOnDelete()->comment('Lô mộ');

            // Thông tin người chăm sóc/liên hệ
            $table->string('caretaker_name')->nullable()->comment('Người chăm sóc');

            // Thông tin liệt sĩ
            $table->string('deceased_full_name')->nullable()->comment('Họ tên liệt sĩ');
            $table->year('birth_year')->nullable()->comment('Năm sinh');
            $table->date('deceased_birth_date')->nullable()->comment('Ngày sinh đầy đủ');
            $table->date('deceased_death_date')->nullable()->comment('Ngày hy sinh');
            $table->string('rank_and_unit')->nullable()->comment('Cấp bậc, chức vụ, đơn vị');
            $table->string('position')->nullable()->comment('Chức vụ');
            $table->string('certificate_number')->nullable()->comment('Số bằng TQGC');
            $table->string('decision_number')->nullable()->comment('Số QĐ');
            $table->date('decision_date')->nullable()->comment('Ngày cấp QĐ');
            $table->enum('deceased_gender', ['nam', 'nữ', 'khác'])->default('nam')->comment('Giới tính');
            $table->string('deceased_relationship')->nullable()->comment('Quan hệ');
            $table->string('next_of_kin')->nullable()->comment('Thân nhân');

            // Hình ảnh
            $table->string('deceased_photo')->nullable()->comment('Ảnh liệt sĩ');
            $table->json('grave_photos')->nullable()->comment('Ảnh mộ');

            // Thông tin an táng
            $table->date('burial_date')->nullable()->comment('Ngày an táng');
            $table->enum('grave_type', ['đất', 'xi_măng', 'đá', 'gỗ', 'khác'])->default('đá')->comment('Loại mộ');
            $table->text('location_description')->nullable()->comment('Mô tả vị trí');

            // Tọa độ GPS
            $table->decimal('latitude', 10, 8)->nullable()->comment('Vĩ độ');
            $table->decimal('longitude', 11, 8)->nullable()->comment('Kinh độ');

            // Thông tin liên hệ & ghi chú
            $table->json('contact_info')->nullable()->comment('Thông tin liên hệ');
            $table->text('notes')->nullable()->comment('Ghi chú');

            $table->timestamps();

            $table->index(['cemetery_id', 'deceased_full_name']);
            $table->index('plot_id');
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
