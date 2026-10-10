<?php

namespace App\Filament\Pages;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin
{
    protected string $view = 'filament.pages.login';

    public function getHeading(): string | Htmlable
    {
        return 'Admin Login';
    }

    public function getTitle(): string | Htmlable
    {
        return 'Admin Login';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
            ]);
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('Email')
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus()
            ->prefixIcon('heroicon-m-envelope')
            ->placeholder('Enter your email')
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label('Password')
            ->hint(filament()->hasPasswordReset() ? fn () => $this->getPasswordResetLink() : null)
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->prefixIcon('heroicon-m-lock-closed')
            ->placeholder('Enter your password')
            ->extraInputAttributes(['tabindex' => 2]);
    }
}
