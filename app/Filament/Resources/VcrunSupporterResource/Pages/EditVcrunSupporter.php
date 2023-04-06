<?php

namespace App\Filament\Resources\VcrunSupporterResource\Pages;

use App\Filament\Resources\VcrunSupporterResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVcrunSupporter extends EditRecord
{
    protected static string $resource = VcrunSupporterResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
