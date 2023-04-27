<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VcrunSupporterResource\Widgets\StatsOverview;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Models\VcrunSupporter;
use Filament\Resources\Resource;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VcrunSupporterResource\Pages;
use App\Filament\Resources\VcrunSupporterResource\RelationManagers;

class VcrunSupporterResource extends Resource
{
    protected static ?string $model = VcrunSupporter::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';


    protected static ?string $navigationGroup = 'Vice Chancellor\'s Run';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('VICE CHANCELLOR\'S RUN SUPPORTERS')->schema(
                    [
                        Forms\Components\Fieldset::make('Payment Details')
                            ->schema([
                                Forms\Components\TextInput::make('request_merchant_id')
                                    ->label('Merchant ID')
                                    ->required()
                                    ->maxLength(50),
                                Forms\Components\TextInput::make('supported_registrant_id')
                                    ->label('Supported Registrant ID')
                                    ->required()
                                    ->maxLength(50),
                                Forms\Components\TextInput::make('support_amount')
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
                        Forms\Components\Fieldset::make('Matched Donor')
                            ->schema([
                                Forms\Components\TextInput::make('matching_donor_id')
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
                Tables\Columns\TextColumn::make('donationRequest.firstName')
                    ->label('First Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('donationRequest.lastName')
                    ->label('Last Name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('donationRequest.email')
                    ->label('Email')
                    ->toggleable()->toggledHiddenByDefault()
                    ->searchable(),
                Tables\Columns\TextColumn::make('donationRequest.phoneNumber')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('supported_registrant_id')
                    ->searchable()
                    ->label('Merchant ID')
                    ->toggleable()->toggledHiddenByDefault(),
                Tables\Columns\TextColumn::make('request_merchant_id'),
                Tables\Columns\TextColumn::make('support_amount'),
                Tables\Columns\TextColumn::make('registration_amount')
                    ->toggleable()->toggledHiddenByDefault(),
                BadgeColumn::make('status')
                    ->colors([
                        'success' => 'PAID',
                        'danger' => 'PENDING',
                    ]),
                Tables\Columns\TextColumn::make('matching_donor_id')
                    ->toggleable()->toggledHiddenByDefault(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'paid' => 'Paid',
                        'pending' => 'Pending',

                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
              //  Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListVcrunSupporters::route('/'),
            'create' => Pages\CreateVcrunSupporter::route('/create'),
            'view' => Pages\ViewVcrunSupporter::route('/{record}'),
            'edit' => Pages\EditVcrunSupporter::route('/{record}/edit'),
        ];
    }
}
