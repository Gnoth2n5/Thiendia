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
            // Drop index trước
            $table->dropIndex(['status', 'grave_type']);

            // Drop column status
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('graves', function (Blueprint $table) {
            $table->enum('status', ['còn_trống', 'đã_sử_dụng', 'bảo_trì', 'ngừng_sử_dụng'])
                ->default('đã_sử_dụng')
                ->after('grave_type')
                ->comment('Trạng thái');

            $table->index(['status', 'grave_type']);
        });
    }
};
