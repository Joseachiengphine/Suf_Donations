<?php

namespace App\Filament\Resources\VcrunSupporterResource\Pages;

use App\Filament\Resources\VcrunSupporterResource;
use App\Filament\Resources\VcrunSupporterResource\Widgets\StatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVcrunSupporters extends ListRecords
{
    protected static string $resource = VcrunSupporterResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }    protected function getActions(): array
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
