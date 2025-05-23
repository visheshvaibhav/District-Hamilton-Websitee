<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventInquiryResource\Pages;
use App\Models\EventInquiry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EventInquiryResource extends Resource
{
    protected static ?string $model = EventInquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    
    protected static ?string $navigationGroup = 'Form Submissions';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('company')
                    ->maxLength(255),
                Forms\Components\TextInput::make('event_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('guest_count')
                    ->numeric()
                    ->required(),
                Forms\Components\DatePicker::make('event_date')
                    ->required(),
                Forms\Components\TextInput::make('event_time')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('details')
                    ->rows(4),
                Forms\Components\Toggle::make('is_read')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(['first_name', 'last_name']),
                Tables\Columns\TextColumn::make('event_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('event_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('guest_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_read')
                    ->boolean(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\Filter::make('unread')
                    ->query(fn (Builder $query): Builder => $query->where('is_read', false)),
                Tables\Filters\Filter::make('upcoming')
                    ->query(fn (Builder $query): Builder => $query->where('event_date', '>=', now())),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEventInquiries::route('/'),
            'create' => Pages\CreateEventInquiry::route('/create'),
            'edit' => Pages\EditEventInquiry::route('/{record}/edit'),
        ];
    }
} 