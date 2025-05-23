<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GiftCardResource\Pages;
use App\Filament\Resources\GiftCardResource\RelationManagers;
use App\Models\GiftCard;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GiftCardResource extends Resource
{
    protected static ?string $model = GiftCard::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    
    protected static ?string $navigationGroup = 'Gift Cards';
    
    protected static ?int $navigationSort = 1;
    
    protected static ?string $recordTitleAttribute = 'code';

    public static function canAccess(): bool
    {
        return SiteSetting::getSettings()->gift_card_system_enabled;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Gift Card Details')
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->default(fn () => GiftCard::generateCode())
                            ->disabled(fn ($record) => $record !== null),
                            
                        Forms\Components\TextInput::make('amount')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->minValue(5)
                            ->maxValue(500),
                            
                        Forms\Components\Select::make('delivery_type')
                            ->options([
                                'ecard' => 'E-Card (Email Delivery)',
                                'physical' => 'Physical Card (Staff Delivers)',
                            ])
                            ->required(),
                            
                        Forms\Components\Toggle::make('is_redeemed')
                            ->label('Redeemed')
                            ->helperText('Manually mark as redeemed for in-store use'),
                            
                        Forms\Components\DateTimePicker::make('redeemed_at')
                            ->label('Redeemed At')
                            ->visible(fn (callable $get) => $get('is_redeemed')),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Recipient Information')
                    ->schema([
                        Forms\Components\TextInput::make('recipient_name')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('recipient_email')
                            ->email()
                            ->maxLength(255)
                            ->requiredIf('delivery_type', 'ecard'),
                            
                        Forms\Components\TextInput::make('sender_name')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('sender_email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\Textarea::make('message')
                            ->placeholder('Gift card message (optional)')
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Payment Information')
                    ->schema([
                        Forms\Components\TextInput::make('stripe_payment_id')
                            ->label('Stripe Payment ID')
                            ->disabled()
                            ->helperText('This field is automatically populated after payment'),
                            
                        Forms\Components\TextInput::make('order_id')
                            ->label('Redeemed with Order ID')
                            ->disabled(),
                    ])->visible(fn ($record) => $record !== null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->copyable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('USD')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('recipient_name')
                    ->label('Recipient')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('sender_name')
                    ->label('Purchased By')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\BadgeColumn::make('delivery_type')
                    ->label('Type')
                    ->colors([
                        'primary' => 'ecard',
                        'success' => 'physical',
                    ]),
                    
                Tables\Columns\BadgeColumn::make('is_redeemed')
                    ->label('Status')
                    ->colors([
                        'success' => false,
                        'danger' => true,
                    ])
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Redeemed' : 'Active'),
                    
                Tables\Columns\TextColumn::make('redeemed_at')
                    ->label('Redeemed At')
                    ->dateTime()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Purchase Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('delivery_type')
                    ->options([
                        'ecard' => 'E-Card',
                        'physical' => 'Physical Card',
                    ]),
                    
                Tables\Filters\SelectFilter::make('is_redeemed')
                    ->label('Redemption Status')
                    ->options([
                        '0' => 'Active',
                        '1' => 'Redeemed',
                    ]),
                    
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('redeem')
                    ->label('Mark as Redeemed')
                    ->icon('heroicon-o-shopping-cart')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (GiftCard $record) => !$record->is_redeemed)
                    ->action(function (GiftCard $record): void {
                        $record->redeem();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGiftCards::route('/'),
            'create' => Pages\CreateGiftCard::route('/create'),
            'edit' => Pages\EditGiftCard::route('/{record}/edit'),
        ];
    }
}
