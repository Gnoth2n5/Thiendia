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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->comment('Khóa định danh setting');
            $table->text('value')->nullable()->comment('Giá trị (có thể là JSON cho banner)');
            $table->boolean('status')->default(true)->comment('Trạng thái active/inactive');
            $table->text('description')->nullable()->comment('Mô tả setting');
            $table->timestamps();

            $table->index('key');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
