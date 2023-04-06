<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VcrunRegistrationResource\Widgets\StatsOverview;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Filters\SelectFilter;
use Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use App\Models\VcrunRegistration;
use App\Filament\Resources\VcrunRegistrationResource\Pages;
use App\Filament\Resources\VcrunRegistrationResource\RelationManagers;

class VcrunRegistrationResource extends Resource
{
    protected static ?string $model = VcrunRegistration::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $navigationGroup = 'Vice Chancellor\'s Run';

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
                    Tables\Columns\TextColumn::make('request_merchant_id')
                    ->label('Merchant ID')
                    ->toggleable()->toggledHiddenByDefault(),
                    Tables\Columns\TextColumn::make('participation_type')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('race_kms')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('registration_amount')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('status'),
                    Tables\Columns\TextColumn::make('matching_donor_id')
                    ->toggleable()->toggledHiddenByDefault(),
                    Tables\Columns\TextColumn::make('matched_amount')
                    ->toggleable()->toggledHiddenByDefault(),
                    Tables\Columns\TextColumn::make('created_at')
                    ->toggleable()->toggledHiddenByDefault(),
                    Tables\Columns\TextColumn::make('updated_at')
                    ->toggleable()->toggledHiddenByDefault(),
                    Tables\Columns\TextColumn::make('paid_amount'),
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

                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
