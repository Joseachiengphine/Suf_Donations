<?php

namespace App\Filament\Resources\CellulantResponseRequestResource\Widgets;


use Carbon\Carbon;
use App\Models\CellulantResponseRequest;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;


class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $paidRequests = CellulantResponseRequest::query()->where('requestStatusDescription', 'Request fully paid')->count();
        $amountPaid = CellulantResponseRequest::sum('amountPaid');
        $currency = CellulantResponseRequest::distinct('currencyCode')->count();

        return [
            Card::make('Fully Made Payments for all years', $paidRequests)
                ->description('Donation requests fully paid')
                ->descriptionIcon('heroicon-s-receipt-refund')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),


            Card::make('Total Amount Paid for all years', 'Ksh ' . number_format($amountPaid, 2, '.', ','))
                ->description('Amount Paid in Ksh')
                ->descriptionIcon('heroicon-s-gift')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Card::make('Currencies Used', $currency)
                ->description('Currencies')
                ->descriptionIcon('heroicon-s-credit-card')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            ];
    }
}
