<?php

namespace App\Providers\Filament;

use App\Filament\Pages\StatsConfig\BrandSettings;
use App\Filament\Pages\StatsConfig\FeatureSettings;
use App\Filament\Widgets\DcsStatisticsDashboardVersionInfo;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class StatsConfigPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('stats-config')
            ->path('stats-config')
            ->brandName('DCS Statistics Configurator')
            ->login()
            ->profile()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->pages([
                Dashboard::class,
                BrandSettings::class,
                FeatureSettings::class,
            ])
            ->widgets([
                DcsStatisticsDashboardVersionInfo::class,
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
            ])
            ->viteTheme('resources/css/filament/public/theme.css');
    }
}
