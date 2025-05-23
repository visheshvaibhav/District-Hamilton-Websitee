<?php

namespace App\Filament\Resources\EventInquiryResource\Pages;

use App\Filament\Resources\EventInquiryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEventInquiry extends EditRecord
{
    protected static string $resource = EventInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
} 