<?php

namespace App\Filament\Pages\StatsConfig;

use BackedEnum;
use Filament\Schemas\Components\Text;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Inerba\DbConfig\AbstractPageSettings;
use Filament\Schemas\Components;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class FeatureSettings extends AbstractPageSettings
{
    public ?array $data = [];

    protected static ?string $title = 'Feature';

    // protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-wrench-screwdriver'; // Uncomment if you want to set a custom navigation icon

    // protected ?string $subheading = ''; // Uncomment if you want to set a custom subheading

    // protected static ?string $slug = 'website-settings'; // Uncomment if you want to set a custom slug

    protected string $view = 'filament.pages.stats-config.feature-settings';

    protected function settingName(): string
    {
        return 'feature';
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('server-selector')->onIcon(Heroicon::ServerStack)->label('Enable Server Selector')->helperText('Show a server selector on the website to allow users to switch between different game servers.')->default(true),
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Pages')
                            ->icon(Heroicon::DocumentDuplicate)
                            ->badge(fn($state) => count($state['pages'] ?? []))->badgeColor('info')
                            ->schema([

                                Text::make(
                                    str('**Notice** The order that you sort the page selected here will carry through to the navigation bar.')
                                        ->inlineMarkdown()
                                        ->toHtmlString()
                                )->color('info'),
                                Repeater::make('pages')
                                    ->live()
                                    ->hiddenLabel()
                                    ->schema([
                                        Select::make('page-name')
                                            ->hiddenLabel()
                                            ->searchable()
                                            ->preload()
                                            ->options([
                                                'leaderboard' => 'Leaderboard',
                                                'player-stats' => 'Player Stats',
                                                'squadrons' => 'Squadrons',
                                                'servers' => 'Servers'
                                            ])->distinct()->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ])
                                    ->grid(4)
                                    ->maxItems(4)
                                    ->addActionLabel('Add Page'),

                                Text::make(
                                    str('**WARNING:** Ensure that you have the *squadrons* feature enabled before choosing that page.')
                                        ->inlineMarkdown()
                                        ->toHtmlString()
                                )->color('warning'),
                            ]),
                        Tab::make('Dashboard Widgets')
                            ->icon(Heroicon::QrCode)
                            ->badge(fn($state) => count($state['dashboard-widgets'] ?? []))->badgeColor('info')
                            ->schema([
                                Text::make(
                                    str('**Notice** The order that you sort the widgets selected here will carry through to the dashboard.')
                                        ->inlineMarkdown()
                                        ->toHtmlString()
                                )->color('info'),
                                Repeater::make('dashboard-widgets')
                                    ->live()
                                    ->hiddenLabel()
                                    ->schema([
                                        Select::make('widget-name')
                                            ->hiddenLabel()
                                            ->searchable()
                                            ->preload()
                                            ->options([
                                                'server-statistics'   => 'Server Statistics',
                                                'daily-players-chart' => 'Daily Players Chart',
                                                'top-pilots'          => 'Top Pilots',
                                                'top-squadrons'       => 'Top Squadrons',
                                            ])->distinct()->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ])
                                    ->grid(2)
                                    ->maxItems(4)
                                    ->addActionLabel('Add Widget'),
                            ]),
                        Tab::make('Leaderboard Columns')
                            ->icon(Heroicon::ChartBar)
                            ->badge(fn($state) => count($state['leaderboard-columns'] ?? []))->badgeColor('info')
                            ->schema([
                                Text::make(
                                    str('**Notice** The order that you sort the columns selected here will carry through to the leaderboard.')
                                        ->inlineMarkdown()
                                        ->toHtmlString()
                                )->color('info'),
                                Repeater::make('leaderboard-columns')
                                    ->live()
                                    ->hiddenLabel()
                                    ->schema([
                                        Select::make('column-name')
                                            ->searchable()
                                            ->hiddenLabel()
                                            ->preload()
                                            ->options([
                                                'deaths' => 'Deaths',
                                                'kdr' => 'KDR',
                                                'credits' => 'Credits',
                                                'playtime' => 'Play Time'
                                            ])->distinct()->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ])
                                    ->maxItems(4)
                                    ->grid(4)
                                    ->addActionLabel('Add Column'),
                                Text::make(
                                    str('**Notice** The leaderboard will always have `Ranking`, `Callsign` and `Kills` as a bare minimum. For `credits`, make sure you have that part enabled in the Server Bot!')
                                        ->inlineMarkdown()
                                        ->toHtmlString()
                                )->color('warning'),
                            ]),
                        Tab::make('Player Statistics Widgets')
                            ->icon('pilot')
                            ->badge(fn($state) => count($state['player-stats-widgets'] ?? []))->badgeColor('info')
                            ->schema([
                                Text::make(
                                    str('**Notice** The order that you sort the widgets selected here will carry through to the player statstics page.')
                                        ->inlineMarkdown()
                                        ->toHtmlString()
                                )->color('info'),
                                Repeater::make('player-stats-widgets')
                                    ->live()
                                    ->hiddenLabel()
                                    ->schema([
                                        Select::make('widget-name')
                                            ->hiddenLabel()
                                            ->searchable()
                                            ->preload()
                                            ->options([
                                                'pve-chart' => 'PvE Chart',
                                                'pvp-chart' => 'PvP Chart',
                                                'module-chart' => 'Module Chart',
                                                'sortie-chart' => 'Sortie Chart',
                                                'combat-chart' => 'Combat Chart'
                                            ])->distinct()->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ])
                                    ->grid(2)
                                    ->maxItems(5)
                                    ->addActionLabel('Add Widget')
                            ])
                    ])
            ])
            ->statePath('data');
    }
}
