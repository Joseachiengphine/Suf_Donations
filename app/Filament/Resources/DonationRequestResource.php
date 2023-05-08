<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\DonationRequest;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Webbingbrasil\FilamentDateFilter\DateFilter;
use App\Filament\Resources\DonationRequestResource\Pages;
use App\Filament\Resources\DonationRequestResource\Widgets\StatsOverview;


class DonationRequestResource extends Resource
{
    protected static ?string $model = DonationRequest::class;

    protected static ?string $recordTitleAttribute = 'email';

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
                            ]),
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
                            ]),
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
                            ]),
                //Forms\Components\TextInput::make('currency')
                    //->required()
                    //->maxLength(3),
                Forms\Components\Fieldset::make('Request Dates')
                            ->schema([
                Forms\Components\DateTimePicker::make('creation_date')
                    ->required(),
                Forms\Components\DateTimePicker::make('last_update')
                    ->required(),
                            ]),
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
                    ]),
                    ]

                )

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('merchantID')
                    ->label('Merchant ID')
                    ->searchable()
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('firstName')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lastName')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phoneNumber')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('email')
                    ->toggleable()->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('zipCode')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('currency')
                    ->searchable()
                    ->toggleable()
                    ->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('cellulantresponserequest.requestAmount')
                    ->label('To Pay'),
                Tables\Columns\TextColumn::make('cellulantresponserequest.amountPaid')
                    ->label('Amount Paid'),
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
                    ->dateTime()->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('last_update')
                    ->dateTime()->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('job_title')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('graduation_class')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('campaign'),
                Tables\Columns\TextColumn::make('relation')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('student_number')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('shirt_size')
                    ->toggleable()->toggledHiddenByDefault(),
            ])
            ->filters([
                SelectFilter::make('campaign')
                    ->multiple()
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
                DateFilter::make('creation_date')
                    ->useColumn('creation_date'),


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
            'create' => Pages\CreateDonationRequest::route('/create'),
            'view' => Pages\ViewDonationRequest::route('/{record}'),
            'edit' => Pages\EditDonationRequest::route('/{record}/edit'),
        ];
    }
}
