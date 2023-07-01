<?php

namespace App\Filament\Widgets;

use App\Models\VcrunSupporter;
use Filament\Widgets\LineChartWidget;
use Illuminate\Support\Facades\DB;

class VCrunSupporterChart extends LineChartWidget
{
    protected static ?string $heading = 'VCrun Supporter Payments';

    public ?string $filter = '2023';



    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $activeFilter = $this->filter;

        $currentYear = date('Y');
        $startYear = DB::table('vcrun_supporters')->min(DB::raw('YEAR(created_at)'));
        $endYear = DB::table('vcrun_supporters')->max(DB::raw('YEAR(created_at)'));

        if ($activeFilter !== 'today' && $activeFilter !== 'week' && $activeFilter !== 'month' && $activeFilter !== 'year') {
            $selectedYear = intval($activeFilter);
            if ($selectedYear >= $startYear && $selectedYear <= $endYear) {
                $startYear = $selectedYear;
                $endYear = $selectedYear;
            }
        }

        $monthlyPayments = $this->getMonthlyPayments($startYear, $endYear);

        $chartData = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'VCrun Supporter Payments in Ksh',
                    'data' => [],
                    'backgroundColor' => '#3A5DAE',
                    'borderColor' => '#3A5DAE',
                    'borderWidth' => 2,
                ],
            ],
        ];

        foreach ($monthlyPayments as $month => $payments) {
            $monthName = date('F', strtotime($month));
            $chartData['labels'][] = $monthName;
            $chartData['datasets'][0]['data'][] = $payments;
        }

        return $chartData;
    }

    protected function getMonthlyPayments($startYear, $endYear): array
    {
        $monthlyPayments = VcrunSupporter::selectRaw('DATE_FORMAT(created_at, "%Y-%m") AS month, SUM(paid_amount) AS totalPayments')
            ->whereBetween(DB::raw('YEAR(created_at)'), [$startYear, $endYear])
            ->groupBy('month')
            ->pluck('totalPayments', 'month')
            ->toArray();

        for ($year = $startYear; $year <= $endYear; $year++) {
            for ($month = 1; $month <= 12; $month++) {
                $yearMonth = sprintf('%04d-%02d', $year, $month);
                if (!isset($monthlyPayments[$yearMonth])) {
                    $monthlyPayments[$yearMonth] = 0;
                }
            }
        }

        ksort($monthlyPayments);

        return $monthlyPayments;
    }

    public static function canView(): bool
    {
        return false;
    }

    protected function getFilters(): ?array
    {
        $startYear = DB::table('vcrun_supporters')->min(DB::raw('YEAR(created_at)'));
        $endYear = DB::table('vcrun_supporters')->max(DB::raw('YEAR(created_at)'));

        $filters = [];
        for ($year = $endYear; $year >= $startYear; $year--) {
            $filters[$year] = $year;
        }

        return $filters;
    }
}
