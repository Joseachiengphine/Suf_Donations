<?php

namespace App\Filament\Widgets;

use SolutionForest\TabLayoutPlugin\Components\Tabs\Tab as TabLayoutTab;
use SolutionForest\TabLayoutPlugin\Components\Tabs\TabContainer;
use SolutionForest\TabLayoutPlugin\Widgets\TabsWidget as BaseWidget;

class DummyTabs extends BaseWidget
{
    protected function schema(): array
    {
        return [

             //SAMPLE CODE, CAN DELETE
             TabLayoutTab::make('General Donations stats')
                 ->icon('heroicon-o-gift')
                 ->schema([
                     TabContainer::make(GeneralDonationsChart::class),
                 ]),
             TabLayoutTab::make('VCRun Registration stats')
                 ->icon('heroicon-o-information-circle')
                 ->schema([
                     TabContainer::make(VCrunRegistrationsChart::class),
                 ]),
            TabLayoutTab::make('VCRun Supporter stats')
                ->icon('heroicon-o-information-circle')
                ->schema([
                    TabContainer::make(VCrunSupporterChart::class),
                ]),

        ];
    }

}
