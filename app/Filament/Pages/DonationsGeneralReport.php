<?php

namespace App\Filament\Pages;


use App\Http\Livewire\Report;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Pages\Actions\Action;
use Illuminate\Support\Facades\Gate;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;


class DonationsGeneralReport extends Page
{
    public $fromDate;
    public $toDate;

    Public $campaign;

    public $relation;
    use HasPageShield;

    protected $listeners = ['refresh' => '$refresh'];


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

    protected ?string $maxContentWidth = 'full';

    protected static string $view = 'filament.pages.donations-general-report';

    public function resetoneFilter($filter) {
        $this->emitTo(Report::class, 'removeFilter');
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
        $this->emitTo(Report::class, 'removeFilter');
        $this->fromDate = null;
        $this->toDate = null;
        $this->campaign = null;
        $this->relation = null;
        $this->emitSelf('refresh');
    }

    protected function getActions(): array
    {
        return [
            Action::make('filterbyDate')
                ->label('Filter By Date')
                ->icon('heroicon-s-cog')
                ->action(function (array $data): void {
                    $this->fromDate=$data['from_date'];
                    $this->toDate=$data['to_date'];
                    $this->emitTo(Report::class,'filterbyDate', $data);
                })
                ->form([
                    Forms\Components\DatePicker::make('from_date')
                        ->label('From Date')
                        ->required(),
                    Forms\Components\Datepicker::make('to_date')
                        ->label('To Date')
                        ->required()
                        ->afterOrEqual('from_date'),
                ]),
            Action::make('filterbycampaign')
               ->label('Filter By Campaign')
               ->icon('heroicon-s-fire')
               ->action(function(array $data): void {
                   $this->campaign=$data['campaign'];
                   $this->emitTo(Report::class, 'filterbycampaign', $data);
               })
               ->form([
                   Forms\Components\Select::make('campaign')
                       ->label('Pick a Campaign')
                       ->searchable()
//                       ->options(Campaign::all()->pluck('campaign_name'))
                       ->options([
                           'elimisha stratizen' => 'Elimisha stratizen',
                           'lisha mkenya' => 'Lisha Mkenya',
                           'macheo' => 'Macheo',
                           'professional chairs & research center' => 'Professional Chairs & Research Center',
                           'Other' => 'Other',
                           'scholarship' => 'Scholarship',
                           'student support' => 'Student Support',
                           'vice chancellor\'s run' => 'Vice Chancellor\'s run',
                       ])
                       ->rules(['required'])
                       ->disablePlaceholderSelection()
               ]),
            Action::make('filterbyrelation')
                ->label('Filter By Relation')
                ->icon('heroicon-s-heart')
                ->action(function(array $data): void {
                    $this->relation=$data['relation'];
                    $this->emitTo(Report::class, 'filterbyrelation', $data);
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
