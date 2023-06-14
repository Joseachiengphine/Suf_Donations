<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use Illuminate\Support\Facades\DB;

class VCrunRegistrationsChart extends LineChartWidget
{
    protected static ?string $heading = 'VCrun Registration Payments';

    protected function getData(): array
    {
        $data = DB::table('vcrun_registrations')
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") AS month, SUM(paid_amount) AS totalPayments')
            ->groupBy('month')
            ->pluck('totalPayments', 'month')
            ->toArray();

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
}
