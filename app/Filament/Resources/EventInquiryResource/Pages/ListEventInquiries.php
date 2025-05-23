<?php

namespace App\Filament\Resources\EventInquiryResource\Pages;

use App\Filament\Resources\EventInquiryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventInquiries extends ListRecords
{
    protected static string $resource = EventInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
} 