<?php

namespace App\Filament\Resources\VcrunRegistrationResource\Pages;

use App\Filament\Resources\VcrunRegistrationResource;
use App\Filament\Resources\VcrunRegistrationResource\Widgets\StatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVcrunRegistrations extends ListRecords
{
    protected static string $resource = VcrunRegistrationResource::class;
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
}
