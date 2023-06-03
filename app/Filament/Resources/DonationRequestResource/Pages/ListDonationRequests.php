<?php

namespace App\Filament\Resources\DonationRequestResource\Pages;

use App\Filament\Resources\DonationRequestResource;
use App\Filament\Resources\DonationRequestResource\Widgets\StatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDonationRequests extends ListRecords
{
    protected static string $resource = DonationRequestResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }

    protected function getActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }

//    protected function getTableFiltersFormColumns(): int
//    {
//        return 3;
//    }
//
//    protected function getTableFiltersFormWidth(): string
//    {
//        return '4xl';
//    }
}
