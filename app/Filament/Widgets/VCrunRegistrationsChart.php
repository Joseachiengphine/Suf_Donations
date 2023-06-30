<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use Illuminate\Support\Facades\DB;

class VCrunRegistrationsChart extends LineChartWidget
{
    protected static ?string $heading = 'VCrun Registration Payments';

    public ?string $filter = '2023';

    protected static ?string $maxHeight = '300px';



    protected function getData(): array
    {
        $activeFilter = $this->filter;

        $currentYear = date('Y');
        $startYear = DB::table('vcrun_registrations')->min(DB::raw('YEAR(created_at)'));
        $endYear = DB::table('vcrun_registrations')->max(DB::raw('YEAR(created_at)'));

        if ($activeFilter !== 'today' && $activeFilter !== 'week' && $activeFilter !== 'month' && $activeFilter !== 'year') {
            $selectedYear = intval($activeFilter);
            if ($selectedYear >= $startYear && $selectedYear <= $endYear) {
                $startYear = $selectedYear;
                $endYear = $selectedYear;
            }
        }

        $data = $this->getMonthlyPayments($startYear, $endYear);

        $chartData = [
            'labels' => array_keys($data),
            'datasets' => [
                [
                    'label' => 'VCrun Registration Payments in Ksh',
                    'data' => array_values($data),
                    'backgroundColor' => '#3A5DAE',
                    'borderColor' => '#3A5DAE',
                    'borderWidth' => 2,
                ],
            ],
        ];

        return $chartData;
    }

    protected function getMonthlyPayments($startYear, $endYear): array
    {
        $payments = DB::table('vcrun_registrations')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") AS month, SUM(paid_amount) AS totalPayments')
            ->whereBetween(DB::raw('YEAR(created_at)'), [$startYear, $endYear])
            ->groupBy('month')
            ->pluck('totalPayments', 'month')
            ->toArray();

        for ($year = $startYear; $year <= $endYear; $year++) {
            for ($month = 1; $month <= 12; $month++) {
                $yearMonth = sprintf('%04d-%02d', $year, $month);
                if (!isset($payments[$yearMonth])) {
                    $payments[$yearMonth] = 0;
                }
            }
        }

        ksort($payments);

        return $payments;
    }

    public static function canView(): bool
    {
        return false;
    }

    protected function getFilters(): ?array
    {
        $startYear = DB::table('vcrun_registrations')->min(DB::raw('YEAR(created_at)'));
        $endYear = DB::table('vcrun_registrations')->max(DB::raw('YEAR(created_at)'));

        $filters = [];
        for ($year = $endYear; $year >= $startYear; $year--) { // Reverse the iteration
            $filters[$year] = $year;
        }

        return $filters;
    }
}
