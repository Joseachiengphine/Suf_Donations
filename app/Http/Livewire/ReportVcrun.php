<?php

namespace App\Http\Livewire;


use Filament\Forms;
use Filament\Tables;
use Livewire\Component;
use App\Models\VcrunRegistration;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Concerns\InteractsWithTable;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;


class ReportVcrun extends Component implements Tables\Contracts\HasTable
{
    use InteractsWithTable;

    protected $listeners = ['filtervcregistrationsbydate','filterbyparticipation','filterbyrelation', 'removeFilter','resetoneFilter','Refreshed' => '$refresh'];
    /**
     * @var Forms\ComponentContainer|View|mixed|null
     */
    public $fromRegDate;

    public $toRegDate;

    public $participation_type;

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
        $this->fromRegDate = null;
        $this->toRegDate = null;
        $this->participation_type = null;
        $this->relation = null;

        $this->emitSelf('Refreshed');
    }

    public function filtervcregistrationsbydate($data)
    {
        $this->fromRegDate = $data['from_Reg_date'];
        $this->toRegDate = $data['to_Reg_date'];
        $this->emitSelf('Refreshed');
    }

    public function filterbyparticipation($data)
    {
        $this->participation_type = $data['participation_type'];
        $this->emitSelf('Refreshed');
    }

    public function filterbyrelation($data)
    {
        $this->relation = $data['relation'];
        $this->emitSelf('Refreshed');
    }

    protected function getTableQuery(): Builder
    {
        return VcrunRegistration::query()->orderBy('created_at', 'desc')
            ->when(
                $this->fromRegDate,
                fn (Builder $query): Builder => $query
                    ->whereDate('vcrun_registrations.created_at', '>=', $this->fromRegDate)
                    ->whereDate('vcrun_registrations.created_at', '<=', $this->toRegDate)
            )
            ->where('paid_amount', '>', 0)

            ->when(
                 $this->participation_type,
                 fn(Builder $query): Builder => $query
                 ->where('participation_type', $this->participation_type)
            )
//            ->join('donation_requests', 'donation_requests.merchantID', '=', 'vcrun_registrations.request_merchant_id')
            ->leftJoin('donation_requests', 'vcrun_registrations.request_merchant_id', '=', 'donation_requests.merchantID')
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
            Tables\Columns\TextColumn::make('DonationRequest.student_number')
                ->label('Student Number')
                ->searchable()
                ->toggleable()
                ->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('registration_amount')
                ->alignRight('true')
                ->label('Reg. Amount')
                ->tooltip('Registration Amount')
                ->toggleable()
                ->toggledHiddenByDefault()
                ->searchable()
//                ->money('KES', '1')
            ,
            Tables\Columns\TextColumn::make('paid_amount')
                ->alignRight('true')
//                ->money('KES', '1')
            ,
            Tables\Columns\TextColumn::make('created_at')
                ->label('Paid on')
                ->tooltip('Click the filter button to filter by date')
                ->date()
                ->sortable(),
            Tables\Columns\TextColumn::make('updated_at')
                ->date()
                ->toggleable()->toggledHiddenByDefault(),
            BadgeColumn::make('status')
                ->label('Status')
                ->colors([
                    'success' => 'PAID',
                    'danger' => 'PENDING',
                ])
                ->sortable(),
            BadgeColumn::make('participation_type')
                ->colors([
                    'primary' => 'PHYSICAL',
                    'secondary' => 'VIRTUAL',
                ])
                ->searchable(),
            Tables\Columns\TextColumn::make('race_kms')
                ->searchable(),
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
            Tables\Columns\TextColumn::make('DonationRequest.shirt_size')
                ->label('Shirt Size')
                ->searchable()
                ->toggleable()
                ->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('request_merchant_id')
                ->label('Merchant ID')
                ->toggleable()->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('matching_donor_id')
                ->toggleable()->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('matched_amount')
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
            SelectFilter::make('status')
                ->options([
                    'paid' => 'Paid',
                    'pending' => 'Pending',

                ]),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [

            ExportAction::make('Download Run Report')
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
            FilamentExportBulkAction::make('Download Run Report')
                ->withHiddenColumns()
                ->csvDelimiter(',')
        ];
    }
    public function render(): view
    {
        return view('livewire.report-vcrun');
    }
}
