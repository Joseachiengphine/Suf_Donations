<?php

namespace App\Filament\Pages;


use App\Http\Livewire\Report;
use App\Http\Livewire\ReportVcrun;
use App\Models\Campaign;
use App\Models\ParticipationOption;
use App\Models\Relations;
use App\Models\VcrunRegistration;
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

    protected ?string $maxContentWidth = 'full';

    protected static string $view = 'filament.pages.vcrun-registration-report';

    protected function getActions(): array
    {
        return [
            Action::make('filtervcregistrationsbydate')
                ->label('Filter Registration Dates')
                ->icon('heroicon-s-cog')
                ->action(function (array $data): void {
                    $this->emitTo(ReportVcrun::class,'filtervcregistrationsbydate', $data);
                })
                ->form([
                    Forms\Components\DatePicker::make('from_Reg_date')
                        ->label('From Date')
                        ->required(),
                    Forms\Components\Datepicker::make('to_Reg_date')
                        ->label('To Date')
                        ->required()
                        ->afterOrEqual('from_Reg_date'),
                ]),
            Action::make('filterbyparticipation')
                ->label('Filter By Participation')
                ->icon('heroicon-s-hand')
                ->action(function(array $data): void {
                    $this->emitTo(ReportVcrun::class, 'filterbyparticipation', $data);
                })
                ->form([
                    Forms\Components\Select::make('participation_type')
                        ->label('Pick a Participation')
                        ->searchable()
//                        ->options(ParticipationOption::all()->pluck('name'))
                        ->options([
                            'PHYSICAL' => 'Physical',
                            'VIRTUAL' => 'Virtual',
                        ])
                        ->rules(['required'])
                        ->disablePlaceholderSelection()
                ]),


            Action::make('filterbyrelation')
                ->label('Filter By Relation')
                ->icon('heroicon-s-heart')
                ->action(function(array $data): void {
                    $this->emitTo(ReportVcrun::class, 'filterbyrelation', $data);
                })
                ->form([
                    Forms\Components\Select::make('relation')
                        ->label('Pick a Relation')
                        ->searchable()
//                        ->options(Relations::all()->pluck('relation_name'))

                        ->options([
                            'alumni' => 'Alumni',
                            'friend' => 'Friend',
                            'other' => 'Other',
                            'parent' => 'Parent',
                            'referred by zoezi maisha' => 'Referred By Zoezi Maisha',
                            'staff' => 'Staff',
                            'student' => 'Student',
                        ])
                        ->rules(['required'])
                        ->disablePlaceholderSelection()
                ])

        ];
    }
}
