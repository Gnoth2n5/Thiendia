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
            $table->string('deceased_photo')->nullable()->after('deceased_relationship')->comment('Ảnh người đã khuất');
            $table->json('grave_photos')->nullable()->after('deceased_photo')->comment('Ảnh trạng thái bia mộ (JSON array)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('graves', function (Blueprint $table) {
            $table->dropColumn(['deceased_photo', 'grave_photos']);
        });
    }
};
