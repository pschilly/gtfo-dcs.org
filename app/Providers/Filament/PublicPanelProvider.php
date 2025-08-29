<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PublicPanelProvider extends PanelProvider
{
    protected function resolveConfiguredPages(): array
    {
        $raw = db_config('feature.pages', []);

        // Allow wildcard to mean "all default pages" (handled by plugin if we return empty here)
        if ($raw === '*' || (is_array($raw) && in_array('*', $raw, true))) {
            return []; // Let plugin load its defaults
        }

        // Extract page-name from each object
        $slugs = collect($raw)->pluck('page-name')->all();

        $overrides = [
            'player-stats' => 'PlayerStats',
            'leaderboard'  => 'Leaderboard',
            'squadrons'    => 'Squadrons',
            'servers'      => 'Servers',
        ];

        return collect($slugs)
            ->filter()
            ->unique()
            ->map(function (string $slug) use ($overrides) {
                $classBase = $overrides[$slug] ?? \Illuminate\Support\Str::studly($slug);
                $fqcn = "Pschilly\\FilamentDcsServerStats\\Pages\\{$classBase}";
                return class_exists($fqcn) ? $fqcn : null;
            })
            ->filter()
            ->values()
            ->all();
    }

    protected function resolveDashboardWidgets(): array
    {
        $raw = db_config('feature.dashboard-widgets', []);

        // Allow wildcard to mean "all default widgets" (handled by plugin if we return empty here)
        if ($raw === '*' || (is_array($raw) && in_array('*', $raw, true))) {
            return []; // Let plugin load its defaults
        }

        // Extract widget-name from each object
        $slugs = collect($raw)->pluck('widget-name')->all();

        $overrides = [
            'daily-players-chart' => 'DailyPlayersChart',
            'server-statistics'   => 'ServerStatistics',
            'top-pilots'          => 'TopPilots',
            'top-squadrons'       => 'TopSquadrons',
        ];

        return collect($slugs)
            ->filter()
            ->unique()
            ->map(function (string $slug) use ($overrides) {
                $classBase = $overrides[$slug] ?? \Illuminate\Support\Str::studly($slug);
                $fqcn = "Pschilly\\FilamentDcsServerStats\\Widgets\\{$classBase}";
                return class_exists($fqcn) ? $fqcn : null;
            })
            ->filter()
            ->values()
            ->all();
    }

    protected function resolveLeaderboardColumns(): array
    {
        $slugs = db_config('feature.leaderboard-columns', []);

        // If wildcard, return empty array (let plugin load defaults)
        if ($slugs === '*' || (is_array($slugs) && in_array('*', $slugs, true))) {
            return [];
        }

        // If it's a string, wrap in array
        if (is_string($slugs)) {
            return [$slugs];
        }

        return is_array($slugs) ? $slugs : [];
    }

    protected function resolvePlayerStatsWidgets(): array
    {
        $slugs = db_config('feature.player-stats-widgets', []);

        // Allow wildcard to mean "all default widgets" (handled by plugin if we return empty here)
        if ($slugs === '*' || (is_array($slugs) && in_array('*', $slugs, true))) {
            return []; // Let plugin load its defaults
        }

        return $slugs;
    }

    protected function resolveServerSelector(): bool
    {
        return db_config('feature.server-selector', false);
    }

    protected function resolveBrandName(): string
    {
        return db_config('brand.site-name', config('app.name'));
    }
    protected function resolveBrandLogo(): ?string
    {
        $logo = db_config('brand.site-logo', '');
        return empty($logo) ? null : secure_asset('/storage/' . $logo);
    }

    protected function resolveFavicon(): ?string
    {
        $favicon = db_config('brand.favicon', '');
        return empty($favicon) ? null : secure_asset('/storage/' . $favicon);
    }

    protected function resolveColors(): array
    {
        $raw = db_config('brand.colors', []);
        $colors = is_array($raw) && isset($raw[0]) ? $raw[0] : [];

        $keys = ['primary', 'gray', 'success', 'info', 'warning', 'danger'];
        $defaults = [
            'primary' => 'Emerald',
            'gray'    => 'Stone',
            'success' => 'Green',
            'info'    => 'Sky',
            'warning' => 'Amber',
            'danger'  => 'Red',
        ];

        $result = [];
        foreach ($keys as $key) {
            // Convert tailwind color to StudlyCase for constant name
            $color = $colors[$key] ?? strtolower($defaults[$key]);
            $studly = \Illuminate\Support\Str::studly($color);
            $const = "Filament\\Support\\Colors\\Color::{$studly}";
            $result[$key] = defined($const) ? constant($const) : constant("Filament\\Support\\Colors\\Color::{$defaults[$key]}");
        }
        return $result;
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('public')
            ->path('')
            ->topNavigation()
            ->brandName($this->resolveBrandName())
            ->brandLogo($this->resolveBrandLogo())
            ->favicon($this->resolveFavicon())
            ->colors($this->resolveColors())
            ->pages([
                Dashboard::class,
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
            ->authMiddleware([])
            ->plugins([
                \Pschilly\FilamentDcsServerStats\FilamentDcsServerStatsPlugin::make()
                    ->serverSelector($this->resolveServerSelector())
                    ->pages($this->resolveConfiguredPages())
                    ->dashboardWidgets($this->resolveDashboardWidgets())
                    ->leaderboardColumns($this->resolveLeaderboardColumns())
                    ->playerStatsWidgets($this->resolvePlayerStatsWidgets()),
            ])
            ->viteTheme('resources/css/filament/public/theme.css')
            ->spa();
    }
}
