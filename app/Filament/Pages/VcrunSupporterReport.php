<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Gate;

class VcrunSupporterReport extends Page
{
    use HasPageShield;

    public static function shouldRegisterNavigation(): bool
    {
        return Gate::allows('page_VcrunSupporterReport');
    }

    public function mount()
    {
        abort_unless(Gate::allows('page_VcrunSupporterReport'), 403);
    }
    protected static ?string $navigationIcon = 'heroicon-o-document-download';

    protected static ?string $navigationGroup = 'REPORTS';


    protected static string $view = 'filament.pages.vcrun-supporter-report';
}
