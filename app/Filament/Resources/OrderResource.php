<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Collection;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    
    protected static ?string $navigationGroup = 'Order Management';
    
    protected static ?int $navigationSort = 1;
    
    protected static ?string $recordTitleAttribute = 'order_number';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Order Information')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->label('Order #')
                            ->disabled(),
                            
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'preparing' => 'Preparing',
                                'ready' => 'Ready',
                                'out_for_delivery' => 'Out for Delivery',
                                'completed' => 'Completed',
                                'canceled' => 'Canceled',
                            ])
                            ->required(),
                            
                        Forms\Components\Select::make('order_type')
                            ->options([
                                'pickup' => 'Pickup',
                                'delivery' => 'Delivery',
                            ])
                            ->disabled(),
                            
                        Forms\Components\DateTimePicker::make('pickup_time')
                            ->label('Pickup/Delivery Time'),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Customer Information')
                    ->schema([
                        Forms\Components\TextInput::make('customer_name')
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('customer_email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                            
                        Forms\Components\TextInput::make('customer_phone')
                            ->tel()
                            ->maxLength(255),
                            
                        Forms\Components\Textarea::make('delivery_address')
                            ->visible(fn (callable $get) => $get('order_type') === 'delivery')
                            ->maxLength(65535),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Payment Information')
                    ->schema([
                        Forms\Components\TextInput::make('subtotal')
                            ->numeric()
                            ->prefix('$')
                            ->disabled(),
                            
                        Forms\Components\TextInput::make('tax')
                            ->numeric()
                            ->prefix('$')
                            ->disabled(),
                            
                        Forms\Components\TextInput::make('tip_amount')
                            ->label('Tip')
                            ->numeric()
                            ->prefix('$')
                            ->disabled(),
                            
                        Forms\Components\TextInput::make('delivery_fee')
                            ->numeric()
                            ->prefix('$')
                            ->disabled()
                            ->visible(fn (callable $get) => $get('order_type') === 'delivery'),
                            
                        Forms\Components\TextInput::make('total')
                            ->numeric()
                            ->prefix('$')
                            ->disabled(),
                            
                        Forms\Components\Select::make('payment_status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'failed' => 'Failed',
                            ])
                            ->required(),
                            
                        Forms\Components\TextInput::make('payment_method')
                            ->disabled(),
                            
                        Forms\Components\TextInput::make('gift_card_code_used')
                            ->label('Gift Card Used')
                            ->disabled(),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Notes')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->maxLength(65535),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Order #')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\BadgeColumn::make('order_type')
                    ->label('Type')
                    ->colors([
                        'primary' => 'pickup',
                        'warning' => 'delivery',
                    ]),
                    
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'preparing',
                        'success' => 'ready',
                        'info' => 'out_for_delivery',
                        'danger' => 'canceled',
                        'secondary' => 'completed',
                    ]),
                    
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('USD')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('pickup_time')
                    ->label('Pickup/Delivery Time')
                    ->dateTime()
                    ->sortable(),
                    
                Tables\Columns\BadgeColumn::make('payment_status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'failed',
                    ]),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Order Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'preparing' => 'Preparing',
                        'ready' => 'Ready',
                        'out_for_delivery' => 'Out for Delivery',
                        'completed' => 'Completed',
                        'canceled' => 'Canceled',
                    ]),
                    
                Tables\Filters\SelectFilter::make('order_type')
                    ->options([
                        'pickup' => 'Pickup',
                        'delivery' => 'Delivery',
                    ]),
                    
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
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
                Tables\Actions\Action::make('print')
                    ->url(fn (Order $record): string => route('orders.print', $record))
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-printer'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('change_status')
                        ->label('Change Status')
                        ->icon('heroicon-o-arrow-path')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->label('New Status')
                                ->options([
                                    'pending' => 'Pending',
                                    'preparing' => 'Preparing',
                                    'ready' => 'Ready',
                                    'out_for_delivery' => 'Out for Delivery',
                                    'completed' => 'Completed',
                                    'canceled' => 'Canceled',
                                ])
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            foreach ($records as $record) {
                                $record->update([
                                    'status' => $data['status'],
                                ]);
                            }
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
