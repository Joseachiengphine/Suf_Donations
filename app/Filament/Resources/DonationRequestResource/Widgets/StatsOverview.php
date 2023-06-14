<?php

namespace App\Filament\Resources\DonationRequestResource\Widgets;


use App\Models\DonationRequest;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $count = DonationRequest::distinct('country')->count();
        $campaign = DonationRequest::distinct('campaign')->count();
        return [
            Card::make('All Donation Requests for all years', DonationRequest::all()->count())
                ->description('Donation Requests')
                ->descriptionIcon('heroicon-s-receipt-refund')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Card::make('Total Donation Requests Countries', $count)
                ->description('Donation Request Countries')
                ->descriptionIcon('heroicon-s-flag')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Card::make('Total Campaigns with Requests', $campaign)
                ->description('Campaigns')
                ->descriptionIcon('heroicon-s-fire')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

        ];
    }
}
