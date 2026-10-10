<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalUsers = User::count();
        $verifiedUsers = User::whereNotNull('email_verified_at')->count();
        $unverifiedUsers = $totalUsers - $verifiedUsers;
        $verificationRate = $totalUsers > 0 ? round(($verifiedUsers / $totalUsers) * 100) : 0;

        return [
            Stat::make('Total Users', number_format($totalUsers))
                ->description('All registered accounts')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([3, 5, 7, 6, 8, 10, max($totalUsers, 1)])
                ->color('primary'),

            Stat::make('Verified Accounts', "{$verificationRate}%")
                ->description("{$verifiedUsers} of {$totalUsers} verified")
                ->descriptionIcon('heroicon-m-check-badge')
                ->chart([20, 45, 60, 75, 90, max($verificationRate, 10)])
                ->color('success'),

            Stat::make('Pending Verification', number_format($unverifiedUsers))
                ->description('Awaiting email confirmation')
                ->descriptionIcon('heroicon-m-clock')
                ->chart([5, 4, 3, 2, 1, max($unverifiedUsers, 1)])
                ->color($unverifiedUsers > 0 ? 'warning' : 'gray'),
        ];
    }
}
