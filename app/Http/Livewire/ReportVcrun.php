<?php

namespace App\Http\Livewire;


use Filament\Forms;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use App\Models\VcrunRegistration;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\View\View;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Concerns\InteractsWithTable;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;


class ReportVcrun extends Component implements Tables\Contracts\HasTable
{
    use InteractsWithTable;

    protected function getTablePollingInterval(): ?string
    {
        return '2s';
    }

    protected $listeners = ['filtervcregistrationsbydate', 'Refreshed' => '$refresh'];
    /**
     * @var Forms\ComponentContainer|View|mixed|null
     */
    public  $fromRegDate;
    public $toRegDate;

    public function filtervcregistrationsbydate($data)
    {
        $this->fromRegDate = $data['from_Reg_date'];
        $this->toRegDate = $data['to_Reg_date'];
        $this->emitSelf('Refreshed');
    }

    protected function getTableQuery(): Builder
    {
        return VcrunRegistration::query()
            ->select('vcrun_registrations.*','donation_requests.firstName', 'donation_requests.lastName', 'donation_requests.email', 'donation_requests.phoneNumber','donation_requests.currency', 'donation_requests.student_number', 'donation_requests.shirt_size')
            ->Join('donation_requests','vcrun_registrations.request_merchant_id', '=','donation_requests.merchantID')
            ->when(
                $this->fromRegDate,
                fn (Builder $query): Builder => $query
                    ->whereDate('vcrun_registrations.created_at', '>=', $this->fromRegDate)
                    ->whereDate('vcrun_registrations.created_at', '<=', $this->toRegDate)
            );
    }


    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('Name')
                ->getStateUsing(function (Model $record){
                    return $record->firstName . ' ' . $record->lastName;
                }),
            Tables\Columns\TextColumn::make('student_number')
                ->searchable()
                ->toggleable()
                ->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('registration_amount')
                ->label('Reg. Amount')
                ->tooltip('Registration Amount')
                ->searchable(),
            Tables\Columns\TextColumn::make('paid_amount'),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Paid on')
                ->tooltip('Click the filter button to filter by date')
                ->date()
                ->sortable(),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
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
            Tables\Columns\TextColumn::make('email')
                ->searchable(),
            Tables\Columns\TextColumn::make('phoneNumber')
                ->toggleable()->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('currency')
                ->searchable()
                ->toggleable()->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('shirt_size')
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
