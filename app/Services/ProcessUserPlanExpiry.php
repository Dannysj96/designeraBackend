<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProcessUserPlanExpiry
{
    public function __construct(private readonly AssignDefaultFreePlanToUser $freePlanAssigner) {}

    public function processIfExpired(User $user): bool
    {
        if (! $this->hasExpiredPlan($user)) {
            return false;
        }

        return DB::transaction(function () use ($user): bool {
            $lockedUser = User::query()->lockForUpdate()->find($user->id);

            if (! $lockedUser || ! $this->hasExpiredPlan($lockedUser)) {
                return false;
            }

            if (! $lockedUser->plan_id && ! $lockedUser->planHistories()->exists()) {
                return false;
            }

            $previousPlanId = (string) $lockedUser->plan_id;
            $previousExpiryDate = $lockedUser->expiry_date?->toDateString();
            $previousHistoryId = $lockedUser->activePlanHistory?->id;
            $updatedUser = $this->freePlanAssigner->assignAfterExpiry($lockedUser);

            return (string) $updatedUser->plan_id !== $previousPlanId
                || $updatedUser->expiry_date?->toDateString() !== $previousExpiryDate
                || $updatedUser->activePlanHistory?->id !== $previousHistoryId;
        });
    }

    private function hasExpiredPlan(User $user): bool
    {
        $userExpiryPassed = $user->expiry_date && $user->expiry_date->copy()->endOfDay()->isPast();
        $activeHistory = $user->activePlanHistory;
        $historyExpiryPassed = $activeHistory?->end_date?->isPast() ?? false;

        return (bool) ($userExpiryPassed || $historyExpiryPassed);
    }
}
