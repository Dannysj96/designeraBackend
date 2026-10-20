<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\ProcessUserPlanExpiry;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('plans:process-expired')]
#[Description('Move expired plans to the active Free plan and renew expired Free plans.')]
class ProcessExpiredPlans extends Command
{
    public function handle(ProcessUserPlanExpiry $planExpiry): int
    {
        $processed = 0;

        User::query()
            ->where(function ($query): void {
                $query->where(function ($query): void {
                    $query->whereNotNull('expiry_date')
                        ->whereDate('expiry_date', '<', today()->toDateString());
                })->orWhereHas('activePlanHistory', function ($query): void {
                    $query->whereNotNull('end_date')->where('end_date', '<=', now());
                });
            })
            ->where(function ($query): void {
                $query->whereNotNull('plan_id')->orWhereHas('planHistories');
            })
            ->chunkById(100, function ($users) use ($planExpiry, &$processed): void {
                foreach ($users as $user) {
                    if ($planExpiry->processIfExpired($user)) {
                        $processed++;
                    }
                }
            });

        $this->info("Processed {$processed} expired plan(s).");

        return self::SUCCESS;
    }
}
