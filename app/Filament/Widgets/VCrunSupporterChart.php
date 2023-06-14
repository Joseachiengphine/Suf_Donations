<?php

namespace App\Filament\Widgets;

use App\Models\VcrunSupporter;
use Filament\Widgets\LineChartWidget;

class VCrunSupporterChart extends LineChartWidget
{
    protected static ?string $heading = 'VCrun Supporter Payments';

    protected function getData(): array
    {
        $data = VcrunSupporter::selectRaw('MONTH(created_at) as month, SUM(paid_amount) as totalPayments')
            ->groupBy('month')
            ->pluck('totalPayments', 'month')
            ->toArray();

        $chartData = [
            'labels' => [],
            'datasets' => [
                [
                    'label' => 'VCrun Supporter Payments in Ksh',
                    'data' => [],
                    'backgroundColor' => '#3A5DAE',
                    'borderColor' => '#3A5DAE', // Add a border color to make the line visible
                    'borderWidth' => 2, // Increase the border width to make the line visible
                ],
            ],
        ];

        // Fill in missing months with zero payments
        for ($month = 1; $month <= 12; $month++) {
            if (!isset($data[$month])) {
                $data[$month] = 0;
            }
        }

        // Sort the data by month
        ksort($data);

        foreach ($data as $month => $payments) {
            $chartData['labels'][] = date('F', mktime(0, 0, 0, $month, 1)); // Format month as full month name
            $chartData['datasets'][0]['data'][] = $payments;
        }

        return $chartData;
    }
    public static function canView(): bool
    {
        return false;
    }
}
