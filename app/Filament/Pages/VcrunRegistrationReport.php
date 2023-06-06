<?php

namespace App\Filament\Pages;


use Filament\Forms;
use Filament\Pages\Page;
use App\Http\Livewire\ReportVcrun;
use Filament\Pages\Actions\Action;
use Illuminate\Support\Facades\Gate;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class VcrunRegistrationReport extends Page
{
    public  $fromRegDate;

    public $toRegDate;

    public $participation_type;

    public $relation;

    use HasPageShield;

    protected $listeners = ['refresh' => '$refresh'];

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

    public function resetoneFilter($filter) {
        $this->emitTo(ReportVcrun::class, 'resetoneFilter', $filter);
        if (is_array($filter)) {
            foreach ($filter as $f) {
                $this->$f = null;
            }
        } else {
            $this->$filter = null;
        }
        $this->emitSelf('refresh');
    }

    public function resetFilters() {
        $this->emitTo(ReportVcrun::class, 'removeFilter');
        $this->fromRegDate = null;
        $this->toRegDate = null;
        $this->participation_type = null;
        $this->relation = null;
        $this->emitSelf('refresh');
    }

    protected function getActions(): array
    {
        return [
            Action::make('filtervcregistrationsbydate')
                ->label('Filter Registration Dates')
                ->icon('heroicon-s-cog')
                ->action(function (array $data): void {
                    $this->fromRegDate=$data['from_Reg_date'];
                    $this->toRegDate=$data['to_Reg_date'];
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
                    $this->participation_type=$data['participation_type'];
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
                    $this->relation=$data['relation'];
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
