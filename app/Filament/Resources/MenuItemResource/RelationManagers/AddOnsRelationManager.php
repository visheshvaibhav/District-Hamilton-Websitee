<?php

namespace App\Filament\Resources\MenuItemResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class AddOnsRelationManager extends RelationManager
{
    protected static string $relationship = 'addOns';

    protected static ?string $recordTitleAttribute = 'name_en';

    protected static ?string $title = 'Add-Ons & Extras';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('name_en')
                            ->label('Add-on Name (English)')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('name_fr')
                            ->label('Add-on Name (French)')
                            ->maxLength(255),
                    ]),
                    
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->label('Extra Price')
                            ->numeric()
                            ->prefix('$')
                            ->default(0),
                            
                        Forms\Components\Toggle::make('is_available')
                            ->label('Available')
                            ->default(true),
                    ]),
                    
                Forms\Components\TextInput::make('sort_order')
                    ->label('Sort Order')
                    ->helperText('Lower numbers appear first')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name_en')
            ->columns([
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Add-on Name (English)')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('name_fr')
                    ->label('Add-on Name (French)')
                    ->searchable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('price')
                    ->label('Extra Price')
                    ->money('USD')
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('is_available')
                    ->label('Available')
                    ->boolean(),
                    
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_available')
                    ->options([
                        true => 'Available',
                        false => 'Unavailable',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('toggle_availability')
                        ->label('Toggle Availability')
                        ->icon('heroicon-o-check-circle')
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                $record->update([
                                    'is_available' => !$record->is_available,
                                ]);
                            }
                        }),
                ]),
            ])
            ->defaultSort('sort_order');
    }
} 