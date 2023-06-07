<?php

namespace App\Filament\Resources\CellulantResponseRequestResource\Pages;

use App\Filament\Resources\CellulantResponseRequestResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCellulantResponseRequest extends EditRecord
{
    protected static string $resource = CellulantResponseRequestResource::class;

    protected function getActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
        ];
    }
}
