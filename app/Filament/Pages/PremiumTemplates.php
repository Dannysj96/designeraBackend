<?php

namespace App\Filament\Pages;

use App\Models\User;
use App\Models\UserPremiumTemplate;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class PremiumTemplates extends Page
{
    use WithFileUploads;

    protected string $view = 'filament.pages.premium-templates';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?int $navigationSort = 3;

    protected static ?string $title = 'Premium Templates';

    public ?int $userId = null;
    public ?User $selectedUser = null;

    // View mode: 'list', 'create', 'edit'
    public string $viewMode = 'list';

    // Form inputs for Create Template / Edit Template Page
    public bool $showModal = false;
    public ?int $editingId = null;
    public ?int $formUserId = null;
    public string $formFrameType = '';
    public string $formStatus = 'Active';
    public string $formCreatedDate = '';
    public int $formUpToDays = 30;
    public int $formExtraDays = 0;
    public int $extraDays = 0;
    public int $formMarginBottom = 0;
    public int $formMarginTop = 0;
    public int $formMarginLeft = 0;
    public int $formMarginRight = 0;
    public int $formDaysLeft = 0;
    public $formMiddleImage = null;
    public $formTopImage = null;
    public $formBottomImage = null;
    public ?string $existingMiddleImage = null;
    public ?string $existingTopImage = null;
    public ?string $existingBottomImage = null;

    public function mount(): void
    {
        $this->userId = request()->query('user_id') ? (int) request()->query('user_id') : null;
        if ($this->userId) {
            $this->selectedUser = User::find($this->userId);
            $this->formUserId = $this->userId;
        } else {
            $this->formUserId = User::first()?->id;
        }
        $this->formCreatedDate = date('Y-m-d');
        $this->extraDays = (int) ($this->selectedUser->extra_days ?? 0);

        $action = request()->query('action');
        $id = request()->query('id');

        if ($action === 'create') {
            $this->openCreatePage();
        } elseif ($action === 'edit' && $id) {
            $this->openEditPage((int) $id);
        }
    }

    public function getFrameTypesProperty(): array
    {
        return config('constants.frames') ?? [];
    }

    public function getTitle(): string
    {
        if ($this->viewMode === 'create') {
            return 'Create Template';
        }
        if ($this->viewMode === 'edit') {
            return 'Edit Template';
        }
        return 'Premium Templates';
    }

    public function getTemplatesProperty()
    {
        $query = UserPremiumTemplate::with('user')->latest();
        if ($this->userId) {
            $query->where('user_id', $this->userId);
        }
        return $query->get();
    }

    public function openCreatePage(): void
    {
        $this->reset(['editingId', 'formMiddleImage', 'formTopImage', 'formBottomImage', 'existingMiddleImage', 'existingTopImage', 'existingBottomImage']);
        $this->formUserId = $this->userId ?: ($this->formUserId ?: User::first()?->id);
        $this->formFrameType = '';
        $this->formStatus = 'Active';
        $this->formCreatedDate = date('Y-m-d');
        $this->formUpToDays = User::with('plan')->find($this->formUserId)?->plan?->duration_days ?? 30;
        $this->formExtraDays = $this->extraDays;
        $this->formMarginBottom = 0;
        $this->formMarginTop = 0;
        $this->formMarginLeft = 0;
        $this->formMarginRight = 0;
        $this->formDaysLeft = 0;
        $this->viewMode = 'create';
    }

    public function openEditPage(int $id): void
    {
        $template = UserPremiumTemplate::find($id);
        if (! $template) return;

        $this->editingId = $template->id;
        $this->formUserId = $template->user_id;
        $this->formFrameType = $template->frame_type ?? '';
        $this->formStatus = $template->status ?? 'Active';
        $this->formCreatedDate = $template->created_date ? $template->created_date->format('Y-m-d') : date('Y-m-d');
        $this->formUpToDays = $template->up_to_days ?? User::with('plan')->find($this->formUserId)?->plan?->duration_days ?? 30;
        $this->formExtraDays = $this->extraDays;
        $this->formMarginBottom = $template->margin_bottom ?? 0;
        $this->formMarginTop = $template->margin_top ?? 0;
        $this->formMarginLeft = $template->margin_left ?? 0;
        $this->formMarginRight = $template->margin_right ?? 0;
        $this->formDaysLeft = $template->days_left ?? 0;
        $this->existingMiddleImage = $template->middle_image;
        $this->existingTopImage = $template->top_image;
        $this->existingBottomImage = $template->bottom_image;
        $this->formMiddleImage = null;
        $this->formTopImage = null;
        $this->formBottomImage = null;
        $this->viewMode = 'edit';
    }

    public function goToList(): void
    {
        $this->viewMode = 'list';
        $this->showModal = false;
        $this->dispatch('init-datatables');
    }

    public function openAddModal(): void
    {
        $this->openCreatePage();
    }

    public function openEditModal(int $id): void
    {
        $this->openEditPage($id);
    }

    public function closeModal(): void
    {
        $this->goToList();
    }

    public function updatedFormExtraDays(): void
    {
        // Live updates handled dynamically
    }

    public function getImageUrl(?string $path): ?string
    {
        return UserPremiumTemplate::formatImageUrl($path);
    }

    #[On('set-premium-template-image')]
    public function setTemplateImage(string $slot, string $path): void
    {
        $path = trim($path);
        if ($slot === 'middle') {
            $this->existingMiddleImage = $path;
            $this->formMiddleImage = null;
        } elseif ($slot === 'top') {
            $this->existingTopImage = $path;
            $this->formTopImage = null;
        } elseif ($slot === 'bottom') {
            $this->existingBottomImage = $path;
            $this->formBottomImage = null;
        }
    }

    public function removeMiddleImage(): void
    {
        $this->formMiddleImage = null;
        $this->existingMiddleImage = null;
    }

    public function removeTopImage(): void
    {
        $this->formTopImage = null;
        $this->existingTopImage = null;
    }

    public function removeBottomImage(): void
    {
        $this->formBottomImage = null;
        $this->existingBottomImage = null;
    }

    public function saveTemplate(): void
    {
        $userId = $this->formUserId ?: $this->userId;
        if (! $userId) {
            $userId = User::first()?->id;
        }

        $data = [
            'user_id' => $userId,
            'frame_type' => $this->formFrameType ?: 'Blank Frame',
            'status' => $this->formStatus ?: 'Active',
            'created_date' => $this->formCreatedDate ?: date('Y-m-d'),
            'up_to_days' => $this->formUpToDays ?: 30,
            'extra_days' => $this->formExtraDays,
            'margin_bottom' => $this->formMarginBottom,
            'margin_top' => $this->formMarginTop,
            'margin_left' => $this->formMarginLeft,
            'margin_right' => $this->formMarginRight,
            'days_left' => $this->formDaysLeft,
            'middle_image' => $this->existingMiddleImage,
            'top_image' => $this->existingTopImage,
            'bottom_image' => $this->existingBottomImage,
        ];

        if ($this->formMiddleImage && is_object($this->formMiddleImage)) {
            $data['middle_image'] = $this->formMiddleImage->store('templates', 'public');
        } elseif (is_string($this->formMiddleImage) && $this->formMiddleImage) {
            $data['middle_image'] = $this->formMiddleImage;
        }

        if ($this->formTopImage && is_object($this->formTopImage)) {
            $data['top_image'] = $this->formTopImage->store('templates', 'public');
        } elseif (is_string($this->formTopImage) && $this->formTopImage) {
            $data['top_image'] = $this->formTopImage;
        }

        if ($this->formBottomImage && is_object($this->formBottomImage)) {
            $data['bottom_image'] = $this->formBottomImage->store('templates', 'public');
        } elseif (is_string($this->formBottomImage) && $this->formBottomImage) {
            $data['bottom_image'] = $this->formBottomImage;
        }

        if ($this->editingId) {
            $template = UserPremiumTemplate::find($this->editingId);
            if ($template) {
                $data['up_to_days'] = ($template->up_to_days ?? 30) + $this->formExtraDays;
                $data['extra_days'] = ($template->extra_days ?? 0) + $this->formExtraDays;

                $template->update($data);
                Notification::make()->title('Template updated successfully')->success()->send();
            }
        } else {
            $data['up_to_days'] = ($this->formUpToDays ?: 30) + $this->formExtraDays;
            $data['extra_days'] = $this->formExtraDays;

            UserPremiumTemplate::create($data);
            Notification::make()->title('New Premium Template created successfully')->success()->send();
        }

        $this->viewMode = 'list';
        $this->showModal = false;
        $this->dispatch('init-datatables');
    }

    public function deleteTemplate(int $id): void
    {
        $template = UserPremiumTemplate::find($id);
        if ($template) {
            $template->delete();
            Notification::make()->title('Template deleted successfully')->success()->send();
        }
    }

    public function deleteSelected(array $ids): void
    {
        if (! empty($ids)) {
            UserPremiumTemplate::whereIn('id', $ids)->delete();
            Notification::make()->title('Selected templates deleted successfully')->success()->send();
        }
    }
}
