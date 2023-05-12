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

    protected $listeners = ['filtervcrunsupportersbydate', 'Refreshed' => '$refresh'];
    /**
     * @var Forms\ComponentContainer|View|mixed|null
     */
    public  $fromSuppDate;
    public $toSuppDate;

    public function filtervcrunsupportersbydate($data)
    {
        $this->fromSuppDate = $data['from_Supp_date'];
        $this->toSuppDate = $data['to_Supp_date'];
        $this->emitSelf('Refreshed');
    }

    protected function getTableQuery(): Builder
    {
        return Vcrunsupporter::query()
            ->select('vcrun_supporters.*','donation_requests.firstName', 'donation_requests.lastName', 'donation_requests.email', 'donation_requests.phoneNumber','donation_requests.currency')
            ->Join('donation_requests','vcrun_supporters.request_merchant_id', '=','donation_requests.merchantID')
        ->when(
        $this->fromSuppDate,
        fn (Builder $query): Builder => $query
            ->whereDate('vcrun_supporters.created_at', '>=', $this->fromSuppDate)
            ->whereDate('vcrun_supporters.created_at', '<=', $this->toSuppDate)
    );
    }


    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('Name')
                ->getStateUsing(function (Model $record){
                    return $record->firstName . ' ' . $record->lastName;
                }),
            Tables\Columns\TextColumn::make('registration_amount')
                ->label('Reg. Amount')
                ->tooltip('Registration Amount')
                ->default('1000'),
            Tables\Columns\TextColumn::make('support_amount')
            ->label('Supp. Amount')
            ->tooltip('Support Amount'),
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
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->toggleable()->toggledHiddenByDefault(),
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
