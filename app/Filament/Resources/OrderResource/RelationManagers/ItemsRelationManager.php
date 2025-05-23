<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\MenuItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $title = 'Order Items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('menu_item_id')
                    ->label('Menu Item')
                    ->options(MenuItem::where('is_available', true)->pluck('name_en', 'id'))
                    ->searchable()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $menuItem = MenuItem::find($state);
                            $set('price', $menuItem->price);
                            $set('name', $menuItem->name_en);
                        }
                    }),
                    
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('price')
                    ->label('Unit Price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                    
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->minValue(1),
                    
                Forms\Components\Textarea::make('special_instructions')
                    ->label('Special Instructions')
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('subtotal')
                    ->label('Subtotal')
                    ->numeric()
                    ->prefix('$')
                    ->disabled(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Item')
                    ->searchable()
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Qty')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('price')
                    ->label('Unit Price')
                    ->money('USD')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('USD')
                    ->sortable()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->money('USD'),
                    ]),
                    
                Tables\Columns\TextColumn::make('special_instructions')
                    ->label('Special Instructions')
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('options')
                    ->label('Add-ons')
                    ->formatStateUsing(function ($state) {
                        if (empty($state) || !isset($state['add_ons'])) return '-';
                        
                        $addOns = collect($state['add_ons'])->pluck('name')->implode(', ');
                        return $addOns ?: '-';
                    }),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        // Calculate subtotal based on quantity and price
                        $data['subtotal'] = $data['price'] * $data['quantity'];
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        // Calculate subtotal based on quantity and price
                        $data['subtotal'] = $data['price'] * $data['quantity'];
                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
} 