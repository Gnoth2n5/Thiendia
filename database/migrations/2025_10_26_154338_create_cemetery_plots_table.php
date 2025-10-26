<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cemetery_plots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cemetery_id')->constrained()->cascadeOnDelete()->comment('Nghĩa trang');
            $table->string('plot_code')->comment('Mã lô (VD: A1, B5)');
            $table->integer('row')->comment('Số hàng');
            $table->integer('column')->comment('Số cột');
            $table->enum('status', ['available', 'occupied', 'reserved', 'unavailable'])->default('available')->comment('Trạng thái lô');
            $table->text('notes')->nullable()->comment('Ghi chú');
            $table->timestamps();

            $table->unique(['cemetery_id', 'plot_code']);
            $table->index(['cemetery_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cemetery_plots');
    }
};
