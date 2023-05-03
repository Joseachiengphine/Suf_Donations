<?php

namespace App\Http\Livewire;

use Awcodes\Shout\Shout;
use Filament\Notifications\Notification;
use Filament\Tables;
use Livewire\Component;
use App\Models\DonationRequest;
use App\Models\CellulantResponseRequest;
use Illuminate\Contracts\View\View;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Filament\Tables\Concerns\InteractsWithTable;
use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Webbingbrasil\FilamentAdvancedFilter\Filters\DateFilter;


class Report extends Component implements Tables\Contracts\HasTable
{

    use InteractsWithTable;

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return DonationRequest::query()
        ->select('donation_requests.*','cellulant_responses.requestAmount','cellulant_responses.amountPaid')
            ->Join('cellulant_responses','donation_requests.merchantID', '=','cellulant_responses.merchantTransactionID');
    }

    protected function getTableColumns(): array
    {
        return [
                Tables\Columns\TextColumn::make('creation_date')
                    ->dateTime()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_update')
                    ->dateTime()
                    ->toggleable()
                    ->toggledHiddenByDefault()
                    ->sortable(),
                Tables\Columns\TextColumn::make('merchantID')
                    ->label('Merchant ID')
                    ->searchable()
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('salutation')
                ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('firstName')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lastName')
                ->searchable(),
                Tables\Columns\TextColumn::make('phoneNumber')
                ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('email')
                ->searchable(),
                Tables\Columns\TextColumn::make('zipCode')
                ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('city')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('country')
                ->searchable(),
                Tables\Columns\TextColumn::make('campaign'),
                Tables\Columns\TextColumn::make('company')
                    ->searchable(),
                Tables\Columns\TextColumn::make('currency')
                ->searchable()
                ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('requestAmount')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('amountPaid')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('requestDescription')
                ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('job_title')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('graduation_class')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('relation')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('student_number')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('shirt_size')
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
//            DateRangeFilter::make('creation_date')
//                ->useColumn('creation_date')
//                ->columnSpan(1)
//                ->label('Registration Dates')
//                ->withIndicater()
            DateFilter::make('creation_date')

        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
//            FilamentExportHeaderAction::make('Download Donation Report')
//                ->button()
//                ->withHiddenColumns()
            ExportAction::make('Download Donation Report')
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
            FilamentExportBulkAction::make('Download Donation Report')
                ->withHiddenColumns()
        ];
    }
    public function render(): View
    {
        return view('livewire.report');
    }


}

