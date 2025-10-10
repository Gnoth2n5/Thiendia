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
        Schema::create('deceased_persons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grave_id')->constrained()->onDelete('cascade');
            $table->string('full_name')->comment('Họ tên đầy đủ');
            $table->date('birth_date')->nullable()->comment('Ngày sinh');
            $table->date('death_date')->nullable()->comment('Ngày mất');
            $table->enum('gender', ['nam', 'nữ', 'khác'])->default('nam')->comment('Giới tính');
            $table->string('relationship')->nullable()->comment('Mối quan hệ với chủ lăng mộ');
            $table->string('photo')->nullable()->comment('Ảnh người đã khuất');
            $table->text('biography')->nullable()->comment('Tiểu sử');
            $table->text('notes')->nullable()->comment('Ghi chú');
            $table->timestamps();

            $table->index(['grave_id', 'full_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deceased_persons');
    }
};
