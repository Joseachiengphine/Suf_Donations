<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Resources\Resource;
use App\Models\VcrunRegistration;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\VcrunRegistrationResource\Pages;
use App\Filament\Resources\VcrunRegistrationResource\RelationManagers;
use App\Filament\Resources\VcrunRegistrationResource\Widgets\StatsOverview;
use Illuminate\Database\Eloquent\Builder;
use Webbingbrasil\FilamentDateFilter\DateFilter;

class VcrunRegistrationResource extends Resource
{
    protected static ?string $model = VcrunRegistration::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $navigationGroup = 'Vice Chancellor\'s Run';


    protected function gettablequery(): Builder
    {
        return VcrunRegistration::query()
            ->select('vcrun_registrations.*','donation_requests.firstName', 'donation_requests.lastName', 'donation_requests.email', 'donation_requests.phoneNumber','donation_requests.currency','donation_requests.relation')
            ->leftJoin('donation_requests','vcrun_registrations.request_merchant_id', '=','donation_requests.merchantID');
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
                            if ($record->donationRequest) {
                                return $record->donationRequest->firstName . ' ' . $record->donationRequest->lastName;
                            }
                            return '';
                        })
                        ->default('--'),
                    BadgeColumn::make('donationRequest.relation')
                        ->label('Relation')
                        ->colors([
                        ])
                        ->default('--'),
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
                        ->label('Paid on')
                        ->sortable(),
                    BadgeColumn::make('status')
                        ->tooltip('Click the filter icon to filter by payment status')
                        ->colors([
                            'success' => 'PAID',
                            'danger' => 'PENDING',
                        ])
                        ->sortable(),

                    Tables\Columns\TextColumn::make('donationRequest.phoneNumber')
                        ->label('Phone Number')
                        ->toggleable()->toggledHiddenByDefault(),
                    Tables\Columns\TextColumn::make('currency')
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
                    Tables\Columns\TextColumn::make('donationRequest.email')
                        ->label('Email')
                        ->searchable()
                        ->toggleable()
                        ->toggledHiddenByDefault(),
                    Tables\Columns\TextColumn::make('matching_donor_id')
                    ->toggleable()->toggledHiddenByDefault(),
                    Tables\Columns\TextColumn::make('matched_amount')
                    ->toggleable()->toggledHiddenByDefault(),
                    Tables\Columns\TextColumn::make('updated_at')
                    ->toggleable()->toggledHiddenByDefault(),
                ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'paid' => 'Paid',
                        'pending' => 'Pending',

                    ])
                    ->searchable(),
                SelectFilter::make('participation_type')
                    ->options([
                        'physical' => 'Physical',
                        'virtual' => 'Virtual',

                    ])
                    ->searchable(),

//                SelectFilter::make('relation')
//                    ->relationship('donationRequest', 'relation')
//                    ->options([
//                        'alumni' => 'Alumni',
//                        'friend' => 'Friend',
//                        'other' => 'Other',
//                        'parent' => 'Parent',
//                        'referred by zoezi maisha' => 'Referred By Zoezi Maisha',
//                        'staff' => 'Staff',
//                        'student' => 'Student',
//                    ]),
                DateFilter::make('created_at')
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
        return [
            StatsOverview::class
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVcrunRegistrations::route('/'),
//            'create' => Pages\CreateVcrunRegistration::route('/create'),
            'view' => Pages\ViewVcrunRegistrations::route('/{record}'),
//            'edit' => Pages\EditVcrunRegistration::route('/{record}/edit'),
        ];
    }
}
