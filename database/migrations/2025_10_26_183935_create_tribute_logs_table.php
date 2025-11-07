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
        Schema::create('tribute_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grave_id')->constrained()->cascadeOnDelete()->comment('Mộ liệt sĩ');
            $table->string('name')->nullable()->comment('Tên người viếng');
            $table->text('message')->nullable()->comment('Lời tri ân');
            $table->string('user_ip', 45)->nullable()->comment('IP người viếng');
            $table->timestamps();

            $table->index('grave_id');
            $table->index('created_at');
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
