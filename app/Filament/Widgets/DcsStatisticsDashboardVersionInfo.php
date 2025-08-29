<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DcsStatisticsDashboardVersionInfo extends Widget
{
    protected static ?int $sort = -2;

    protected static bool $isLazy = false;
    protected string $view = 'filament.widgets.dcs-statistics-dashboard-version-info';

    public function getCardHeading(): string
    {
        return __('System Versions');
    }

    public function getDescription(): string
    {
        return __('Displays the current versions of system dependencies.');
    }

    protected function getViewData(): array
    {
        $dependencies = [
            [
                'name' => 'php',
                'version' => phpversion(),
                'github' => '',
            ],
            [
                'name' => 'laravel',
                'version' => app()->version(),
                'github' => 'laravel/laravel',
            ],
            [
                'name' => 'filament',
                'version' => \Composer\InstalledVersions::getPrettyVersion('filament/filament'),
                'github' => 'filamentphp/filament',
            ],
            [
                'name' => 'filament-dcs-server-stats',
                'version' => \Composer\InstalledVersions::getPrettyVersion('pschilly/filament-dcs-server-stats'),
                'github' => 'pschilly/filament-dcs-server-stats',
            ],
            [
                'name' => 'dcs-server-bot-api',
                'version' => \Composer\InstalledVersions::getPrettyVersion('pschilly/dcs-server-bot-api'),
                'github' => 'pschilly/dcs-server-bot-api',
            ],
        ];

        return [
            'dependencies' => $dependencies,
            'heading' => $this->getCardHeading(),
            'description' => $this->getDescription(),
        ];
    }
}
