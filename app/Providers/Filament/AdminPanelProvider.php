<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('Quản lý nghĩa địa')
            ->brandLogo(asset('images/logo.png'))
            ->favicon(asset('images/favicon.ico'))
            ->colors([
                'primary' => [
                    50 => '#f7fafc',
                    100 => '#edf2f7',
                    200 => '#e2e8f0',
                    300 => '#cbd5e0',
                    400 => '#a0aec0',
                    500 => '#718096',
                    600 => '#4a5568',
                    700 => '#2d3748',
                    800 => '#1a202c',
                    900 => '#171923',
                    950 => '#0f1419',
                ],
                'gray' => [
                    50 => '#f7fafc',
                    100 => '#edf2f7',
                    200 => '#e2e8f0',
                    300 => '#cbd5e0',
                    400 => '#a0aec0',
                    500 => '#718096',
                    600 => '#4a5568',
                    700 => '#2d3748',
                    800 => '#1a202c',
                    900 => '#171923',
                    950 => '#0f1419',
                ],
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\RecentModificationRequests::class,
                AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
