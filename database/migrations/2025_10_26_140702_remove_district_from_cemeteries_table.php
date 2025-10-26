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
        Schema::table('cemeteries', function (Blueprint $table) {
            // Drop index trước khi drop column
            $table->dropIndex(['district', 'commune']);

            // Drop column district
            $table->dropColumn('district');

            // Tạo lại index chỉ cho commune
            $table->index('commune');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cemeteries', function (Blueprint $table) {
            // Thêm lại column district
            $table->string('district')->nullable()->after('name')->comment('Quận/Huyện');

            // Drop index commune
            $table->dropIndex(['commune']);

            // Tạo lại index district + commune
            $table->index(['district', 'commune']);
        });
    }
};
