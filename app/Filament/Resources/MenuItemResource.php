<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Filament\Resources\MenuItemResource\RelationManagers;
use App\Models\Category;
use App\Models\MenuItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-cake';
    
    protected static ?string $navigationGroup = 'Menu Management';
    
    protected static ?string $navigationLabel = 'Menu Items';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('MenuItem')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Basic Information')
                            ->schema([
                                Forms\Components\Select::make('category_id')
                                    ->label('Category')
                                    ->options(Category::pluck('name_en', 'id'))
                                    ->required()
                                    ->searchable(),

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
                            ]),
                            
                        Forms\Components\Tabs\Tab::make('Image & Display')
                            ->schema([
                                Forms\Components\FileUpload::make('image_path')
                                    ->label('Food Image')
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
                                            ->helperText('If enabled, this item cannot be delivered')
                                            ->default(false),
                                            
                                        Forms\Components\Toggle::make('is_available')
                                            ->label('In Stock')
                                            ->helperText('If disabled, item will show as unavailable')
                                            ->default(true),
                                            
                                        Forms\Components\Toggle::make('is_visible')
                                            ->label('Visible on Website')
                                            ->helperText('If disabled, item will not appear on the website')
                                            ->default(true),
                                            
                                        Forms\Components\Toggle::make('is_featured')
                                            ->label('Featured Item')
                                            ->helperText('Featured items appear on the homepage')
                                            ->default(false),
                                    ]),
                                    
                                Forms\Components\TextInput::make('sort_order')
                                    ->label('Sort Order (within category)')
                                    ->helperText('Lower numbers appear first')
                                    ->numeric()
                                    ->default(0),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Image')
                    ->circular(),
                    
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('category.name_en')
                    ->label('Category')
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
                    
                Tables\Columns\IconColumn::make('is_pickup_only')
                    ->label('Pickup Only')
                    ->boolean(),
                    
                Tables\Columns\IconColumn::make('is_available')
                    ->label('Available')
                    ->boolean(),
                    
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Category')
                    ->options(Category::pluck('name_en', 'id'))
                    ->searchable(),
                    
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
                    
                Tables\Filters\SelectFilter::make('is_pickup_only')
                    ->options([
                        true => 'Pickup Only',
                        false => 'Available for Delivery',
                    ]),
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
                    Tables\Actions\BulkAction::make('toggle_featured')
                        ->label('Toggle Featured Status')
                        ->icon('heroicon-o-star')
                        ->action(function (Collection $records): void {
                            foreach ($records as $record) {
                                $record->update([
                                    'is_featured' => !$record->is_featured,
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
            RelationManagers\TagsRelationManager::class,
            RelationManagers\AddOnsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit' => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }
}
