<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;


class MyProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'SETTINGS';


    protected static string $view = 'filament.pages.my-profile';


}
