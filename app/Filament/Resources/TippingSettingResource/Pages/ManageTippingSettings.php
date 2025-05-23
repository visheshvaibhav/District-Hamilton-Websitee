<?php

namespace App\Filament\Resources\TippingSettingResource\Pages;

use App\Filament\Resources\TippingSettingResource;
use App\Models\TippingSetting;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTippingSettings extends ManageRecords
{
    protected static string $resource = TippingSettingResource::class;

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
                    $settings = TippingSetting::first() ?: new TippingSetting();
                    $data = $this->getTableRecords()->first()->toArray();
                    
                    // Process tip_percentages to store them correctly
                    if (isset($data['tip_percentages']) && is_array($data['tip_percentages'])) {
                        if (isset($data['tip_percentages'][0]['percentage'])) {
                            // Extract just the numbers from the percentage objects
                            $data['tip_percentages'] = collect($data['tip_percentages'])
                                ->pluck('percentage')
                                ->toArray();
                        }
                    }
                    
                    $settings->fill($data);
                    $settings->save();
                    
                    $this->notify('success', 'Tipping settings have been saved.');
                }),
        ];
    }
    
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // If no record exists, create default values
        if (empty($data)) {
            return [
                'tipping_enabled' => true,
                'tip_percentages' => [
                    ['percentage' => 10],
                    ['percentage' => 15],
                    ['percentage' => 20],
                ],
            ];
        }
        
        // Convert numeric array to array of objects for the repeater
        if (isset($data['tip_percentages']) && is_array($data['tip_percentages'])) {
            // If it's a simple numeric array, convert to the format the repeater expects
            if (isset($data['tip_percentages'][0]) && !is_array($data['tip_percentages'][0])) {
                $data['tip_percentages'] = collect($data['tip_percentages'])
                    ->map(fn($value) => ['percentage' => $value])
                    ->toArray();
            }
        }
        
        return $data;
    }
} 