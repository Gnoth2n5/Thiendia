<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('graves', function (Blueprint $table) {
            $table->string('hometown')->nullable()->after('deceased_birth_date')->comment('Nguyên Quán');
            $table->date('enlistment_date')->nullable()->after('deceased_birth_date')->comment('Ngày nhập ngũ');
            $table->string('rank')->nullable()->after('position')->comment('Cấp bậc');
            $table->string('unit')->nullable()->after('rank')->comment('Đơn vị');
        });

        // Migrate dữ liệu từ rank_and_unit sang rank và unit
        $this->migrateRankAndUnitData();

        // Xóa cột rank_and_unit sau khi migrate xong
        Schema::table('graves', function (Blueprint $table) {
            $table->dropColumn('rank_and_unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('graves', function (Blueprint $table) {
            // Khôi phục cột rank_and_unit
            $table->string('rank_and_unit')->nullable()->after('position')->comment('Cấp bậc, chức vụ, đơn vị');
        });

        // Migrate dữ liệu ngược lại: gộp rank và unit thành rank_and_unit
        $graves = DB::table('graves')->whereNotNull('rank')->orWhereNotNull('unit')->get();
        foreach ($graves as $grave) {
            $rankAndUnit = [];
            if ($grave->rank) {
                $rankAndUnit[] = $grave->rank;
            }
            if ($grave->unit) {
                $rankAndUnit[] = $grave->unit;
            }
            DB::table('graves')
                ->where('id', $grave->id)
                ->update(['rank_and_unit' => ! empty($rankAndUnit) ? implode(', ', $rankAndUnit) : null]);
        }

        Schema::table('graves', function (Blueprint $table) {
            $table->dropColumn(['hometown', 'enlistment_date', 'rank', 'unit']);
        });
    }

    /**
     * Migrate dữ liệu từ rank_and_unit sang rank và unit.
     */
    protected function migrateRankAndUnitData(): void
    {
        $graves = DB::table('graves')->whereNotNull('rank_and_unit')->get();

        foreach ($graves as $grave) {
            $rankAndUnit = trim($grave->rank_and_unit);
            if (empty($rankAndUnit)) {
                continue;
            }

            $parsed = $this->parseRankAndUnit($rankAndUnit);

            DB::table('graves')
                ->where('id', $grave->id)
                ->update([
                    'rank' => $parsed['rank'],
                    'unit' => $parsed['unit'],
                ]);
        }
    }

    /**
     * Parse rank_and_unit thành rank và unit.
     */
    protected function parseRankAndUnit(string $rankAndUnit): array
    {
        $rankAndUnit = trim($rankAndUnit);

        // Nếu có dấu phẩy, tách theo dấu phẩy
        if (str_contains($rankAndUnit, ',')) {
            $parts = array_map('trim', explode(',', $rankAndUnit));
            $rank = $parts[0] ?? null;
            $unit = count($parts) > 1 ? implode(', ', array_slice($parts, 1)) : null;

            return [
                'rank' => $rank ?: null,
                'unit' => $unit ?: null,
            ];
        }

        // Nếu không có dấu phẩy, thử phân tích theo pattern thông thường
        // Các cấp bậc phổ biến trong quân đội Việt Nam
        $commonRanks = [
            'Binh nhất', 'Binh nhì', 'Hạ sĩ', 'Trung sĩ', 'Thượng sĩ',
            'Thiếu úy', 'Trung úy', 'Thượng úy',
            'Đại úy', 'Thiếu tá', 'Trung tá', 'Thượng tá', 'Đại tá',
            'Thiếu tướng', 'Trung tướng', 'Thượng tướng', 'Đại tướng',
            'Chuẩn úy', 'Thượng sĩ', 'Trung sĩ', 'Hạ sĩ',
        ];

        // Tìm cấp bậc trong chuỗi
        $foundRank = null;
        $rankPosition = null;

        foreach ($commonRanks as $commonRank) {
            $pos = mb_stripos($rankAndUnit, $commonRank);
            if ($pos !== false) {
                $foundRank = $commonRank;
                $rankPosition = $pos;
                break;
            }
        }

        if ($foundRank !== null && $rankPosition !== null) {
            // Tách rank và unit
            $rank = $foundRank;
            $unit = trim(mb_substr($rankAndUnit, $rankPosition + mb_strlen($foundRank)));

            // Loại bỏ các ký tự phân cách thừa ở đầu unit
            $unit = ltrim($unit, ', ');

            return [
                'rank' => $rank ?: null,
                'unit' => ! empty($unit) ? $unit : null,
            ];
        }

        // Nếu không tìm thấy pattern, coi toàn bộ là rank
        return [
            'rank' => $rankAndUnit,
            'unit' => null,
        ];
    }
};
