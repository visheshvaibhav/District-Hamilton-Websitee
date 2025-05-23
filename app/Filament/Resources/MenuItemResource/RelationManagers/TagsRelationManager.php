<?php

namespace App\Filament\Resources\MenuItemResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TagsRelationManager extends RelationManager
{
    protected static string $relationship = 'tags';

    protected static ?string $recordTitleAttribute = 'tag_name';

    protected static ?string $title = 'Dietary & Allergy Tags';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('tag_name')
                            ->label('Tag Name (English)')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('tag_name_fr')
                            ->label('Tag Name (French)')
                            ->maxLength(255),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('tag_name')
            ->columns([
                Tables\Columns\TextColumn::make('tag_name')
                    ->label('Tag Name (English)')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('tag_name_fr')
                    ->label('Tag Name (French)')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        // Make tag uppercase if it's a short dietary tag
                        if (strlen($data['tag_name']) <= 5) {
                            $data['tag_name'] = strtoupper($data['tag_name']);
                        }
                        
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
} 