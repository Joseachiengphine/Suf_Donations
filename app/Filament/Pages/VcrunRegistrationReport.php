<?php

namespace App\Filament\Pages;


use App\Http\Livewire\Report;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Actions\Action;
use Filament\Pages\Page;
use Filament\Forms;
use Illuminate\Support\Facades\Gate;

class VcrunRegistrationReport extends Page
{

    use HasPageShield;

    public static function shouldRegisterNavigation(): bool
    {
        return Gate::allows('page_VcrunRegistrationReport');
    }

    public function mount()
    {
        abort_unless(Gate::allows('page_VcrunRegistrationReport'), 403);
    }
    protected static ?string $navigationIcon = 'heroicon-o-document-download';

    protected static ?string $navigationGroup = 'REPORTS';

    protected static string $view = 'filament.pages.vcrun-registration-report';

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
