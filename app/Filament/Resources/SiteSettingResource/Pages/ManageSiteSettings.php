<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Resources\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSiteSettings extends ManageRecords
{
    protected static string $resource = SiteSettingResource::class;

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
                    $settings = SiteSetting::first() ?: new SiteSetting();
                    $data = $this->getTableRecords()->first()->toArray();
                    $settings->fill($data);
                    $settings->save();
                    
                    $this->notify('success', 'Site settings have been saved.');
                }),
        ];
    }
    
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // If no record exists, create default values
        if (empty($data)) {
            return [
                'restaurant_name' => 'The District Tapas + Bar - Hamilton',
                'restaurant_email' => 'thedistricthamilton@gmail.com',
                'restaurant_phone' => '(905) 522-2580',
                'restaurant_address' => '61 Barton St E, Hamilton, ON L8L 2V7',
                'gift_card_system_enabled' => true,
                'primary_language' => 'en',
                'enable_french' => false,
            ];
        }
        
        return $data;
    }
} 