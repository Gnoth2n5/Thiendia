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
        Schema::create('martyr_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cemetery_id')->constrained()->cascadeOnDelete()->comment('Nghĩa trang');
            $table->string('photo_path')->comment('Đường dẫn ảnh');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete()->comment('Người upload');
            $table->timestamps();

            $table->index('cemetery_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('martyr_photos');
    }
};