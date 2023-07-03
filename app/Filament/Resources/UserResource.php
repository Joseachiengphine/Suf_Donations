<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\Widgets\UserOverview;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Pages\Page;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'SYSTEM USERS';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("User Details")
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('username')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->disabled(),

//                        Forms\Components\TextInput::make('password')
//                            ->password()
//                            ->required()
//                            ->maxLength(255)
//                            ->dehydrateStateUsing(static fn (null|string $state): null|string =>
//                            filled($state) ? Hash::make($state): null,
//                            )->required(static fn (Page $livewire): bool =>
//                                $livewire instanceof CreateUser,
//                            )->dehydrated(static fn (null|string $state): bool =>
//                            filled($state),
//                            )->label(static fn (Page $livewire): string =>
//                            ($livewire instanceof EditUser) ? 'New Password' : 'Password'
//                            ),
                    ])
                    ->columns(2)
                    ->inlineLabel(),


                Section::make("Assign Roles")->schema([
                    CheckboxList::make('roles')
                        ->relationship('roles','name'),
                     Forms\Components\Toggle::make('active')
                         ->required()
                ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('User')
                  ->searchable(),
                BadgeColumn::make('username')
                    ->colors([
                        'primary',
                    ])
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->sortable()
                    ->label('Roles')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->action(function($record, $column) {
                        $name = $column->getName();
                        $record->update([
                            $name => !$record->$name
                        ]);
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('email'),

            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
//                SelectFilter::make('roles.name')
//                ->relationship('roles', 'name')
//                ->multiple()
            ])
            ->actions([
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



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
//             'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
