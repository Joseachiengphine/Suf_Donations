<?php

namespace App\Filament\Resources\CellulantResponseRequestResource\Pages;

use App\Filament\Resources\CellulantResponseRequestResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCellulantResponseRequests extends ListRecords
{
    protected static string $resource = CellulantResponseRequestResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            CellulantResponseRequestResource\Widgets\StatsOverview::class,
        ];
    }

    protected function getActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
