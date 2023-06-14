<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class DonationPaymentOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $cards = [];

        // Get the sum of amounts paid for 2022
        $amountPaid2022 = DB::table('vcrun_registrations')
            ->whereYear('created_at', 2022)
            ->sum('paid_amount');

//        $cards[] = Card::make('VCRun Payments 2022', 'Ksh' . number_format($amountPaid2022, 2))
//            ->description('Total amount paid in 2022')
//            ->descriptionIcon('heroicon-s-sparkles')
//            ->color('success');

        // Get the sum of amounts paid for 2023
        $amountPaid2023 = DB::table('vcrun_registrations')
            ->whereYear('created_at', 2023)
            ->sum('paid_amount');

//        $cards[] = Card::make('VCRun Payments 2023', 'Ksh' . number_format($amountPaid2023, 2))
//            ->description('Total amount paid in 2023')
//            ->descriptionIcon('heroicon-s-sparkles')
//            ->color('success');

        return $cards;
    }
}
