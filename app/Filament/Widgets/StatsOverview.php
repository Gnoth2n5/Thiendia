<?php

namespace App\Filament\Widgets;

use App\Models\Cemetery;
use App\Models\Grave;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalCemeteries = Cemetery::count();
        $totalGraves = Grave::count();
        $occupiedGraves = Grave::where('status', 'đã_sử_dụng')->count();
        $availableGraves = $totalGraves - $occupiedGraves;

        return [
            Stat::make('Tổng số nghĩa trang', $totalCemeteries)
                ->description('Nghĩa trang đang quản lý')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary'),

            Stat::make('Tổng số lăng mộ', $totalGraves)
                ->description('Lăng mộ trong hệ thống')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('success'),

            Stat::make('Lăng mộ đã sử dụng', $occupiedGraves)
                ->description(sprintf('%.1f%% tổng số lăng mộ', $totalGraves > 0 ? ($occupiedGraves / $totalGraves) * 100 : 0))
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('info'),

            Stat::make('Lăng mộ còn trống', $availableGraves)
                ->description('Có thể sử dụng')
                ->descriptionIcon('heroicon-m-square-3-stack-3d')
                ->color('warning'),
        ];
    }
}
