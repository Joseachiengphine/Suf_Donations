<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use JeffGreco13\FilamentBreezy\Pages\MyProfile;

class Mypersonalprofile extends MyProfile
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.mypersonalprofile';

    protected function getUpdateProfileFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Item Details')->schema(
                [
            Forms\Components\TextInput::make('name')
                ->required()
                ->label(__('filament-breezy::default.fields.name')),
            Forms\Components\TextInput::make($this->loginColumn)
                ->required()
                ->email(fn () => $this->loginColumn === 'email')
                ->unique(config('filament-breezy.user_model'), ignorable: $this->user)
                ->label(__('filament-breezy::default.fields.email')),
                    ])
        ];
    }
}
