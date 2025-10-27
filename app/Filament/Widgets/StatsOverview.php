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
        $totalUsers = \App\Models\User::count();
        $communeStaff = \App\Models\User::where('role', 'commune_staff')->count();

        return [
            Stat::make('Tổng số nghĩa trang', $totalCemeteries)
                ->description('Nghĩa trang đang quản lý')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('primary'),

            Stat::make('Tổng số liệt sĩ', $totalGraves)
                ->description('Liệt sĩ trong hệ thống')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('success'),

            Stat::make('Người dùng', $totalUsers)
                ->description("{$communeStaff} cán bộ xã/phường")
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Xã/Phường', 129)
                ->description('Được quản lý')
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('warning'),
        ];
    }
}
