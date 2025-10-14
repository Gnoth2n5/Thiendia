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
            $table->decimal('latitude', 10, 8)->nullable()->after('location_description')->comment('Vĩ độ GPS');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude')->comment('Kinh độ GPS');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('graves', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};
