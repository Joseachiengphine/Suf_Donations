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
            Card::make('Donation Requests 2020-present', DonationRequest::all()->count())
                ->description('Total Donation Requests')
                ->descriptionIcon('heroicon-s-receipt-refund')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Card::make('Requests Countries 2020-present', $count)
                ->description('Total Donation Request Countries')
                ->descriptionIcon('heroicon-s-flag')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Card::make('Campaigns Requests 2020-present', $campaign)
                ->description('Total Campaigns Requests')
                ->descriptionIcon('heroicon-s-fire')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

        ];
    }
}
