<?php

namespace App\Filament\Resources\CellulantResponseRequestResource\Pages;

use App\Filament\Resources\CellulantResponseRequestResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Filters\Layout;

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
    protected function getTableFiltersFormColumns(): int
    {
        return 3;
    }

    protected function getTableFiltersFormWidth(): string
    {
        return '4xl';
    }

}

