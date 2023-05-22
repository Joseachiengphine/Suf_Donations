<?php

namespace App\Filament\Pages;




use App\Http\Livewire\ReportVcrunsupporter;
use App\Models\Campaign;
use App\Models\ParticipationOption;
use App\Models\Relations;
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
                ->label('Filter By Date')
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
