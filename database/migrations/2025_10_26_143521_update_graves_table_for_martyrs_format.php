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
            // Thêm các cột mới cho format liệt sĩ
            $table->string('rank_and_unit')->nullable()->after('deceased_full_name')->comment('Cấp bậc, chức vụ, đơn vị');
            $table->string('position')->nullable()->after('rank_and_unit')->comment('Chức vụ');
            $table->string('certificate_number')->nullable()->after('deceased_death_date')->comment('Số bằng TQGC');
            $table->string('decision_number')->nullable()->after('certificate_number')->comment('Số QĐ');
            $table->date('decision_date')->nullable()->after('decision_number')->comment('Ngày cấp QĐ');
            $table->string('next_of_kin')->nullable()->after('deceased_relationship')->comment('Thân nhân');
            $table->year('birth_year')->nullable()->after('deceased_full_name')->comment('Năm sinh');

            // Đổi tên owner_name thành caretaker_name (người quản lý mộ)
            $table->renameColumn('owner_name', 'caretaker_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('graves', function (Blueprint $table) {
            $table->renameColumn('caretaker_name', 'owner_name');

            $table->dropColumn([
                'rank_and_unit',
                'position',
                'certificate_number',
                'decision_number',
                'decision_date',
                'next_of_kin',
                'birth_year',
            ]);
        });
    }
};
