<?php

namespace App\Filament\Resources;

use App\Models\CellulantResponseRequest;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use App\Models\VcrunRegistration;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\VcrunRegistrationResource\Pages;
use App\Filament\Resources\VcrunRegistrationResource\RelationManagers;
use App\Filament\Resources\VcrunRegistrationResource\Widgets\StatsOverview;

class VcrunRegistrationResource extends Resource
{
    protected static ?string $model = VcrunRegistration::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $navigationGroup = 'Vice Chancellor\'s Run';


    protected function gettablequery(): \Illuminate\Database\Eloquent\Builder
    {
        return VcrunRegistration::query()
            ->select('vcrun_registrations.*','donation_requests.firstName as firstName', 'donation_requests.lastName', 'donation_requests.email', 'donation_requests.phoneNumber','donation_requests.currency')
            ->Join('donation_requests','vcrun_registrations.request_merchant_id', '=','donation_requests.merchantID');
    }

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Section::make('VICE CHANCELLOR\'S RUN REGISTRATIONS')->schema(
                [
                    Forms\Components\Fieldset::make('Payment Details')
                        ->schema([
                            Forms\Components\TextInput::make('request_merchant_id')
                                ->label('Merchant ID')
                                ->required()
                                ->maxLength(50),
                            Forms\Components\TextInput::make('registration_amount')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('paid_amount')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('status')
                                ->maxLength(255),

                        ]),
                    Forms\Components\Fieldset::make('Request Dates')
                        ->schema([
                            Forms\Components\DateTimePicker::make('created_at')
                                ->required(),
                            Forms\Components\DateTimePicker::make('updated_at')
                                ->required(),
                        ]),
                    Forms\Components\Fieldset::make('Race Details')
                        ->schema([
                            Forms\Components\TextInput::make('participation_type')
                                ->required()
                                ->maxLength(50),
                            Forms\Components\TextInput::make('race_kms')
                                ->required()
                                ->maxLength(50),
                        ]),
                    Forms\Components\Fieldset::make('Matched Donor')
                        ->schema([
                            Forms\Components\TextInput::make('matching_donor_id')
                                ->required()
                                ->maxLength(50),
                            Forms\Components\TextInput::make('matched_amount')
                                ->required()
                                ->maxLength(50),
                        ]),
                ]
            )
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
                ->columns([
                    Tables\Columns\TextColumn::make('name')
                        ->label('Name')
                        ->getStateUsing(function ($record) {
                            if ($record->DonationRequest) {
                                return $record->DonationRequest->firstName . ' ' . $record->DonationRequest->lastName;
                            }
                            return '';
                        })
                        ->searchable(),
                    BadgeColumn::make('DonationRequest.relation')
                        ->label('Relation')
                        ->colors([
                        ]),
                    Tables\Columns\TextColumn::make('registration_amount')
                        ->alignRight('true')
                        ->label('Reg. Amount')
                        ->tooltip('Registration Amount')
                        ->searchable()
                        ->toggleable()
                        ->toggledHiddenByDefault()
                        ->money('KES', '1'),
                    Tables\Columns\TextColumn::make('paid_amount')
                        ->alignRight('true')
                        ->money('KES', '1'),
                    Tables\Columns\TextColumn::make('created_at')
                        ->date()
                        ->label('Paid on'),
                    BadgeColumn::make('status')
                        ->tooltip('Click the filter icon to filter by payment status')
                        ->colors([
                            'success' => 'PAID',
                            'danger' => 'PENDING',
                        ])
                        ->sortable(),

                    Tables\Columns\TextColumn::make('DonationRequest.phoneNumber')
                        ->label('Phone Number')
                        ->toggleable()->toggledHiddenByDefault(),
                    Tables\Columns\TextColumn::make('currency')
                        ->searchable()
                        ->toggleable()->toggledHiddenByDefault(),
                    Tables\Columns\TextColumn::make('request_merchant_id')
                    ->label('Merchant ID')
                    ->toggleable()->toggledHiddenByDefault(),
                    BadgeColumn::make('participation_type')
                        ->tooltip('Click the filter icon to filter by participation type')
                        ->colors([
                            'primary' => 'PHYSICAL',
                            'secondary' => 'VIRTUAL',
                        ]),
                    Tables\Columns\TextColumn::make('race_kms')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('DonationRequest.email')
                        ->label('Email')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('matching_donor_id')
                    ->toggleable()->toggledHiddenByDefault(),
                    Tables\Columns\TextColumn::make('matched_amount')
                    ->toggleable()->toggledHiddenByDefault(),
                    Tables\Columns\TextColumn::make('updated_at')
                    ->toggleable()->toggledHiddenByDefault(),
                ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'paid' => 'Paid',
                        'pending' => 'Pending',

                    ]),
                SelectFilter::make('participation_type')
                    ->options([
                        'physical' => 'Physical',
                        'virtual' => 'Virtual',

                    ]),
//                Filter::make('created_at')
//                    ->form([
//                        Forms\Components\DatePicker::make('From_Date'),
//                        Forms\Components\DatePicker::make('To_date')->afterOrEqual('From_Date'),
//                    ])
//                    ->query(function (Builder $query, array $data): Builder {
//                        return $query
//                            ->when(
//                                $data['From_Date'],
//                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
//                            )
//                            ->when(
//                                $data['To_date'],
//                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
//                            );
//                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

            ])
            ->bulkActions([
               // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }



    public static function getWidgets(): array
    {
        return [StatsOverview::class
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVcrunRegistrations::route('/'),
            'create' => Pages\CreateVcrunRegistration::route('/create'),
            'view' => Pages\ViewVcrunRegistrations::route('/{record}'),
            'edit' => Pages\EditVcrunRegistration::route('/{record}/edit'),
        ];
    }
}
