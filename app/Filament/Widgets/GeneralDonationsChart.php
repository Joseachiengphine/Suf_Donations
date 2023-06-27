<?php

namespace App\Filament\Widgets;


use Illuminate\Support\Facades\DB;
use Filament\Widgets\LineChartWidget;

class GeneralDonationsChart extends LineChartWidget
{
    protected static ?string $heading = 'General Donation Payments';

    protected function getData(): array
    {
        $currentYear = date('Y');
        $startYear = 2020;
        $endYear = $currentYear;

        $monthlyDonations = $this->getMonthlyDonations($startYear, $endYear);

        $chartData = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'Donation Payments in Ksh',
                    'data' => [],
                    'backgroundColor' => '#3A5DAE',
                    'borderColor' => '#3A5DAE',
                    'borderWidth' => 2,
                ],
            ],
        ];

        foreach ($monthlyDonations as $month => $donations) {
            $chartData['labels'][] = $month;
            $chartData['datasets'][0]['data'][] = $donations;
        }

        return $chartData;
    }

    protected function getMonthlyDonations($startYear, $endYear): array
    {
        $monthlyDonations = DB::table('cellulant_responses')
            ->selectRaw('DATE_FORMAT(requestDate, "%Y-%m") AS month, SUM(amountPaid) AS totalDonations')
            ->whereBetween(DB::raw('YEAR(requestDate)'), [$startYear, $endYear])
            ->groupBy('month')
            ->pluck('totalDonations', 'month')
            ->toArray();

        $currentYearMonth = date('Y-m');
        for ($year = $startYear; $year <= $endYear; $year++) {
            for ($month = 1; $month <= 12; $month++) {
                $yearMonth = sprintf('%04d-%02d', $year, $month);
                if (!isset($monthlyDonations[$yearMonth])) {
                    $monthlyDonations[$yearMonth] = 0;
                }
                if ($yearMonth > $currentYearMonth) {
                    break;
                }
            }
        }

        ksort($monthlyDonations);

        return $monthlyDonations;
    }
    
    public static function canView(): bool
    {
        return false;
    }
}




