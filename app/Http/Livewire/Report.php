<?php

namespace App\Http\Livewire;



use App\Models\Campaign;
use App\Models\CellulantResponseRequest;
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

    protected $listeners = ['filterbyDate','filterbycampaign','filterbyrelation','resetFilters','Refreshed' => '$refresh'];
    /**
     * @var Forms\ComponentContainer|View|mixed|null
     */
    public  $fromDate;
    public $toDate;

    Public $campaign;

    public $relation;

    protected function resetFilters()
    {
        $this->fromDate = null;
        $this->toDate = null;
        $this->campaign = null;
        $this->relation = null;
    }

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
        return CellulantResponseRequest::query()
            ->when(
                $this->fromDate,
                fn (Builder $query): Builder => $query
                    ->whereDate('cellulant_responses.creation_date', '>=', $this->fromDate)
                    ->whereDate('cellulant_responses.creation_date', '<=', $this->toDate)
            )

//            ->whereHas('CellulantResponseRequest', function (Builder $query) {
//                  $query->where('amountPaid', '>', 0);
//            })

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
                ->getStateUsing(function (Model $record) {
                    return ($record->DonationRequest->firstName ?? '') . ' ' . ($record->DonationRequest->lastName ?? '');
                }),
            BadgeColumn::make('donationrequest.relation')
                ->colors([
                ])
                ->label('Relation'),
            BadgeColumn::make('donationrequest.campaign')
                ->colors([
                    'primary',
                ])
                ->label('Campaign'),
                Tables\Columns\TextColumn::make('requestAmount')
                    ->alignRight('true')
                    ->label('Request Amount')
                    ->Searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->money('KES', '1')
                    ->default('0'),
               Tables\Columns\TextColumn::make('amountPaid')
                   ->alignRight('true')
                   ->label('Amount Paid')
                   ->Searchable()
                   ->money('KES', '1')
                   ->default('0'),
               Tables\Columns\TextColumn::make('creation_date')
                ->label('Paid on')
                ->tooltip('Click the filter button to filter by date')
                ->date()
                ->sortable()
                ->searchable(['creation_date']),
                Tables\Columns\TextColumn::make('last_update')
                    ->dateTime()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
                Tables\Columns\TextColumn::make('merchantTransactionID')
                    ->label('Merchant ID')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
                Tables\Columns\TextColumn::make('donationrequest.salutation')
                    ->label('Salutation')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
                Tables\Columns\TextColumn::make('donationrequest.phoneNumber')
                    ->label('Phone Number')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('donationrequest.email')
                   ->label('Email'),
                Tables\Columns\TextColumn::make('donationrequest.zipCode')
                    ->label('Zip Code')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('donationrequest.city')
                    ->label('City')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
                Tables\Columns\TextColumn::make('donationrequest.country')
                    ->label('Country')
                    ->Searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('donationrequest.company')
                    ->label('Company')
                    ->Searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('currencyCode')
                    ->label('Currency')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
                Tables\Columns\TextColumn::make('donationrequest.requestDescription')
                    ->label('Request Description')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
                Tables\Columns\TextColumn::make('donationrequest.job_title')
                    ->label('Job Title')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
                Tables\Columns\TextColumn::make('donationrequest.graduation_class')
                    ->label('Graduation Class')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
                Tables\Columns\TextColumn::make('donationrequest.student_number')
                    ->label('Student Number')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
                Tables\Columns\TextColumn::make('donationrequest.shirt_size')
                    ->label('Shirt Size')
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

