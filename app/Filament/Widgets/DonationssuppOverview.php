<?php

namespace App\Filament\Widgets;

use App\Models\VcrunSupporter;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class DonationssuppOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $totalDonations = VcrunSupporter::selectRaw('YEAR(created_at) as year, SUM(support_amount) as total')
            ->groupBy('year')
            ->pluck('total', 'year');

        $cards = [];

        foreach ($totalDonations as $year => $total) {
//            $cards[] = Card::make("VCRun supporter Payments in $year", "ksh" . number_format($total, 2))
//                ->description('Total VCRun supporter Payments')
//                ->descriptionIcon('heroicon-s-currency-dollar')
//                ->descriptionIcon('heroicon-s-sparkles')
//                ->color('success');
        }

        return $cards;
    }
}
