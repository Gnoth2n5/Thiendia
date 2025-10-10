<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('graves', function (Blueprint $table) {
            $table->dropColumn(['district', 'commune']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('graves', function (Blueprint $table) {
            $table->string('district')->nullable()->after('cemetery_id')->comment('Huyện/Thành phố');
            $table->string('commune')->nullable()->after('district')->comment('Xã/Phường/Thị trấn');
        });
    }
};
