<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class WelcomeBanner extends Widget
{
    protected string $view = 'filament.widgets.welcome-banner';
    protected static ?int $sort = 0;
    protected int | string | array $columnSpan = 'full';

    public function getUserName(): string
    {
        return Auth::user()?->name ?? 'Administrator';
    }
}
