<?php

namespace App\Filament\Resources\VcrunRegistrationResource\Pages;

use App\Filament\Resources\VcrunRegistrationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVcrunRegistration extends EditRecord
{
    protected static string $resource = VcrunRegistrationResource::class;

    protected function getActions(): array
    {
        return [
//            Actions\DeleteAction::make(),
        ];
    }
}
