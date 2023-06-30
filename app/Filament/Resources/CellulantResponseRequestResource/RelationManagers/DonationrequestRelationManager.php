<?php

namespace App\Filament\Resources\CellulantResponseRequestResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class DonationrequestRelationManager extends RelationManager
{
    protected static string $relationship = 'DonationRequest';

    protected static ?string $recordTitleAttribute = 'merchantID';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
        Forms\Components\Fieldset::make('Donation Request Details')
                ->schema([
        Forms\Components\TextInput::make('merchantID')
        ->label('Merchant ID')
        ->required()
        ->maxLength(255),
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
            ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Name')
                    ->getStateUsing(function (Model $record){
                        return $record->firstName . ' ' . $record->lastName;
                    }),
                BadgeColumn::make('relation')
                    ->colors([
                    ])
                    ->default('--'),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                BadgeColumn::make('campaign')
                    ->colors([
                        'primary',
                    ])
                    ->default('--'),
                Tables\Columns\TextColumn::make('phoneNumber')
                    ->default('--'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
//                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }
}
