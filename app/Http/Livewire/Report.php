<?php

namespace App\Http\Livewire;


use DateTime;
use Filament\Forms;
use Filament\Tables;
use Livewire\Component;
use App\Models\DonationRequest;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Tables\Concerns\InteractsWithTable;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;


class Report extends Component implements Tables\Contracts\HasTable
{

    use InteractsWithTable;

    protected function getTablePollingInterval(): ?string
    {
        return '10s';
    }

    protected $listeners = ['filterbyDate', 'Refreshed' => '$refresh'];
    /**
     * @var Forms\ComponentContainer|View|mixed|null
     */
    public  $fromDate;
    public $toDate;

      public function filterbyDate($data)
      {
          $this->fromDate = $data['from_date'];
          $this->toDate = $data['to_date'];
          $this->emitSelf('Refreshed');
      }


    protected function getTableQuery(): Builder
    {
        return DonationRequest::query()
            ->select('donation_requests.*', 'cellulant_responses.requestAmount', 'cellulant_responses.amountPaid')
            ->join('cellulant_responses', 'donation_requests.merchantID', '=', 'cellulant_responses.merchantTransactionID')
            ->when(
                $this->fromDate,
                fn (Builder $query): Builder => $query
                    ->whereDate('donation_requests.creation_date', '>=', $this->fromDate)
                    ->whereDate('donation_requests.creation_date', '<=', $this->toDate)
            );
    }

    protected function getTableColumns(): array
    {
        return [
                Tables\Columns\TextColumn::make('creation_date')
                    ->label('Paid on')
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
                Tables\Columns\TextColumn::make('firstName'),
                Tables\Columns\TextColumn::make('lastName'),
                Tables\Columns\TextColumn::make('phoneNumber')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
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
                Tables\Columns\TextColumn::make('campaign'),
                Tables\Columns\TextColumn::make('company')
                    ->Searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('currency')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
                Tables\Columns\TextColumn::make('requestAmount')
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->Searchable(),
                Tables\Columns\TextColumn::make('amountPaid')
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
                Tables\Columns\TextColumn::make('relation')
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
            Filter::make('creation_date')
                ->form([
                    Forms\Components\DatePicker::make('creation_date'),
                    Forms\Components\DatePicker::make('last_update'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['creation_date'],
                            fn (Builder $query, $date): Builder => $query
                                ->whereDate('donation_requests.creation_date', '>=', $this->fromDate)
                                ->whereDate('donation_requests.creation_date', '<=', $this->toDate),
                        );
                })

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

