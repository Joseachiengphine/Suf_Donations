<?php

namespace App\Http\Livewire;

use Adldap\Auth\BindException;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

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
            }
            else {
                if (!Filament::auth()->attempt([
                    'username' => $data['username'],
                    'password' => $data['password'],
                ], $data['remember'])) {
                    throw ValidationException::withMessages([
                        'username' => __('filament::login.messages.failed'),
                    ]);
                }
            }

            Notification::make()
                ->title('Welcome to the Strathmore University Foundation Admin Panel!')

                ->body('Welcome, Admin. As an admin, you now have access to view Cellulant Responses, Donation Requests, VCRUN Registration, and VCRUN Supporter Information. <br><br><strong>Please note that this content is for viewing purposes only and provides an overview of the different donations made for the various campaigns at Strathmore.</strong><br><br>
            <ol style="font-size: 12px">
        <li>To help you navigate the system more efficiently, please use the sidebar on the left to access the dashboard. You can also collapse it to view content more comfortably.</li><br>
        <li>Depending on your assigned permissions, you can view specific content and generate reports that can be downloaded in various formats.</li><br>
        <li> We hope you find the Strathmore University Foundation admin panel useful and easy to use.</li><br>
        <li>Please enjoy using the panel, and if you have any questions or concerns, please don\'t hesitate to contact our support team.</li><br>
        </ol>
        ')
                ->success()
                ->persistent()
                ->send();

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
