<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <div style="margin-top: 24px; display: flex; align-items: center; gap: 12px;">
            <button type="submit" 
                    style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 9px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; background: #18181b; color: #ffffff; border: 1px solid #18181b; cursor: pointer; transition: all 0.15s; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"
                    class="dark:bg-white dark:text-zinc-900 dark:border-white hover:opacity-90">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                    <polyline points="17 21 17 13 7 13 7 21"></polyline>
                    <polyline points="7 3 7 8 15 8"></polyline>
                </svg>
                Save Settings
            </button>
        </div>
    </form>
</x-filament-panels::page>
