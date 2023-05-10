<?php

namespace App\Filament\Resources;


use AlperenErsoy\FilamentExport\Actions\FilamentExportBulkAction;
use App\Filament\Resources\CellulantResponseRequestResource\Pages;
use App\Filament\Resources\CellulantResponseRequestResource\RelationManagers\DonationrequestRelationManager;
use App\Models\CellulantResponseRequest;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;
use Webbingbrasil\FilamentDateFilter\DateFilter;


class CellulantResponseRequestResource extends Resource
{

    protected static ?string $model = CellulantResponseRequest::class;

    protected static ?string $recordTitleAttribute = 'merchantTransactionID';

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('CELLULANT RESPONSE REQUESTS')->schema(
                    [
                        Forms\Components\Fieldset::make('Transaction Details')
                            ->schema([
                Forms\Components\TextInput::make('checkOutRequestID')
                    ->label('Check out request ID')
                    ->filled()
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('merchantTransactionID')
                    ->required()
                    ->label('Merchant Transaction ID')
                    ->maxLength(50),
                    Forms\Components\TextInput::make('MSISDN')
                    ->label('MSISDN')
                    ->required()
                    ->maxLength(16),
                    Forms\Components\TextInput::make('requestStatusCode')
                    ->required()
                    ->maxLength(4),
                    Forms\Components\TextInput::make('serviceCode')
                    ->required()
                    ->maxLength(64),
                Forms\Components\TextInput::make('accountNumber')
                    ->required()
                    ->maxLength(64),
                ]),
                Forms\Components\Fieldset::make('Transaction amount')
                    ->schema([
                Forms\Components\TextInput::make('currencyCode')
                    ->required()
                    ->maxLength(3),
                Forms\Components\TextInput::make('amountPaid')
                    ->required(),
                Forms\Components\TextInput::make('requestAmount')
                    ->required(),
                ]),
                Forms\Components\Fieldset::make('Transaction Dates')
                    ->schema([
                Forms\Components\TextInput::make('requestDate')
                    ->required()
                    ->maxLength(50),
                Forms\Components\DateTimePicker::make('creation_date')
                    ->required(),
                Forms\Components\DateTimePicker::make('last_update')
                    ->required(),
                ]),
                Forms\Components\Textarea::make('requestStatusDescription')
                    ->required()
                    ->maxLength(65535),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->getStateUsing(function ($record) {
                        return $record->donationRequest->firstName . ' ' . $record->donationRequest->lastName;
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('requestAmount'),
                Tables\Columns\TextColumn::make('amountPaid'),
                Tables\Columns\TextColumn::make('requestDate')
                    ->label('Paid on')
                    ->date()
                    ->searchable(),
                Tables\Columns\TextColumn::make('donationRequest.email')
                    ->searchable()
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('donationRequest.phoneNumber')
                    ->toggleable()->toggledHiddenByDefault()
                    ->label('Phone Number'),
                Tables\Columns\TextColumn::make('checkOutRequestID')
                ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('merchantTransactionID')
                    ->toggleable()->toggledHiddenByDefault()
                    ->label('Merchant ID'),
                Tables\Columns\TextColumn::make('requestStatusCode')
                ->toggleable()
                    ->toggledHiddenByDefault(),
                BadgeColumn::make('requestStatusDescription')->label('Request Status')
                    ->searchable()
                    ->tooltip('Click the filter icon to filter by request')
                    ->colors([
                        'success' => 'Request fully paid',
                        'danger' => 'Request Pending Payment',
                    ]),
                Tables\Columns\TextColumn::make('MSISDN')
                ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('serviceCode')
                ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('accountNumber')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('currencyCode')
                    ->label('Currency'),
                Tables\Columns\TextColumn::make('requestCurrencyCode')
                ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('payments')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('creation_date')
                    ->dateTime()->toggleable()->toggledHiddenByDefault()->tooltip('Click the filter icon to filter by date')
,
                Tables\Columns\TextColumn::make('last_update')
                    ->dateTime()->toggleable()->toggledHiddenByDefault(),
            ])
            ->filters([

                SelectFilter::make('requestStatusDescription')
                    ->options([
                        'request fully paid' => 'Request fully paid',
                        'request partly paid' => 'Request partly paid',
                        'request not paid' => 'Request not paid',
                    ]),
                    SelectFilter::make('currencyCode')
                    ->options([
                        'kes' => 'KES',
                        'usd' => 'USD',
                    ]),
                DateFilter::make('requestDate')
                    ->useColumn('requestDate'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            DonationrequestRelationManager::class,
        ];
    }


    public static function getWidgets(): array
    {
        return [CellulantResponseRequestResource\Widgets\StatsOverview::class
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCellulantResponseRequests::route('/'),
            'create' => Pages\CreateCellulantResponseRequest::route('/create'),
            'view' => Pages\ViewCellulantResponseRequest::route('/{record}'),
            'edit' => Pages\EditCellulantResponseRequest::route('/{record}/edit'),
        ];
    }
}
