<?php

namespace App\Filament\Widgets;

use Filament\Widgets\DoughnutChartWidget;
use Illuminate\Support\Facades\DB;

//class VCRunParticipationsChart extends DoughnutChartWidget
//{
//    protected static ?string $heading = 'Chart';
//
//    protected function getData(): array
//    {
//        $physicalData = DB::table('vcrun_registrations')
//            ->selectRaw('YEAR(created_at) AS year, COUNT(*) AS count')
//            ->where('participation_type', 'PHYSICAL')
//            ->groupBy('year')
//            ->pluck('count', 'year')
//            ->toArray();
//
//        $virtualData = DB::table('vcrun_registrations')
//            ->selectRaw('YEAR(created_at) AS year, COUNT(*) AS count')
//            ->where('participation_type', 'VIRTUAL')
//            ->groupBy('year')
//            ->pluck('count', 'year')
//            ->toArray();
//
//        $years = array_unique(array_merge(array_keys($physicalData), array_keys($virtualData)));
//
//        $chartData = [
//            'labels' => $years,
//            'datasets' => [
//                [
//                    'label' => 'Physical',
//                    'data' => array_values($physicalData),
//                    'backgroundColor' => '#3A5DAE',
//                ],
//                [
//                    'label' => 'Virtual',
//                    'data' => array_values($virtualData),
//                    'backgroundColor' => '#FFC107',
//                ],
//            ],
//        ];
//
//        return $chartData;
//    }
//
//    protected function getOptions(): array
//    {
//        return [
//            'maintainAspectRatio' => false,
//            'legend' => [
//                'display' => true,
//                'position' => 'bottom',
//                'labels' => [
//                    'fontColor' => '#333',
//                ],
//            ],
//            'tooltips' => [
//                'enabled' => true,
//                'backgroundColor' => '#FFF',
//                'titleFontColor' => '#000',
//                'bodyFontColor' => '#000',
//            ],
//            'cutout' => '50%', // Adjust as needed
//            'radius' => '80%', // Adjust as needed
//            'rotation' => 0, // Adjust as needed
//            'circumference' => 360, // Adjust as needed
//            'animation' => [
//                'animateRotate' => true,
//                'animateScale' => false,
//            ],
//        ];
//    }
//
//
//    public static function canView(): bool
//    {
//        return false;
//    }
//}


