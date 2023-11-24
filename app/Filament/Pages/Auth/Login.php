<?php

namespace App\Filament\Pages\Auth;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Select;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Login as BaseAuth;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;


class Login extends BaseAuth
{

    public function getHeading(): string|Htmlable
    {
        return 'Sistema de gestão de Investimentos';
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent(),
                //$this->getLoginFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),

            ])
            ->statePath('data');
    }
  /*  protected function getLoginFormComponent(): Component 
    {
        return TextInput::make('name')
            ->label('Nome')
            ->required()
            ->autocomplete()
            ->autofocus();
    } 

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'name' => $data['name'],
            'password'  => $data['password'],
        ];

    }
*/
}
