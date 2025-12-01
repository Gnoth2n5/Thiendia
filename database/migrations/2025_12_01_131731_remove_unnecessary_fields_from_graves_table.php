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
        Schema::table('graves', function (Blueprint $table) {
            // Xóa các trường không cần thiết
            $table->dropColumn([
                'caretaker_name',
                'birth_year',
                'certificate_number',
                'decision_number',
                'decision_date',
                'deceased_gender',
                'deceased_relationship',
                'next_of_kin',
                'burial_date',
                'grave_type',
                'location_description',
                'latitude',
                'longitude',
                'contact_info',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('graves', function (Blueprint $table) {
            // Khôi phục các trường đã xóa
            $table->string('caretaker_name')->nullable()->comment('Người chăm sóc');
            $table->year('birth_year')->nullable()->comment('Năm sinh');
            $table->string('certificate_number')->nullable()->comment('Số bằng TQGC');
            $table->string('decision_number')->nullable()->comment('Số QĐ');
            $table->date('decision_date')->nullable()->comment('Ngày cấp QĐ');
            $table->enum('deceased_gender', ['nam', 'nữ', 'khác'])->default('nam')->comment('Giới tính');
            $table->string('deceased_relationship')->nullable()->comment('Quan hệ');
            $table->string('next_of_kin')->nullable()->comment('Thân nhân');
            $table->date('burial_date')->nullable()->comment('Ngày an táng');
            $table->enum('grave_type', ['đất', 'xi_măng', 'đá', 'gỗ', 'khác'])->default('đá')->comment('Loại mộ');
            $table->text('location_description')->nullable()->comment('Mô tả vị trí');
            $table->decimal('latitude', 10, 8)->nullable()->comment('Vĩ độ');
            $table->decimal('longitude', 11, 8)->nullable()->comment('Kinh độ');
            $table->json('contact_info')->nullable()->comment('Thông tin liên hệ');
        });
    }
};
