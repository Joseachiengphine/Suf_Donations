<?php

namespace App\Filament\Resources\VcrunRegistrationResource\Widgets;

use App\Models\VcrunRegistration;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $expectedAmount = VcrunRegistration::sum('registration_amount');
        $paidRegistrations = VcrunRegistration::sum('paid_amount');
        $difference = $expectedAmount - $paidRegistrations;

        return [
            //Card::make('All Vice chancellor\'s Run Registrations', VcrunRegistration::all()->count())
                //->description('Vice chancellor\'s Run Registrations')
                //->descriptionIcon('heroicon-s-receipt-refund')
                //->chart([7, 2, 10, 3, 15, 4, 17])
                //->color('success'),

            Card::make('Total Amount Paid', 'KES ' . number_format($paidRegistrations, 2, '.', ','))
                ->description('Amount Paid in Kes')
                ->descriptionIcon('heroicon-s-gift')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Card::make('Total Expected Amount', 'KES ' . number_format($expectedAmount, 2, '.', ','))
                ->description('Amount expected from registrations')
                ->descriptionIcon('heroicon-s-gift')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Card::make('Difference Between Amounts', 'KES ' . number_format($difference, 2, '.', ','))
                ->description('Amount Not Paid')
                ->descriptionIcon('heroicon-s-credit-card')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color($difference > 0 ? 'danger' : 'success'),
        ];
    }

}
