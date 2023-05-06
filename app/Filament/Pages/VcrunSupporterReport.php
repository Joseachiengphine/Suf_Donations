<?php

namespace App\Filament\Pages;




use App\Http\Livewire\ReportVcrunsupporter;
use Filament\Forms;
use Filament\Pages\Page;
use App\Http\Livewire\Report;
use Filament\Pages\Actions\Action;
use Illuminate\Support\Facades\Gate;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

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

    protected function getActions(): array
    {
        return [
            Action::make('filtervcrunsupportersbydate')
                ->label('Filter By Dates')
                ->icon('heroicon-s-cog')
                ->action(function (array $data): void {
                    $this->emitTo(ReportVcrunsupporter::class,'filtervcrunsupportersbydate', $data);
                })
                ->form([
                    Forms\Components\DatePicker::make('from_Supp_date')
                        ->label('From Date')
                        ->required(),
                    Forms\Components\Datepicker::make('to_Supp_date')
                        ->label('To Date')
                        ->required(),
                ]),
        ];
    }
}
