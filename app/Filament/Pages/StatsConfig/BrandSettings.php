<?php

namespace App\Filament\Pages\StatsConfig;

use BackedEnum;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Inerba\DbConfig\AbstractPageSettings;
use Filament\Schemas\Components;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Schema;

class BrandSettings extends AbstractPageSettings
{
    public ?array $data = [];

    protected static ?string $title = 'Brand';

    // protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-wrench-screwdriver'; // Uncomment if you want to set a custom navigation icon

    // protected ?string $subheading = ''; // Uncomment if you want to set a custom subheading

    // protected static ?string $slug = 'website-settings'; // Uncomment if you want to set a custom slug

    protected string $view = 'filament.pages.stats-config.brand-settings';

    public $colorOptions = [
        'slate' => 'Slate',
        'gray' => 'Gray',
        'zinc' => 'Zinc',
        'neutral' => 'Neutral',
        'stone' => 'Stone',
        'red' => 'Red',
        'orange' => 'Orange',
        'amber' => 'Amber',
        'yellow' => 'Yellow',
        'lime' => 'Lime',
        'green' => 'Green',
        'emerald' => 'Emerald',
        'teal' => 'Teal',
        'cyan' => 'Cyan',
        'sky' => 'Sky',
        'blue' => 'Blue',
        'indigo' => 'Indigo',
        'violet' => 'Violet',
        'purple' => 'Purple',
        'fuchsia' => 'Fuchsia',
        'pink' => 'Pink',
        'rose' => 'Rose'
    ];

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

                Section::make('Brand Images')
                    ->description('Brand images... every great website needs some branding!')
                    ->columns(2)
                    ->collapsible()
                    ->persistCollapsed()
                    ->schema([
                        FileUpload::make('brand-logo')
                            ->label('Brand Logo')
                            ->hint('5:2 Aspect Ratio - eg: 250 x 100px')
                            ->disk('public')->directory('branding')->visibility('public')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '5:2',
                                null
                            ])

                            ->imagePreviewHeight('250')
                            ->loadingIndicatorPosition('left')
                            ->panelAspectRatio('5:2')
                            ->panelLayout('integrated')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left'),
                        FileUpload::make('favicon')
                            ->label('Favicon')
                            ->hint('1:1 Aspect Ratio - eg: 100 x 100px')
                            ->disk('public')->directory('branding')->visibility('public')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                null
                            ])
                            ->imagePreviewHeight('125')
                            ->loadingIndicatorPosition('left')
                            ->panelLayout('integrated')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left'),
                        FileUpload::make('header-image')
                            ->label('Header Image')
                            ->hint('16:9 Aspect Ratio - eg: 1440 x 810px')
                            ->disk('public')->directory('branding')->visibility('public')
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                null
                            ])
                            ->imagePreviewHeight('300')
                            ->loadingIndicatorPosition('left')
                            ->panelLayout('integrated')
                            ->removeUploadedFileButtonPosition('right')
                            ->uploadButtonPosition('left')
                            ->uploadProgressIndicatorPosition('left')
                            ->columnSpanFull(),
                    ]),
                Section::make('Brand Colors')
                    ->description('Choose colors that will effect the overall look and feel of the stats website.')
                    ->columns(2)
                    ->collapsible()
                    ->persistCollapsed()
                    ->schema([
                        Text::make(
                            str('**Notice** All of the colors to choose from in the following dropboxes are default color pallets from Tailwind CSS v4. Take a look at them at **[https://tailscan.com/colors](https://tailscan.com/colors)**')
                                ->inlineMarkdown()
                                ->toHtmlString()
                        )->columnSpanFull(),
                        Repeater::make('colors')
                            ->hiddenLabel()
                            ->maxItems(1)
                            ->columns(3)
                            ->deletable(false)
                            ->reorderable(false)
                            ->columnSpanFull()
                            ->schema([
                                Select::make('primary')
                                    ->searchable()
                                    ->preload()
                                    ->options($this->colorOptions),
                                Select::make('gray')
                                    ->searchable()
                                    ->preload()
                                    ->options($this->colorOptions),
                                Select::make('success')
                                    ->searchable()
                                    ->preload()
                                    ->options($this->colorOptions),
                                Select::make('info')
                                    ->searchable()
                                    ->preload()
                                    ->options($this->colorOptions),
                                Select::make('warning')
                                    ->searchable()
                                    ->preload()
                                    ->options($this->colorOptions),
                                Select::make('danger')
                                    ->searchable()
                                    ->preload()
                                    ->options($this->colorOptions)

                            ])
                    ])

            ])
            ->statePath('data');
    }
}
