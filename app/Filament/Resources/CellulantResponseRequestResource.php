<?php

namespace App\Filament\Resources;


use App\Filament\Resources\CellulantResponseRequestResource\Pages;
use App\Filament\Resources\CellulantResponseRequestResource\RelationManagers\DonationrequestRelationManager;
use App\Models\CellulantResponseRequest;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
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
                Tables\Columns\TextColumn::make('Paid by')
                    ->getStateUsing(function (Model $record) {
                        return ($record->DonationRequest->firstName ?? '') . ' ' . ($record->DonationRequest->lastName ?? '');
                    }),
                Tables\Columns\TextColumn::make('DonationRequest.email')
                    ->label('Email')
                    ->searchable(),
                BadgeColumn::make('donationrequest.relation')
                    ->label('Strathmore Relation')
                    ->colors([
                    ]),
                Tables\Columns\TextColumn::make('requestAmount')
                    ->alignRight('true')
                    ->money('KES', '1')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('amountPaid')
                    ->alignRight('true')
                    ->money('KES', '1'),
                Tables\Columns\TextColumn::make('DonationRequest.phoneNumber')
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
                    ->colors([
                        'success' => 'Request fully paid',
                    ]),
                Tables\Columns\TextColumn::make('creation_date')
                     ->date()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('last_update')
                    ->label('Paid on')
                    ->date()
                    ->searchable()
                    ->sortable()
                    ->tooltip('Click the filter icon to filter by date'),
                Tables\Columns\TextColumn::make('MSISDN')
                ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('serviceCode')
                ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('accountNumber')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('currencyCode')
                    ->label('Currency')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('requestCurrencyCode')
                ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('payments')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('requestDate')
                    ->dateTime()->toggleable()->toggledHiddenByDefault(),
                ])
                    ->defaultSort('last_update', 'desc')
        ->filters([
//                    SelectFilter::make('relation')
//                        ->relationship('donationrequest', 'relation')
//                        ->options([
//                            'alumni' => 'Alumni',
//                            'friend' => 'Friend',
//                            'other' => 'Other',
//                            'parent' => 'Parent',
//                            'referred by zoezi maisha' => 'Referred By Zoezi Maisha',
//                            'staff' => 'Staff',
//                            'student' => 'Student',
//                        ]),
                DateFilter::make('last_update')
                    ->label(__('Paid on'))
                    ->range()
                    ->fromLabel(__('From'))
                    ->untilLabel(__('Until'))
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
//                Tables\Actions\EditAction::make(),

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
//            'create' => Pages\CreateCellulantResponseRequest::route('/create'),
            'view' => Pages\ViewCellulantResponseRequest::route('/{record}'),
//            'edit' => Pages\EditCellulantResponseRequest::route('/{record}/edit'),
        ];
    }
}
