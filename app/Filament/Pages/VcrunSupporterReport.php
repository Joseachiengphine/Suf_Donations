<?php

namespace App\Filament\Pages;




use App\Filament\Widgets\DonationPaymentOverview;
use App\Filament\Widgets\DonationssuppOverview;
use App\Http\Livewire\ReportVcrun;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Pages\Actions\Action;
use Illuminate\Support\Facades\Gate;
use App\Http\Livewire\ReportVcrunsupporter;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class VcrunSupporterReport extends Page
{
    public  $fromSuppDate;
    public $toSuppDate;

    public $relation;

    use HasPageShield;

    protected $listeners = ['refresh' => '$refresh'];

//    protected function getHeaderWidgets(): array
//    {
//        return [
//            DonationssuppOverview::class
//        ];
//    }

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


    public function resetoneFilter($filter) {
        $this->emitTo(ReportVcrunsupporter::class, 'resetoneFilter', $filter);
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
        $this->emitTo(ReportVcrunsupporter::class, 'removeFilter');
        $this->fromSuppDate = null;
        $this->toSuppDate = null;
        $this->relation = null;
        $this->emitSelf('refresh');
    }

    protected function getActions(): array
    {
        return [
            Action::make('filtervcrunsupportersbydate')
                ->label('Filter By Date')
                ->icon('heroicon-s-cog')
                ->action(function (array $data): void {
                    $this->fromSuppDate=$data['from_Supp_date'];
                    $this->toSuppDate=$data['to_Supp_date'];
                    $this->emitTo(ReportVcrunsupporter::class,'filtervcrunsupportersbydate', $data);
                })
                ->form([
                    Forms\Components\DatePicker::make('from_Supp_date')
                        ->label('From Date')
                        ->required(),
                    Forms\Components\Datepicker::make('to_Supp_date')
                        ->label('To Date')
                        ->required()
                        ->afterOrEqual('from_Supp_date'),
                ]),

//            Action::make('filterbyparticipation')
//                ->label('Filter By Participation')
//                ->icon('heroicon-s-hand')
//                ->action(function(array $data): void {
//                    $this->emitTo(ReportVcrunsupporter::class, 'filterbyparticipation', $data);
//                })
//                ->form([
//                    Forms\Components\Select::make('participation_type')
//                        ->label('Pick a Participation')
//                        ->searchable()
////                        ->options(ParticipationOption::all()->pluck('name'))
//                        ->options([
//                            'PHYSICAL' => 'Physical',
//                            'VIRTUAL' => 'Virtual',
//                        ])
//                        ->rules(['required'])
//                        ->disablePlaceholderSelection()
//                ]),


            Action::make('filterbyrelation')
                ->label('Filter By Relation')
                ->icon('heroicon-s-heart')
                ->action(function(array $data): void {
                    $this->relation=$data['relation'];
                    $this->emitTo(ReportVcrunsupporter::class, 'filterbyrelation', $data);
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
