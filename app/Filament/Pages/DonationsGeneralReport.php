<?php

namespace App\Filament\Pages;


use App\Models\DonationRequest;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Carbon\Carbon;
use Filament\Pages\Actions\Action;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Gate;


class DonationsGeneralReport extends Page
{
    use HasPageShield;

    public static function shouldRegisterNavigation(): bool
    {
        return Gate::allows('page_DonationsGeneralReport');
    }

    public function mount()
    {
        abort_unless(Gate::allows('page_DonationsGeneralReport'), 403);
    }

    protected static ?string $navigationIcon = 'heroicon-o-document-download';

    protected static ?string $navigationGroup = 'REPORTS';

    protected static string $view = 'filament.pages.donations-general-report';

}
