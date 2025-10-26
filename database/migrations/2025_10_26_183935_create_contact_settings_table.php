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
        Schema::create('contact_settings', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable()->comment('Số điện thoại');
            $table->string('phone_description')->nullable()->comment('Mô tả điện thoại');
            $table->string('email')->nullable()->comment('Email');
            $table->string('email_description')->nullable()->comment('Mô tả email');
            $table->string('address_line1')->nullable()->comment('Địa chỉ dòng 1');
            $table->string('address_line2')->nullable()->comment('Địa chỉ dòng 2');
            $table->string('address_description')->nullable()->comment('Mô tả địa chỉ');
            $table->json('working_hours')->nullable()->comment('Giờ làm việc');
            $table->text('note')->nullable()->comment('Ghi chú');
            $table->boolean('is_active')->default(true)->comment('Đang hoạt động');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_settings');
    }
};
