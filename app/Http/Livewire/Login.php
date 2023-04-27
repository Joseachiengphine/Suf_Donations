<?php

namespace App\Http\Livewire;

use Adldap\Auth\BindException;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Login extends \Filament\Http\Livewire\Auth\Login
{
    public $username = '';


    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            throw ValidationException::withMessages([
                'username' => __('filament::login.messages.throttled', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]),
            ]);
        }

        $data = $this->form->getState();
        try {
            if (is_numeric($data['username'])) {
                // This is a student
                config(['ldap.connections.default' => config('ldap.connections.students')]);

                // If you want to temporarily use the inbuilt authentication instead of ldap
                // config(['auth.guards.web.provider' => 'users'])
            } elseif (filter_var($data['username'], FILTER_VALIDATE_EMAIL)) {
                config(['auth.guards.web.provider' => 'users']);
            }
            if (config('auth.guards.web.provider') == 'users') {

                if (! Filament::auth()->attempt([
                    'email' => $data['username'],
                    'password' => $data['password'],
                ], $data['remember'])) {

                    throw ValidationException::withMessages([
                        'username' => __('filament::login.messages.failed'),
                    ]);
                }
            } else {
                if (!Filament::auth()->attempt([
                    'username' => $data['username'],
                    'password' => $data['password'],
                ], $data['remember'])) {
                    throw ValidationException::withMessages([
                        'username' => __('filament::login.messages.failed'),
                    ]);
                }
            }
        } catch (BindException $exception) {
            throw ValidationException::withMessages([
                'username' =>$exception->getMessage(),
            ]);
        } catch (\Throwable $exception) {
            throw ValidationException::withMessages([
                'username' =>$exception->getMessage(),
            ]);
        }

        return app(LoginResponse::class);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('username')
                ->required()
                ->autocomplete(),
            TextInput::make('password')
                ->label(__('filament::login.fields.password.label'))
                ->password()
                ->required(),
            Checkbox::make('remember')
                ->label(__('filament::login.fields.remember.label')),
        ];
    }
}
