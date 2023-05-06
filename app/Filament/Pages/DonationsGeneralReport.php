<?php

namespace App\Filament\Pages;


use App\Http\Livewire\Report;
use App\Models\DonationRequest;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Pages\Actions\Action;
use Illuminate\Support\Facades\Gate;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Excel;


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

    protected function getActions(): array
    {
        return [
            Action::make('filterbyDate')
                ->label('Filter By Date')
                ->icon('heroicon-s-cog')
                ->action(function (array $data): void {
                    $this->emitTo(Report::class,'filterbyDate', $data);
                })
                ->form([
                    Forms\Components\DatePicker::make('from_date')
                        ->label('From Date')
                        ->required(),
                    Forms\Components\Datepicker::make('to_date')
                        ->label('To Date')
                        ->required(),
                ]),
        ];
    }
}
