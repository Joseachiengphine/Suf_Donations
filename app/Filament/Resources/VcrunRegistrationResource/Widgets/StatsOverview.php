<?php

namespace App\Filament\Resources\VcrunRegistrationResource\Widgets;

use App\Models\VcrunRegistration;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $expectedAmount = VcrunRegistration::sum('registration_amount');
        $paidRegistrations = VcrunRegistration::sum('paid_amount');
        $difference = $expectedAmount - $paidRegistrations;

        $totalAmount = $paidRegistrations + $difference;

        $paidRegistrationsPercentage = ($paidRegistrations / $totalAmount) * 100;
        $differencePercentage = ($difference / $totalAmount) * 100;

        // Calculate totals for each year
        $yearlyTotals = VcrunRegistration::selectRaw('YEAR(created_at) AS year, SUM(registration_amount) AS total')
            ->groupBy('year')
            ->pluck('total', 'year')
            ->toArray();

        $cards = [
            Card::make('Total Expected Amount for all years', 'Ksh ' . number_format($expectedAmount, 2, '.', ','))
                ->description('100% Expected')
                ->descriptionIcon('heroicon-s-sparkles')
                ->chart([0, 20, 40, 60, 80, 100])
                ->color('success'),

            Card::make('Total Amount Paid for all years', 'Ksh ' . number_format($paidRegistrations, 2, '.', ','))
                ->description(number_format($paidRegistrationsPercentage, 2) . '% Paid')
                ->descriptionIcon('heroicon-s-sparkles')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Card::make('Difference Between Amounts for all years', 'Ksh ' . number_format($difference, 2, '.', ','))
                ->description(number_format($differencePercentage, 2) . '% Difference')
                ->descriptionIcon('heroicon-s-credit-card')
                ->chart([10, 6, 2, -4, -8, -12, -16])
                ->color($difference > 0 ? 'danger' : 'success'),
        ];
//
//        // Add cards for each year
//        foreach ($yearlyTotals as $year => $total) {
//            $cards[] = Card::make('Total Amount for ' . $year, 'KES ' . number_format($total, 2, '.', ','))
//                ->description('Total Amounts Paid')
//                ->descriptionIcon('heroicon-s-sparkles')
//                ->chart([[0, 20, 40, 60, 80, 100]])
//                ->color('primary');
//        }

        return $cards;
    }
}

