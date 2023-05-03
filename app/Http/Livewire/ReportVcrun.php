<?php

namespace App\Http\Livewire;


use Filament\Forms;
use Filament\Tables;
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

    protected function getTableQuery(): Builder
    {
        return VcrunRegistration::query()
            ->select('vcrun_registrations.*','donation_requests.firstName', 'donation_requests.lastName', 'donation_requests.email', 'donation_requests.phoneNumber','donation_requests.currency')
            ->Join('donation_requests','vcrun_registrations.request_merchant_id', '=','donation_requests.merchantID');
    }


    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('created_at')
                ->toggleable()
                ->toggledHiddenByDefault()
                ->sortable(),
            Tables\Columns\TextColumn::make('updated_at')
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
            Tables\Columns\TextColumn::make('request_merchant_id')
                ->label('Merchant ID')
                ->toggleable()->toggledHiddenByDefault(),
            BadgeColumn::make('participation_type')
                ->colors([
                    'primary' => 'PHYSICAL',
                    'secondary' => 'VIRTUAL',
                ])
                ->searchable(),
            Tables\Columns\TextColumn::make('race_kms')
                ->searchable(),
            Tables\Columns\TextColumn::make('registration_amount')
                ->searchable(),
            Tables\Columns\TextColumn::make('paid_amount'),
            BadgeColumn::make('status')
                ->colors([
                    'success' => 'PAID',
                    'danger' => 'PENDING',
                ])
                ->sortable(),
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
            Filter::make('creation_date')
                ->form([
                    Forms\Components\DatePicker::make('created_at'),
                    Forms\Components\DatePicker::make('updated_at'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_at'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['updated_at'],
                            fn (Builder $query, $date): Builder => $query->whereDate('updated_at', '<=', $date),
                        );
                })

        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
//            FilamentExportHeaderAction::make('Download Run Report')
//                ->button()
//                ->csvDelimiter(',')
//                ->withHiddenColumns(),
            ExportAction::make('Download Run Report')
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
