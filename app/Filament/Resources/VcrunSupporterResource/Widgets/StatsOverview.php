<?php

namespace App\Filament\Resources\VcrunSupporterResource\Widgets;

use App\Models\VcrunSupporter;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $supportAmount = VcrunSupporter::sum('support_amount');
        $paidsupport = VcrunSupporter::sum('paid_amount');
        $difference = $supportAmount - $paidsupport;
        return [
            //Card::make('All Vice Chancellor\'s Run Supporters', VcrunSupporter::all()->count())
                //->description('Vice Chancellor\'s Run Supporters')
                //->descriptionIcon('heroicon-s-receipt-refund')
                //->chart([7, 2, 10, 3, 15, 4, 17])
                //->color('success'),
            Card::make('Total Amount Paid', 'KES ' . number_format($paidsupport, 2, '.', ','))
                ->description('Amount Paid in Kes')
                ->descriptionIcon('heroicon-s-gift')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Card::make('Total Expected Support Amount', 'KES ' . number_format($supportAmount, 2, '.', ','))
                ->description('Support Amount')
                ->descriptionIcon('heroicon-s-gift')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Card::make('Difference Between Amounts', 'KES ' . number_format($difference, 2, '.', ','))
                ->description('Amount Not Paid')
                ->descriptionIcon('heroicon-s-credit-card')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color($difference > 0 ? 'danger' : 'success'),
        ];
    }
}
