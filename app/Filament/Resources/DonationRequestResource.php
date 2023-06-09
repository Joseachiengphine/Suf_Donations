<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\DonationRequest;
use Filament\Resources\Resource;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\DonationRequestResource\Pages;
use App\Filament\Resources\DonationRequestResource\Widgets\StatsOverview;
use Webbingbrasil\FilamentDateFilter\DateFilter;


class DonationRequestResource extends Resource
{
    protected static ?string $model = DonationRequest::class;

    protected static ?string $recordTitleAttribute = 'firstName';

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationGroup = 'FOUNDATION DONATIONS';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('FOUNDATION DONATION REQUESTS')->schema(
                    [
                        Forms\Components\Fieldset::make('Donation Details')
                            ->schema([
                Forms\Components\TextInput::make('merchantID')
                    ->label('Merchant ID')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('campaign')
                    ->maxLength(255),
                            ])
                            ->columns(2)
                            ->inlineLabel(),
                        Forms\Components\Fieldset::make('User Details')
                            ->schema([
                Forms\Components\TextInput::make('salutation')
                    ->required()
                    ->maxLength(6),
                Forms\Components\TextInput::make('firstName')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('lastName')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('phoneNumber')
                    ->tel()
                    ->required()
                    ->maxLength(15),
                Forms\Components\TextInput::make('graduation_class')
                    ->maxLength(60),
                Forms\Components\TextInput::make('company')
                    ->maxLength(70),
                Forms\Components\TextInput::make('job_title')
                    ->maxLength(150),
                            ])
                            ->columns(2)
                            ->inlineLabel(),
                Forms\Components\Fieldset::make('Location Details')
                            ->schema([
                Forms\Components\TextInput::make('country')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('zipCode')
                    ->required()
                    ->maxLength(50),
                            ])
                    ->columns(2)
                    ->inlineLabel(),
                //Forms\Components\TextInput::make('currency')
                    //->required()
                    //->maxLength(3),
                Forms\Components\Fieldset::make('Request Dates')
                            ->schema([
                Forms\Components\DateTimePicker::make('creation_date')
                    ->required(),
                Forms\Components\DateTimePicker::make('last_update')
                    ->required(),
                            ])
                    ->columns(2)
                    ->inlineLabel(),
                Forms\Components\Textarea::make('requestDescription')
                    ->required()
                    ->maxLength(65535),
                        Forms\Components\Fieldset::make('Matched Recipient')
                            ->schema([
                Forms\Components\TextInput::make('relation')
                    ->maxLength(255),
                Forms\Components\TextInput::make('student_number')
                    ->maxLength(191),
                Forms\Components\TextInput::make('shirt_size')
                    ->maxLength(191),
//                Fieldset::make('requestAmount')
//                    ->label('Request Amount')
//                    ->relationship('requestAmount')
//                    ->schema([
//                        TextInput::make('requestAmount'),
//                                  ]),
                    ])
                            ->columns(2)
                            ->inlineLabel(),
                    ]

                )

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Requested by')
                    ->getStateUsing(function (Model $record){
                        return $record->firstName . ' ' . $record->lastName;
                    }),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                BadgeColumn::make('relation')
                    ->label('Strathmore relation')
                    ->colors([
                    ]),
                Tables\Columns\TextColumn::make('country')
                    ->toggleable()->toggledHiddenByDefault()
                    ->searchable(),
                BadgeColumn::make('campaign')
                    ->colors([
                        'primary',
                    ])
                    ->default('--')
                    ->tooltip('Click the filter icon to filter by campaign'),
                Tables\Columns\TextColumn::make('CellulantResponseRequest.requestAmount')
                    ->alignRight('true')
                    ->label('Request Amount')
                    ->money('KES', '1')
                    ->default('0'),
                Tables\Columns\TextColumn::make('CellulantResponseRequest.amountPaid')
                    ->alignRight('true')
                    ->label('Amount Paid')
                    ->money('KES', '1')
                    ->default('0')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('merchantID')
                    ->label('Merchant ID')
                    ->searchable()
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('phoneNumber')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('city')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('zipCode')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('currency')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('company')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('salutation')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('phoneNumber')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('requestDescription')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('creation_date')
                    ->label('Requested on')
                    ->tooltip('Click the filter icon to filter by date')
                    ->date(),
                Tables\Columns\TextColumn::make('last_update')
                    ->date()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('job_title')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('graduation_class')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('shirt_size')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
            ])
                   ->defaultSort('creation_date', 'desc')
            ->filters([
                SelectFilter::make('campaign')
                    ->options([
                        'elimisha stratizen' => 'Elimisha Stratizen',
                        'lisha mkenya' => 'Lisha Mkenya',
                        'macheo' => 'Macheo',
                        'professional chairs & research center' => 'Professional Chairs & Research Center',
                        'scholarship' => 'Scholarship',
                        'student support' => 'Student Support',
                        'Vice Chancellor\'s Run' => 'Vice Chancellor\'s Run',
                        'other' => 'Other',
                    ]),
                SelectFilter::make('relation')
                    ->options([
                        'alumni' => 'Alumni',
                        'friend' => 'Friend',
                        'other' => 'Other',
                        'parent' => 'Parent',
                        'referred by zoezi maisha' => 'Referred By Zoezi Maisha',
                        'staff' => 'Staff',
                        'student' => 'Student',
                    ]),
//                DateFilter::make('last_update'),
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
               // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [

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
            'index' => Pages\ListDonationRequests::route('/'),
//            'create' => Pages\CreateDonationRequest::route('/create'),
            'view' => Pages\ViewDonationRequest::route('/{record}'),
//            'edit' => Pages\EditDonationRequest::route('/{record}/edit'),
        ];
    }
}
