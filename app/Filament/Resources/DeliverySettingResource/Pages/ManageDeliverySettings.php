<?php

namespace App\Filament\Resources\DeliverySettingResource\Pages;

use App\Filament\Resources\DeliverySettingResource;
use App\Models\DeliverySetting;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDeliverySettings extends ManageRecords
{
    protected static string $resource = DeliverySettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('save')
                ->label('Save Settings')
                ->color('success')
                ->form([
                    // No additional form needed, all fields are on the main form
                ])
                ->action(function () {
                    $settings = DeliverySetting::first() ?: new DeliverySetting();
                    $data = $this->getTableRecords()->first()->toArray();
                    $settings->fill($data);
                    $settings->save();
                    
                    $this->notify('success', 'Delivery settings have been saved.');
                }),
        ];
    }
    
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // If no record exists, create default values
        if (empty($data)) {
            return [
                'delivery_radius_km' => 5,
                'delivery_fee' => 3.99,
                'kitchen_open_time' => '16:00:00',
                'kitchen_close_time' => '22:00:00',
                'buffer_time_minutes' => 15,
                'delivery_enabled' => true,
                'pickup_enabled' => true,
            ];
        }
        
        return $data;
    }
} 