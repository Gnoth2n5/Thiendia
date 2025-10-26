<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('graves', function (Blueprint $table) {
            $table->foreignId('plot_id')->nullable()->after('cemetery_id')->constrained('cemetery_plots')->nullOnDelete()->comment('Lô mộ');
            $table->index('plot_id');
        });
    }

    public function down(): void
    {
        Schema::table('graves', function (Blueprint $table) {
            $table->dropForeign(['plot_id']);
            $table->dropIndex(['plot_id']);
            $table->dropColumn('plot_id');
        });
    }
};
