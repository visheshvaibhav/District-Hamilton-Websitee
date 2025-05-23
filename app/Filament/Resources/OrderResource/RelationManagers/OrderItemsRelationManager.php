<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\MenuItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItems';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('menu_item_id')
                    ->label('Menu Item')
                    ->options(MenuItem::query()->pluck('name', 'id'))
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $menuItem = MenuItem::find($state);
                            $set('name', $menuItem->name);
                            $set('price', $menuItem->price);
                            $set('subtotal', $menuItem->price);
                        }
                    }),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('$')
                    ->required(),
                Forms\Components\TextInput::make('quantity')
                    ->numeric()
                    ->default(1)
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        $price = $get('price');
                        $quantity = $state;
                        $set('subtotal', $price * $quantity);
                    }),
                Forms\Components\TextInput::make('subtotal')
                    ->numeric()
                    ->prefix('$')
                    ->required()
                    ->disabled(),
                Forms\Components\Textarea::make('special_instructions')
                    ->maxLength(65535),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtotal')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('special_instructions')
                    ->limit(30),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function () {
                        // Recalculate order totals
                        $this->getOwnerRecord()->calculateTotals();
                        $this->getOwnerRecord()->save();
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function () {
                        // Recalculate order totals
                        $this->getOwnerRecord()->calculateTotals();
                        $this->getOwnerRecord()->save();
                    }),
                Tables\Actions\DeleteAction::make()
                    ->after(function () {
                        // Recalculate order totals
                        $this->getOwnerRecord()->calculateTotals();
                        $this->getOwnerRecord()->save();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function () {
                            // Recalculate order totals
                            $this->getOwnerRecord()->calculateTotals();
                            $this->getOwnerRecord()->save();
                        }),
                ]),
            ]);
    }
} 