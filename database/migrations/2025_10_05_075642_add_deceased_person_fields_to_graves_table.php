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
            $table->string('deceased_full_name')->nullable()->after('owner_name')->comment('Họ tên người đã khuất');
            $table->date('deceased_birth_date')->nullable()->after('deceased_full_name')->comment('Ngày sinh');
            $table->date('deceased_death_date')->nullable()->after('deceased_birth_date')->comment('Ngày mất');
            $table->enum('deceased_gender', ['nam', 'nữ', 'khác'])->default('nam')->after('deceased_death_date')->comment('Giới tính');
            $table->string('deceased_relationship')->nullable()->after('deceased_gender')->comment('Mối quan hệ với chủ lăng mộ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('graves', function (Blueprint $table) {
            $table->dropColumn([
                'deceased_full_name',
                'deceased_birth_date',
                'deceased_death_date',
                'deceased_gender',
                'deceased_relationship',
            ]);
        });
    }
};
