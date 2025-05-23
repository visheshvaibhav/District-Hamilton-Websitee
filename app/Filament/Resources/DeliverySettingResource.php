<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliverySettingResource\Pages;
use App\Models\DeliverySetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DeliverySettingResource extends Resource
{
    protected static ?string $model = DeliverySetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    
    protected static ?string $navigationGroup = 'Settings';
    
    protected static ?string $navigationLabel = 'Delivery & Pickup';
    
    protected static ?int $navigationSort = 1;
    
    protected static ?string $recordTitleAttribute = 'id';
    
    protected static bool $shouldRegisterNavigation = true;
    
    protected static ?string $slug = 'delivery-settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Delivery Settings')
                    ->schema([
                        Forms\Components\TextInput::make('delivery_radius_km')
                            ->label('Delivery Radius (km)')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(50)
                            ->default(5)
                            ->helperText('Maximum distance for delivery in kilometers'),
                            
                        Forms\Components\TextInput::make('delivery_fee')
                            ->label('Delivery Fee')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->default(3.99)
                            ->step(0.01)
                            ->helperText('Flat fee charged for delivery orders'),
                            
                        Forms\Components\Toggle::make('delivery_enabled')
                            ->label('Enable Delivery')
                            ->default(true)
                            ->helperText('Turn off to temporarily disable delivery orders'),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Pickup Settings')
                    ->schema([
                        Forms\Components\TimePicker::make('kitchen_open_time')
                            ->label('Kitchen Opens At')
                            ->required()
                            ->default('16:00:00') // 4 PM
                            ->seconds(false),
                            
                        Forms\Components\TimePicker::make('kitchen_close_time')
                            ->label('Kitchen Closes At')
                            ->required()
                            ->default('22:00:00') // 10 PM
                            ->seconds(false),
                            
                        Forms\Components\TextInput::make('buffer_time_minutes')
                            ->label('Order Buffer Time (minutes)')
                            ->required()
                            ->numeric()
                            ->default(15)
                            ->minValue(0)
                            ->maxValue(120)
                            ->step(5)
                            ->helperText('Additional time added to preparation estimates'),
                            
                        Forms\Components\Toggle::make('pickup_enabled')
                            ->label('Enable Pickup')
                            ->default(true)
                            ->helperText('Turn off to temporarily disable pickup orders'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('delivery_radius_km')
                    ->label('Delivery Radius')
                    ->suffix(' km'),
                    
                Tables\Columns\TextColumn::make('delivery_fee')
                    ->label('Delivery Fee')
                    ->money('USD'),
                    
                Tables\Columns\TextColumn::make('kitchen_open_time')
                    ->label('Opens')
                    ->time(),
                    
                Tables\Columns\TextColumn::make('kitchen_close_time')
                    ->label('Closes')
                    ->time(),
                    
                Tables\Columns\TextColumn::make('buffer_time_minutes')
                    ->label('Buffer')
                    ->suffix(' min'),
                    
                Tables\Columns\IconColumn::make('delivery_enabled')
                    ->label('Delivery Status')
                    ->boolean(),
                    
                Tables\Columns\IconColumn::make('pickup_enabled')
                    ->label('Pickup Status')
                    ->boolean(),
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
            'index' => Pages\ManageDeliverySettings::route('/'),
        ];
    }
} 