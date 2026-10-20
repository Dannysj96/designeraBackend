<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\User;
use App\Models\UserPlanHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AssignDefaultFreePlanToUser
{
    public function assign(User $user): User
    {
        return $this->activateFreePlan($user, false, 'Default free plan assigned on account creation');
    }

    public function assignAfterExpiry(User $user): User
    {
        return $this->activateFreePlan($user, true, 'Free plan activated after previous plan expiry');
    }

    private function activateFreePlan(User $user, bool $replaceActivePlan, string $notes): User
    {
        return DB::transaction(function () use ($user, $replaceActivePlan, $notes): User {
            $lockedUser = User::query()->lockForUpdate()->find($user->id);

            if (! $lockedUser) {
                return $user;
            }

            if (! $replaceActivePlan && $lockedUser->activePlanHistory()->exists()) {
                return $lockedUser;
            }

            $freePlanQuery = Plan::query()
                ->whereRaw('LOWER(name) = ?', ['free'])
                ->where('price', 0)
                ->where('status', 1)
                ->where('is_display', 1);

            if (! $replaceActivePlan && $lockedUser->plan_id) {
                $freePlanQuery->whereKey($lockedUser->plan_id);
            }

            $freePlan = $freePlanQuery->first();

            if (! $freePlan) {
                return $lockedUser;
            }

            if ($replaceActivePlan) {
                $lockedUser->planHistories()->where('status', 'active')->update(['status' => 'expired']);
            }

            $durationDays = max(1, (int) ($freePlan->getRawOriginal('duration')
                ?? $freePlan->getRawOriginal('duration_days')
                ?? 1));
            $startDate = now();
            $endDate = $startDate->copy()->addDays($durationDays);
            $dailyDesignLimit = (int) $freePlan->daily_limit_design;
            $dailyVideoLimit = (int) $freePlan->daily_limit_video;

            $lockedUser->forceFill([
                'plan_id' => (string) $freePlan->id,
                'start_date' => $startDate->toDateString(),
                'expiry_date' => $endDate->toDateString(),
                'plan_expired' => false,
            ])->save();

            $userLimits = [];
            foreach ([
                'daily_download_limit_design' => $dailyDesignLimit,
                'design_daily_download_limit' => $dailyDesignLimit,
                'daily_download_limit_video' => $dailyVideoLimit,
                'video_daily_download_limit' => $dailyVideoLimit,
            ] as $column => $value) {
                if (Schema::hasColumn('users', $column)) {
                    $userLimits[$column] = $value;
                }
            }

            if ($userLimits !== []) {
                DB::table('users')->where('id', $lockedUser->id)->update($userLimits);
            }

            UserPlanHistory::create([
                'user_id' => $lockedUser->id,
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
                'notes' => $notes,
            ]);

            return $lockedUser->fresh(['plan', 'activePlanHistory']) ?? $lockedUser;
        });
    }
}
