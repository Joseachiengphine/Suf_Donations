<?php

namespace App\Http\Livewire;



use App\Models\CellulantResponseRequest;
use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Concerns\InteractsWithTable;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;


class Report extends Component implements Tables\Contracts\HasTable
{

    use InteractsWithTable;

    protected $listeners = ['filterbyDate','filterbycampaign','filterbyrelation','removeFilter','resetoneFilter','Refreshed' => '$refresh'];
    /**
     * @var Forms\ComponentContainer|View|mixed|null
     */
    public $fromDate;
    public $toDate;

    Public $campaign;

    public $relation;

    public $resetoneFilter;
    public $removeFilter;

    public function resetoneFilter($filter)
    {
        if (is_array($filter)) {
            foreach ($filter as $f) {
                $this->$f = null;
            }
        } else {
            $this->$filter = null;
        }

        $this->emitSelf('Refreshed');
    }

    public function removeFilter()
    {
        $this->fromDate = null;
        $this->toDate = null;
        $this->campaign = null;
        $this->relation = null;

        $this->emitSelf('Refreshed');
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
        return CellulantResponseRequest::query()->orderBy('cellulant_responses.creation_date', 'desc')
            ->when(
                $this->fromDate,
                fn (Builder $query): Builder => $query
                    ->whereDate('cellulant_responses.creation_date', '>=', $this->fromDate)
                    ->whereDate('cellulant_responses.creation_date', '<=', $this->toDate)
            )
//            ->join('donation_requests', 'donation_requests.merchantID', '=', 'cellulant_responses.merchantTransactionID')
            ->leftJoin('donation_requests', 'cellulant_responses.merchantTransactionID', '=', 'donation_requests.merchantID')
            ->when(
                $this->campaign,
                fn(Builder $query): Builder => $query
                    ->where('donation_requests.campaign', $this->campaign)
            )
            ->when(
                $this->relation,
                fn(Builder $query): Builder => $query
                    ->where('donation_requests.relation', $this->relation)
            );
    }

    protected function getTableColumns(): array
    {
        return [
        Tables\Columns\TextColumn::make('Paid by')
                ->getStateUsing(function (Model $record) {
                    return ($record->DonationRequest->firstName ?? '') . ' ' . ($record->DonationRequest->lastName ?? '');
                }),
            Tables\Columns\TextColumn::make('donationrequest.email')
                ->label('Email')
                ->default('--'),
            BadgeColumn::make('donationrequest.relation')
                ->label('Strathmore Relation')
                ->searchable()
                ->colors([
                ]),
            BadgeColumn::make('donationrequest.campaign')
                ->searchable()
                ->label('Campaign')
                ->colors([
                    'primary',
                ]),
            Tables\Columns\TextColumn::make('requestAmount')
                ->alignRight()
                ->label('Request Amount')
                ->toggleable()
                ->toggledHiddenByDefault()
//                ->money('KES', '1')
            ,
            Tables\Columns\TextColumn::make('amountPaid')
                ->alignRight()
                ->label('Amount Paid')
//                ->money('KES', '1')
            ,
            Tables\Columns\TextColumn::make('donationrequest.creation_date')
                ->label('Paid on')
                ->searchable()
                ->tooltip('Click the filter button to filter by date')
                ->date()
                ->sortable(),
            Tables\Columns\TextColumn::make('last_update')
                ->date()
                ->toggleable()
                ->toggledHiddenByDefault()
                ->sortable(),
            Tables\Columns\TextColumn::make('donationrequest.merchantID')
                ->label('Merchant ID')
                ->toggleable()
                ->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('donationrequest.salutation')
                ->label('Salutation')
                ->toggleable()
                ->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('donationrequest.phoneNumber')
                ->label('Phone Number')
                ->toggleable()
                ->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('donationrequest.zipCode')
                ->label('Zip Code')
                ->toggleable()
                ->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('donationrequest.city')
                ->label('City')
                ->toggleable()
                ->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('donationrequest.country')
                ->label('Country')
                ->toggleable()
                ->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('donationrequest.company')
                ->label('Company')
                ->toggleable()
                ->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('donationrequest.currency')
                ->label('Currency')
                ->toggleable()
                ->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('donationrequest.requestDescription')
                ->label('Request Description')
                ->toggleable()
                ->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('donationrequest.job_title')
                ->label('Job Title')
                ->toggleable()
                ->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('donationrequest.graduation_class')
                ->label('Graduation Class')
                ->toggleable()
                ->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('donationrequest.student_number')
                ->label('Student Number')
                ->toggleable()
                ->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('donationrequest.shirt_size')
                ->label('Shirt Size')
                ->toggleable()
                ->toggledHiddenByDefault(),
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }


    protected function getTableFilters(): array
    {

        return [
//
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
                ->disablePreview()


        ];
    }
    public function render(): View
    {
        return view('livewire.report');
    }


}
