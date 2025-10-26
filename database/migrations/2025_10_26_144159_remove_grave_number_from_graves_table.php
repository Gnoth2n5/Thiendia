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
            // Drop column grave_number (index sẽ tự động drop)
            $table->dropColumn('grave_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('graves', function (Blueprint $table) {
            $table->string('grave_number')->after('cemetery_id')->comment('Số lăng mộ');
            $table->index(['cemetery_id', 'grave_number']);
        });
    }
};
