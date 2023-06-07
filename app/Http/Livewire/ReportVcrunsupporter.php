<?php

namespace App\Http\Livewire;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use App\Models\VcrunSupporter;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Concerns\InteractsWithTable;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;

class ReportVcrunsupporter extends Component implements Tables\Contracts\HasTable
{
    use InteractsWithTable;

    protected $listeners = ['filtervcrunsupportersbydate','filterbyrelation','removeFilter', 'resetoneFilter','Refreshed' => '$refresh'];
    /**
     * @var Forms\ComponentContainer|View|mixed|null
     */
    public  $fromSuppDate;
    public $toSuppDate;

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
        $this->fromSuppDate = null;
        $this->toSuppDate = null;
        $this->relation = null;

        $this->emitSelf('Refreshed');
    }

    public function filtervcrunsupportersbydate($data)
    {
        $this->fromSuppDate = $data['from_Supp_date'];
        $this->toSuppDate = $data['to_Supp_date'];
        $this->emitSelf('Refreshed');
    }

    public function filterbyrelation($data)
    {
        $this->relation = $data['relation'];
        $this->emitSelf('Refreshed');
    }

    protected function getTableQuery(): Builder
    {
        return Vcrunsupporter::query()
        ->when(
        $this->fromSuppDate,
        fn (Builder $query): Builder => $query
            ->whereDate('vcrun_supporters.created_at', '>=', $this->fromSuppDate)
            ->whereDate('vcrun_supporters.created_at', '<=', $this->toSuppDate)
    )
            ->where('paid_amount', '>', 0)

            ->join('donation_requests', 'donation_requests.merchantID', '=', 'vcrun_supporters.request_merchant_id')

            ->when(
            $this->relation,
            fn(Builder $query): Builder => $query
                ->where('donation_requests.relation', $this->relation)
        );

    }


    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('Name')
                ->getStateUsing(function (Model $record) {
                    return ($record->DonationRequest->firstName ?? '') . ' ' . ($record->DonationRequest->lastName ?? '');
                }),
            BadgeColumn::make('DonationRequest.relation')
                ->label('Relation')
                ->colors([
                ]),
            Tables\Columns\TextColumn::make('support_amount')
                ->label('Reg. Amount')
                ->tooltip('Registration Amount')
                ->toggleable()
                ->toggledHiddenByDefault()
//                ->money('KES', '1')
                ->alignRight('true'),
            Tables\Columns\TextColumn::make('paid_amount')
                ->label('Paid Amount')
//                ->money('KES', '1')
                ->alignRight('true'),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Paid on')
                ->tooltip('Click the filter button to filter by date')
                ->date()
                ->sortable(),
            BadgeColumn::make('status')
                ->colors([
                    'success' => 'PAID',
                    'danger' => 'PENDING',
                ])
                ->sortable(),
//            BadgeColumn::make('supportedRegistrant.participation_type')
//                ->label('Participation Type')
//                ->colors([
//                    'primary' => 'PHYSICAL',
//                    'secondary' => 'VIRTUAL',
//                ])
//                ->searchable(),
            Tables\Columns\TextColumn::make('updated_at')
                ->date()
                ->toggleable()->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('DonationRequest.email')
                ->label('Email')
                ->searchable(),
            Tables\Columns\TextColumn::make('DonationRequest.phoneNumber')
                ->label('Phone Number')
                ->toggleable()->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('DonationRequest.currency')
                ->label('Currency')
                ->searchable()
                ->toggleable()->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('supported_registrant_id')
                ->searchable()
                ->label('Merchant ID')
                ->toggleable()->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('request_merchant_id')
            ->toggleable()
            ->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('matching_donor_id')
                ->toggleable()->toggledHiddenByDefault(),
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }


    protected function getTableFilters(): array
    {
        return [
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
//            FilamentExportHeaderAction::make('Download Run Supporters Report')
//                ->button()
//                ->withHiddenColumns()

            ExportAction::make('Download Run Supporters Report')
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
            FilamentExportBulkAction::make('Download Run Supporters Report')
                ->withHiddenColumns()
        ];
    }
    public function render(): view
    {
        return view('livewire.report-vcrunsupporter');
    }
}
