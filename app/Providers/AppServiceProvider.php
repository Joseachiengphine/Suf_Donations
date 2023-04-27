<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Filament\Navigation\NavigationGroup;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void

    {
//        Filament::registerTheme(
//            app(Vite::class)('resources/css/filament.css'),
//        );

//        Filament::serving(function () {
//            Filament::registerViteTheme('resources/css/filament.css');
//        });

        Filament::registerNavigationGroups([
            'FOUNDATION DONATIONS',
            'Vice Chancellor\'s Run',
            'Reports',
            'SYSTEM USERS',
            'SETTINGS',
        ]);

        Filament::serving(function () {
            Filament::registerViteTheme('resources/css/filament.css');
            Filament::registerNavigationGroups([
                NavigationGroup::make()
                    ->label('Foundation Donations')
                    ->icon('heroicon-o-arrow-up'),
                NavigationGroup::make()
                    ->label('Vice Chancellor\'s Run Management')
                    ->icon('heroicon-o-arrow-up'),
                NavigationGroup::make()
                    ->label('Reports')
                    ->icon('heroicon-o-arrow-up'),
                NavigationGroup::make()
                    ->label('System Users')
                    ->icon('heroicon-o-arrow-up'),
                NavigationGroup::make()
                    ->label('Settings')
                    ->icon('heroicon-o-arrow-up'),

            ]);
        });

    }
}
