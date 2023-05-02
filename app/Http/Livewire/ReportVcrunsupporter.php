<?php

namespace App\Http\Livewire;

use App\Models\VcrunSupporter;
use Filament\Tables;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Filament\Tables\Concerns\InteractsWithTable;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class ReportVcrunsupporter extends Component implements Tables\Contracts\HasTable
{
    use InteractsWithTable;

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Vcrunsupporter::query()
            ->select('vcrun_supporters.*','donation_requests.firstName', 'donation_requests.lastName', 'donation_requests.email', 'donation_requests.phoneNumber','donation_requests.currency')
            ->Join('donation_requests','vcrun_supporters.request_merchant_id', '=','donation_requests.merchantID');
    }


    protected function getTableColumns(): array
    {
        return [
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
            Tables\Columns\TextColumn::make('status'),
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
            DateRangeFilter::make('created_at')
                ->columnSpan(2)
                ->label('Registration Dates')
                ->withIndicater(),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
//            FilamentExportHeaderAction::make('Download Run Supporters Report')
//                ->button()
//                ->withHiddenColumns()

            ExportAction::make('Download Run Supporters Report')

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
