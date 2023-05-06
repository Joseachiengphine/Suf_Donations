<?php

namespace App\Http\Livewire;

use Filament\Forms;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
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
        return Vcrunsupporter::query()
            ->select('vcrun_supporters.*','donation_requests.firstName', 'donation_requests.lastName', 'donation_requests.email', 'donation_requests.phoneNumber','donation_requests.currency')
            ->Join('donation_requests','vcrun_supporters.request_merchant_id', '=','donation_requests.merchantID')
        ->when(
        $this->fromDate,
        fn (Builder $query): Builder => $query
            ->whereDate('vcrun_registrations.created_at', '>=', $this->fromDate)
            ->whereDate('vcrun_registrations.created_at', '<=', $this->toDate)
    );
    }


    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->toggleable()->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('firstName')
                ->searchable(),
            Tables\Columns\TextColumn::make('lastName'),
            Tables\Columns\TextColumn::make('email')
                ->searchable(),
            Tables\Columns\TextColumn::make('phoneNumber')
                ->toggleable()->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('currency')
                ->searchable()
                ->toggleable()->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('supported_registrant_id')
                ->searchable()
                ->label('Merchant ID')
                ->toggleable()->toggledHiddenByDefault(),
            Tables\Columns\TextColumn::make('request_merchant_id'),
            Tables\Columns\TextColumn::make('support_amount'),
            Tables\Columns\TextColumn::make('registration_amount')
                ->toggleable()->toggledHiddenByDefault(),
            BadgeColumn::make('status')
                ->colors([
                    'success' => 'PAID',
                    'danger' => 'PENDING',
                ])
                ->sortable(),
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
                ->tooltip('If you only want Excel (xlsx) reports click here to download'),

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
