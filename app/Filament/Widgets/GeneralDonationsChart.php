<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;
use Filament\Widgets\LineChartWidget;

class GeneralDonationsChart extends LineChartWidget
{
    protected static ?string $heading = 'General Donation Payments';

    protected static ?string $maxHeight = '300px';

    public ?string $filter = '2023';



    protected function getData(): array
    {
        $activeFilter = $this->filter;

        $currentYear = date('Y');
        $startYear = DB::table('cellulant_responses')->min(DB::raw('YEAR(requestDate)'));
        $endYear = DB::table('cellulant_responses')->max(DB::raw('YEAR(requestDate)'));

        if ($activeFilter !== 'today' && $activeFilter !== 'week' && $activeFilter !== 'month' && $activeFilter !== 'year') {
            $selectedYear = intval($activeFilter);
            if ($selectedYear >= $startYear && $selectedYear <= $endYear) {
                $startYear = $selectedYear;
                $endYear = $selectedYear;
            }
        }

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
            $monthName = date('F', strtotime($month));
            $chartData['labels'][] = $monthName;
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

        for ($year = $startYear; $year <= $endYear; $year++) {
            for ($month = 1; $month <= 12; $month++) {
                $yearMonth = sprintf('%04d-%02d', $year, $month);
                if (!isset($monthlyDonations[$yearMonth])) {
                    $monthlyDonations[$yearMonth] = 0;
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

    protected function getFilters(): ?array
    {
        $startYear = DB::table('cellulant_responses')->min(DB::raw('YEAR(requestDate)'));
        $endYear = DB::table('cellulant_responses')->max(DB::raw('YEAR(requestDate)'));

        $filters = [];
        for ($year = $endYear; $year >= $startYear; $year--) { // Reverse the iteration
            $filters[$year] = $year;
        }

        return $filters;
    }
}
