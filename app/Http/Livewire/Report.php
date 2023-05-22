<?php

namespace App\Http\Livewire;



use App\Models\Campaign;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use App\Models\DonationRequest;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Concerns\InteractsWithTable;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use function Filament\Support\get_model_label;


class Report extends Component implements Tables\Contracts\HasTable
{

    use InteractsWithTable;

    protected $listeners = ['filterbyDate','filterbycampaign','filterbyrelation','Refreshed' => '$refresh'];
    /**
     * @var Forms\ComponentContainer|View|mixed|null
     */
    public  $fromDate;
    public $toDate;

    Public $campaign;

    public $relation;

      public function filterbyDate($data)
      {
          $this->fromDate = $data['from_date'];
          $this->toDate = $data['to_date'];
          $this->emitSelf('Refreshed');
      }

      public function filterbycampaign($data)
      {
          $this->campaign = $data['campaign'];
          $this->emitSelf('Refreshed');
      }
      public function filterbyrelation($data)
      {
        $this->relation = $data['relation'];
        $this->emitSelf('Refreshed');
      }

    protected function getTableQuery(): Builder
    {
        return DonationRequest::query()
            ->when(
                $this->fromDate,
                fn (Builder $query): Builder => $query
                    ->whereDate('donation_requests.creation_date', '>=', $this->fromDate)
                    ->whereDate('donation_requests.creation_date', '<=', $this->toDate)
            )

            ->whereHas('CellulantResponseRequest', function (Builder $query) {
                  $query->where('amountPaid', '>', 0);
            })

           ->when(
               $this->campaign,
               fn(Builder $query): Builder => $query
                ->where('campaign', $this->campaign)
           )
          ->when(
              $this->relation,
              fn(Builder $query): Builder => $query
                 ->where('relation', $this->relation)
          );
    }

    protected function getTableColumns(): array
    {
        return [
                Tables\Columns\TextColumn::make('Name')
                ->getStateUsing(function (Model $record){
                    return $record->firstName . ' ' . $record->lastName;
                }),
            BadgeColumn::make('relation')
                ->colors([
                ]),
            BadgeColumn::make('campaign')
                ->colors([
                    'primary',
                ]),
                Tables\Columns\TextColumn::make('CellulantResponseRequest.requestAmount')
                    ->label('Request Amount')
                    ->Searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->money('KES', '1')
                    ->default('0'),
               Tables\Columns\TextColumn::make('CellulantResponseRequest.amountPaid')
                   ->label('Amount Paid')
                   ->Searchable()
                   ->money('KES', '1')
                   ->default('0'),
               Tables\Columns\TextColumn::make('creation_date')
                ->label('Paid on')
                ->tooltip('Click the filter button to filter by date')
                ->date()
                ->sortable()
                ->searchable(['donation_requests.creation_date']),
                Tables\Columns\TextColumn::make('last_update')
                    ->dateTime()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
                Tables\Columns\TextColumn::make('merchantID')
                    ->label('Merchant ID')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
                Tables\Columns\TextColumn::make('salutation')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
                Tables\Columns\TextColumn::make('phoneNumber')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                BadgeColumn::make('campaign')
                ->colors([
                    'primary',
                ]),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('zipCode')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('city')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
                Tables\Columns\TextColumn::make('country')
                    ->Searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('company')
                    ->Searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('currency')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
                Tables\Columns\TextColumn::make('requestDescription')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
                Tables\Columns\TextColumn::make('job_title')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
                Tables\Columns\TextColumn::make('graduation_class')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
                Tables\Columns\TextColumn::make('student_number')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
                Tables\Columns\TextColumn::make('shirt_size')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
            ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }


    protected function getTableFilters(): array
    {

        return [
//            Filter::make('creation_date')
//                ->form([
//                    Forms\Components\DatePicker::make('creation_date'),
//                    Forms\Components\DatePicker::make('last_update'),
//                ])
//                ->query(function (Builder $query, array $data): Builder {
//                    return $query
//                        ->when(
//                            $data['creation_date'],
//                            fn (Builder $query, $date): Builder => $query
//                                ->whereDate('donation_requests.creation_date', '>=', $this->fromDate)
//                                ->whereDate('donation_requests.creation_date', '<=', $this->toDate),
//                        );
//                })

        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            ExportAction::make('Download Donation Report')
            ->tooltip('If you only want Excel (xlsx) reports click here to download')
                ->requiresConfirmation(),
        ];
    }

    protected function getTableActions(): array
    {
        return [

            ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            FilamentExportBulkAction::make('Download Donation Report')
                ->withHiddenColumns()

        ];
    }
    public function render(): View
    {
        return view('livewire.report');
    }


}

