<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Menu Management';

    protected static ?string $navigationLabel = 'Categories';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Grid::make()
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
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(255),
                        
                        Forms\Components\Textarea::make('description_en')
                            ->label('Description (English)')
                            ->rows(3)
                            ->columnSpanFull(),
                            
                        Forms\Components\Textarea::make('description_fr')
                            ->label('Description (French)')
                            ->rows(3)
                            ->columnSpanFull(),
                        
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Toggle::make('is_deliverable')
                                    ->label('Available for Delivery')
                                    ->default(true)
                                    ->helperText('If disabled, items in this category can only be ordered for pickup'),
                                
                                Forms\Components\Toggle::make('is_visible')
                                    ->label('Visible on Website')
                                    ->default(true)
                                    ->helperText('Hidden categories will not appear on the website'),
                                
                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Sort Order')
                                    ->helperText('Lower numbers appear first')
                                    ->numeric()
                                    ->default(0),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Name (English)')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('name_fr')
                    ->label('Name (French)')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                    
                Tables\Columns\TextColumn::make('menuItems.count')
                    ->label('Menu Items')
                    ->counts('menuItems')
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('is_deliverable')
                    ->label('Deliverable')
                    ->boolean(),
                    
                Tables\Columns\IconColumn::make('is_visible')
                    ->label('Visible')
                    ->boolean(),
                    
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_visible')
                    ->label('Visibility')
                    ->options([
                        true => 'Visible',
                        false => 'Hidden',
                    ]),
                    
                Tables\Filters\SelectFilter::make('is_deliverable')
                    ->label('Delivery Status')
                    ->options([
                        true => 'Deliverable',
                        false => 'Pickup Only',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('toggle_visibility')
                        ->label('Toggle Visibility')
                        ->icon('heroicon-o-eye')
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                $record->update([
                                    'is_visible' => !$record->is_visible,
                                ]);
                            }
                        }),
                ]),
            ])
            ->defaultSort('sort_order');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MenuItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
