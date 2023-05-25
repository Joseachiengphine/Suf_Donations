<?php
/*
namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;


class MyProfile extends \JeffGreco13\FilamentBreezy\Pages\MyProfile
{
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'SETTINGS';


    protected static string $view = 'filament.pages.my-profile';

    protected function getUpdateProfileFormSchema(): array
    {
        $formSchema = parent::getUpdateProfileFormSchema();
        return [
            Forms\Components\TextInput::make('name')
                ->required()
                ->label(__('filament-breezy::default.fields.name')),
            Forms\Components\TextInput::make($this->loginColumn)
                ->required()
                ->email(fn () => $this->loginColumn === 'email')
                ->unique(config('filament-breezy.user_model'), ignorable: $this->user)
                ->label(__('filament-breezy::default.fields.email')),
        ];
    }

}*/
