<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class MenuItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'menuItems';

    protected static ?string $recordTitleAttribute = 'name_en';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('name_en')
                            ->label('Name (English)')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => 
                                $set('slug', Str::slug($state))),
                            
                        Forms\Components\TextInput::make('name_fr')
                            ->label('Name (French)')
                            ->maxLength(255),
                    ]),
                
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                    
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->label('Price')
                            ->required()
                            ->numeric()
                            ->prefix('$'),
                            
                        Forms\Components\TextInput::make('preparation_time_minutes')
                            ->label('Preparation Time (minutes)')
                            ->numeric()
                            ->default(15),
                    ]),
                    
                Forms\Components\Textarea::make('description_en')
                    ->label('Description (English)')
                    ->rows(3),
                    
                Forms\Components\Textarea::make('description_fr')
                    ->label('Description (French)')
                    ->rows(3),
                    
                Forms\Components\FileUpload::make('image_path')
                    ->label('Image')
                    ->image()
                    ->directory('menu-items')
                    ->maxSize(2048)
                    ->columnSpanFull()
                    ->preserveFilenames()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->disk('public')
                    ->visibility('public')
                    ->imageEditor()
                    ->openable(),
                    
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Toggle::make('is_pickup_only')
                            ->label('Pickup Only')
                            ->default(false),
                            
                        Forms\Components\Toggle::make('is_available')
                            ->label('Available')
                            ->default(true),
                            
                        Forms\Components\Toggle::make('is_visible')
                            ->label('Visible')
                            ->default(true),
                            
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured Item')
                            ->default(false),
                            
                        Forms\Components\TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name_en')
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Image')
                    ->circular(),
                    
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Name (English)')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('USD')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('preparation_time_minutes')
                    ->label('Prep Time')
                    ->numeric()
                    ->suffix(' min')
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('is_available')
                    ->label('Available')
                    ->boolean(),
                    
                Tables\Columns\IconColumn::make('is_visible')
                    ->label('Visible')
                    ->boolean(),
                    
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_available')
                    ->options([
                        true => 'Available',
                        false => 'Unavailable',
                    ]),
                Tables\Filters\SelectFilter::make('is_featured')
                    ->options([
                        true => 'Featured',
                        false => 'Not Featured',
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
                        ->icon('heroicon-o-shopping-bag')
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