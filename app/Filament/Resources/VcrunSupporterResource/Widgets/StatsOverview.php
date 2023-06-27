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
        $totalAmount = $paidsupport + $difference;

        $paidsupportPercentage = ($paidsupport / $totalAmount) * 100;
        $differencePercentage = ($difference / $totalAmount) * 100;

        return [
            Card::make('Total Expected Amount 2022-present', 'Ksh ' . number_format($supportAmount, 2, '.', ','))
                ->description('100% Expected')
                ->descriptionIcon('heroicon-s-gift')
                ->chart([0, 20, 40, 60, 80, 100])
                ->color('success'),

            Card::make('Total Amount Paid 2022-present', 'Ksh ' . number_format($paidsupport, 2, '.', ','))
                ->description(number_format($paidsupportPercentage, 2) . '% Paid')
                ->descriptionIcon('heroicon-s-gift')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),


            Card::make('Amount Difference 2022-present', 'Ksh ' . number_format($difference, 2, '.', ','))
                ->description(number_format($differencePercentage, 2) . '% Difference')
                ->descriptionIcon('heroicon-s-credit-card')
                ->chart([10, 6, 2, -8, -16, -24, -32])
                ->color($difference > 0 ? 'danger' : 'success'),
        ];
    }

}
