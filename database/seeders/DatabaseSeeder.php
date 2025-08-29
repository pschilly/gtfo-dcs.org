<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Inerba\DbConfig\DbConfig;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default Admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@changeme.com',
            'password' => bcrypt('password')
        ]);

        // Default Settings
        DbConfig::set('brand.site-name', 'DCS Statistics Dashboard');
        DbConfig::set('brand.brand-logo', NULL);
        DbConfig::set('brand.favicon', NULL);
        DbConfig::set('brand.header-image', 'dcs-header-image.jpg');
        DbConfig::set(
            'brand.colors',
            [[
                'primary' => 'emerald',
                'gray' => 'zinc',
                'success' => 'green',
                'info' => 'sky',
                'warning' => 'amber',
                'danger' => 'red'
            ]]
        );

        DbConfig::set('feature.server-selector', TRUE);
        DbConfig::set(
            'feature.pages',
            [
                [
                    'page-name' => 'leaderboard'
                ],
                [
                    'page-name' => 'player-stats'
                ],
                [
                    'page-name' => 'squadrons'
                ],
                [
                    'page-name' => 'servers'
                ]
            ]
        );
        DbConfig::set(
            'feature.dashboard-widgets',
            [
                [
                    'widget-name' => 'server-statistics'
                ],
                [
                    'widget-name' => 'daily-players-chart'
                ],
                [
                    'widget-name' => 'top-pilots'
                ],
                [
                    'widget-name' => 'top-squadrons'
                ]
            ]
        );
        DbConfig::set(
            'feature.player-stats-widgets',
            [
                [
                    'widget-name' => 'pve-chart'
                ],
                [
                    'widget-name' => 'pvp-chart'
                ],
                [
                    'widget-name' => 'module-chart'
                ],
                [
                    'widget-name' => 'sortie-chart'
                ],
                [
                    'widget-name' => 'combat-chart'
                ]
            ]
        );
        DbConfig::set(
            'feature.leaderboard-columns',
            [
                [
                    'column-name' => 'deaths'
                ],
                [
                    'column-name' => 'kdr'
                ],
                [
                    'column-name' => 'credits'
                ],
                [
                    'column-name' => 'playtime'
                ]
            ]
        );
    }
}
