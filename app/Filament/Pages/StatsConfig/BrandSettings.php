<?php

namespace App\Filament\Pages\StatsConfig;

use BackedEnum;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Inerba\DbConfig\AbstractPageSettings;
use Filament\Schemas\Components;
use Filament\Schemas\Schema;

class BrandSettings extends AbstractPageSettings
{
    public ?array $data = [];

    protected static ?string $title = 'Brand';

    // protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-wrench-screwdriver'; // Uncomment if you want to set a custom navigation icon

    // protected ?string $subheading = ''; // Uncomment if you want to set a custom subheading

    // protected static ?string $slug = 'website-settings'; // Uncomment if you want to set a custom slug

    protected string $view = 'filament.pages.stats-config.brand-settings';

    protected function settingName(): string
    {
        return 'brand';
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                // You can delete these statements!
                \Filament\Forms\Components\TextInput::make('site-name')
                    ->label('Site Name')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('brand-logo')
                    ->label('Brand Logo')
                    ->hint('For the best results, your logo should be resized / cropped to a 5:2 aspect ratio.')
                    ->directory('branding')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '5:2',
                        null
                    ])
                    ->nullable(),
                FileUpload::make('favicon')
                    ->label('Favicon')
                    ->hint('For the best results, your favicon should be a square image (1:1 aspect ratio).')
                    ->directory('branding')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '1:1',
                        null
                    ])
                    ->nullable(),
                FileUpload::make('header-image')
                    ->label('Header Image')
                    ->hint('For the best results, your image should be resized / cropped to a 16:9 aspect ratio and at least 1440 pixels wide.')
                    ->directory('branding')
                    ->image()
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        null
                    ])
                    ->nullable(),
            ])
            ->statePath('data');
    }
}
