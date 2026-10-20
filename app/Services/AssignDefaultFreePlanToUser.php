<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\User;
use App\Models\UserPlanHistory;
use Illuminate\Support\Facades\DB;

class AssignDefaultFreePlanToUser
{
    public function assign(User $user): User
    {
        return DB::transaction(function () use ($user): User {
            if ($user->activePlanHistory()->exists()) {
                return $user;
            }

            $freePlanQuery = Plan::query()
                ->whereRaw('LOWER(name) = ?', ['free'])
                ->where('price', 0)
                ->where('status', 1)
                ->where('is_display', 1);

            if ($user->plan_id) {
                $freePlanQuery->whereKey($user->plan_id);
            }

            $freePlan = $freePlanQuery->first();

            if (! $freePlan) {
                return $user;
            }

            $durationDays = max(1, (int) ($freePlan->duration ?? $freePlan->duration_days ?? 1));
            $startDate = now();
            $endDate = (clone $startDate)->addDays($durationDays);
            $dailyDesignLimit = (int) $freePlan->daily_limit_design;
            $dailyVideoLimit = (int) $freePlan->daily_limit_video;

            $user->forceFill([
                'plan_id' => (string) $freePlan->id,
                'daily_download_limit_design' => $dailyDesignLimit,
                'daily_download_limit_video' => $dailyVideoLimit,
            ])->save();

            UserPlanHistory::create([
                'user_id' => $user->id,
                'plan_id' => $freePlan->id,
                'plan_name' => $freePlan->name,
                'price' => $freePlan->price,
                'duration_days' => $durationDays,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'active',
                'daily_limit_design' => $dailyDesignLimit,
                'daily_limit_video' => $dailyVideoLimit,
                'payment_method' => 'free_trial',
                'notes' => 'Default free plan assigned on account creation',
            ]);

            return $user->fresh(['plan', 'activePlanHistory']) ?? $user;
        });
    }
}
