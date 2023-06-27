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
             TabLayoutTab::make('General Donations Payments')
                 ->icon('heroicon-o-gift')
                 ->schema([
                     TabContainer::make(GeneralDonationsChart::class),
                 ]),
             TabLayoutTab::make('VCRun Registration Payments')
                 ->icon('heroicon-o-information-circle')
                 ->schema([
                     TabContainer::make(VCrunRegistrationsChart::class),
                 ]),
            TabLayoutTab::make('VCRun Supporter Payments')
                ->icon('heroicon-o-information-circle')
                ->schema([
                    TabContainer::make(VCrunSupporterChart::class),
                ]),

        ];
    }

}
