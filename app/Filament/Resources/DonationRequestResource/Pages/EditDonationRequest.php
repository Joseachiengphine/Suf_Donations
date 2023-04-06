<?php

namespace App\Filament\Resources\DonationRequestResource\Pages;

use App\Filament\Resources\DonationRequestResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDonationRequest extends EditRecord
{
    protected static string $resource = DonationRequestResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
