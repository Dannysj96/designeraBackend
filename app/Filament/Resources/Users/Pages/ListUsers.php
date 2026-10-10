<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserPlanHistory;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Livewire\Attributes\Renderless;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected string $view = 'filament.resources.users.pages.list-users';

    public ?int $selectedUserId = null;
    public string $selectedUserName = '';
    public array $userPlanHistories = [];

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('New User'),
        ];
    }

    public function getPlansProperty()
    {
        return Plan::query()
            ->where('status', 'active')
            ->orderBy('price')
            ->get();
    }

    public function getUsersProperty()
    {
        return User::with(['plan', 'activePlanHistory', 'planHistories'])->latest()->get();
    }

    public function toggleStatus(int $id): void
    {
        $user = User::find($id);
        if (! $user) {
            return;
        }

        $newStatus = ($user->status === 'active') ? 'suspended' : 'active';
        $user->update(['status' => $newStatus]);

        Notification::make()
            ->title("User status changed to '{$newStatus}'")
            ->success()
            ->send();
    }

    public function resetPassword(int $id): void
    {
        $user = User::find($id);
        if (! $user) {
            return;
        }

        $user->update(['password' => bcrypt('password123')]);

        Notification::make()
            ->title("Password reset to 'password123' for {$user->name}")
            ->success()
            ->send();
    }

    public function addMoney(int $id, float $amount, string $note = ''): void
    {
        $user = User::find($id);
        if (! $user) return;

        $newBal = ($user->wallet_balance ?? 0) + $amount;
        $user->update(['wallet_balance' => $newBal]);

        Notification::make()
            ->title("Added ₹{$amount} to {$user->name}'s wallet. New Balance: ₹{$newBal}")
            ->success()
            ->send();
    }

    public function removeMoney(int $id, float $amount, string $note = ''): void
    {
        $user = User::find($id);
        if (! $user) return;

        $currentBal = $user->wallet_balance ?? 0;
        $newBal = max(0, $currentBal - $amount);
        $user->update(['wallet_balance' => $newBal]);

        Notification::make()
            ->title("Deducted ₹{$amount} from {$user->name}'s wallet. New Balance: ₹{$newBal}")
            ->warning()
            ->send();
    }

    #[Renderless]
    public function loadPlanHistory(int $id): void
    {
        $user = User::with(['plan', 'planHistories.plan'])->find($id);
        if (! $user) return;

        $histories = $user->planHistories->map(function ($h) {
            return [
                'id' => $h->id,
                'plan_name' => $h->plan_name,
                'price' => (float) $h->price,
                'duration_days' => $h->duration_days,
                'start_date' => $h->start_date ? $h->start_date->format('d M Y, h:i A') : '—',
                'end_date' => $h->end_date ? $h->end_date->format('d M Y, h:i A') : '—',
                'status' => $h->status,
                'remaining_days' => $h->remaining_days,
                'daily_limit_design' => $h->daily_limit_design,
                'daily_limit_video' => $h->daily_limit_video,
                'payment_method' => $h->payment_method ?? 'Admin',
                'notes' => $h->notes ?? '',
                'created_at' => $h->created_at ? $h->created_at->format('d M Y, h:i A') : '',
            ];
        })->toArray();

        $this->dispatch('open-plan-history-modal', [
            'userId' => $user->id,
            'userName' => $user->name,
            'currentPlan' => $user->plan?->name ?? ($user->plan_id ? 'Plan #' . $user->plan_id : 'Free Trial'),
            'wallet' => $user->wallet_balance ?? 0,
            'histories' => $histories,
        ]);
    }

    public function upgradePlan(int $id, $planId, string $note = '', ?int $customDays = null): void
    {
        $user = User::find($id);
        if (! $user) return;

        $plan = Plan::find($planId);
        $planName = $plan ? $plan->name : ($planId ?: 'Custom Plan');
        $duration = (int) ($customDays ?? ($plan ? ($plan->duration ?: $plan->duration_days ?: 30) : 30));
        $price = $plan ? (float) $plan->price : 0.00;
        $limitDesign = $plan ? (int) $plan->daily_limit_design : ($user->daily_download_limit_design ?? 0);
        $limitVideo = $plan ? (int) $plan->daily_limit_video : ($user->daily_download_limit_video ?? 0);

        // Mark previously active plans as upgraded
        UserPlanHistory::where('user_id', $user->id)
            ->where('status', 'active')
            ->update(['status' => 'upgraded']);

        $startDate = now();
        $endDate = (clone $startDate)->addDays($duration);

        // Record plan history
        UserPlanHistory::create([
            'user_id' => $user->id,
            'plan_id' => $plan ? $plan->id : null,
            'plan_name' => $planName,
            'price' => $price,
            'duration_days' => $duration,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
            'daily_limit_design' => $limitDesign,
            'daily_limit_video' => $limitVideo,
            'payment_method' => 'admin',
            'notes' => $note ?: 'Assigned / Upgraded by Admin',
        ]);

        // Update User
        $user->update([
            'plan_id' => $plan ? (string) $plan->id : (string) $planId,
            'daily_download_limit_design' => $limitDesign,
            'daily_download_limit_video' => $limitVideo,
        ]);

        Notification::make()
            ->title("Plan upgraded to '{$planName}' ({$duration} days) for {$user->name}")
            ->success()
            ->send();

        // Refresh modal history if this user is open
        if ($this->selectedUserId === $user->id) {
            $this->loadPlanHistory($user->id);
        }
    }

    public function deleteUser(int $id): void
    {
        if (auth()->id() === $id) {
            Notification::make()
                ->title('Cannot delete your own active account')
                ->danger()
                ->send();

            return;
        }

        User::find($id)?->delete();

        Notification::make()
            ->title('User deleted successfully')
            ->success()
            ->send();
    }
}
