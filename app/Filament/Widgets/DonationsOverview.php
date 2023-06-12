<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class DonationsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $currentYear = date('Y');
        $startYear = 2020;
        $endYear = $currentYear;

        $yearlyDonations = $this->getYearlyDonations($startYear, $endYear);

        $cards = [];
        foreach ($yearlyDonations as $year => $donations) {
            $formattedAmount = 'Ksh ' . number_format($donations);

            $cardTitle = 'All Donations in ' . $year;
            $cardDescription = $year . ' total donations';

            $cards[] = Card::make($cardTitle, $formattedAmount)
                ->description($cardDescription)
                ->descriptionIcon('heroicon-s-sparkles')
                ->color('success');
        }

        return $cards;
    }

    protected function getYearlyDonations($startYear, $endYear): array
    {
        $yearlyDonations = DB::table('cellulant_responses')
            ->selectRaw('YEAR(requestDate) AS year, SUM(amountPaid) AS totalDonations')
            ->whereBetween(DB::raw('YEAR(requestDate)'), [$startYear, $endYear])
            ->groupBy('year')
            ->pluck('totalDonations', 'year')
            ->toArray();

        // Fill in missing years with zero donations
        $currentYear = date('Y');
        for ($year = $startYear; $year <= $currentYear; $year++) {
            if (!isset($yearlyDonations[$year])) {
                $yearlyDonations[$year] = 0;
            }
        }

        return $yearlyDonations;
    }
}

