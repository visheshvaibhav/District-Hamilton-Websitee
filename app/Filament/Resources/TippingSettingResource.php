<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TippingSettingResource\Pages;
use App\Models\TippingSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TippingSettingResource extends Resource
{
    protected static ?string $model = TippingSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    
    protected static ?string $navigationGroup = 'Settings';
    
    protected static ?string $navigationLabel = 'Tipping';
    
    protected static ?int $navigationSort = 2;
    
    protected static ?string $recordTitleAttribute = 'id';
    
    protected static bool $shouldRegisterNavigation = true;
    
    protected static ?string $slug = 'tipping-settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Tipping Settings')
                    ->schema([
                        Forms\Components\Toggle::make('tipping_enabled')
                            ->label('Enable Tipping')
                            ->default(true)
                            ->helperText('Turn off to completely disable tipping across the site'),
                            
                        Forms\Components\Repeater::make('tip_percentages')
                            ->label('Available Tip Percentages')
                            ->schema([
                                Forms\Components\TextInput::make('percentage')
                                    ->label('Percentage')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->suffix('%')
                            ])
                            ->itemLabel(fn (array $state): ?string => $state['percentage'] ? "{$state['percentage']}%" : null)
                            ->defaultItems(3)
                            ->reorderableWithButtons()
                            ->reorderable()
                            ->collapsible()
                            ->collapsed(false)
                            ->default(function() {
                                // Convert array of numbers to array of objects
                                $defaultPercentages = [10, 15, 20];
                                return collect($defaultPercentages)->map(function($percentage) {
                                    return ['percentage' => $percentage];
                                })->toArray();
                            })
                            ->helperText('These percentages will appear as tip options during checkout'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('tipping_enabled')
                    ->label('Tipping Enabled')
                    ->boolean(),
                    
                Tables\Columns\TextColumn::make('tip_percentages')
                    ->label('Available Percentages')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return '-';
                        
                        // If the percentages are stored as simple array
                        if (is_array($state) && isset($state[0]) && !is_array($state[0])) {
                            return implode('%, ', $state) . '%';
                        }
                        
                        // If the percentages are stored as array of objects
                        if (is_array($state) && isset($state[0]['percentage'])) {
                            $percentages = collect($state)->pluck('percentage')->toArray();
                            return implode('%, ', $percentages) . '%';
                        }
                        
                        return json_encode($state);
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // No bulk actions needed for a singleton
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTippingSettings::route('/'),
        ];
    }
} 