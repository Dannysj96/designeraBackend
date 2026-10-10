@php
    $logoUrl = \App\Models\Setting::url('logo');
    $siteTitle = \App\Models\Setting::get('site_title');
@endphp

<div style="display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 4px 0;">
    <div style="display: flex; align-items: center; gap: 10px;">
        @if ($logoUrl)
            <img src="{{ $logoUrl }}" 
                 alt="{{ $siteTitle }}" 
                 style="width: 32px; height: 32px; min-width: 32px; border-radius: 8px; object-fit: contain; box-shadow: 0 1px 2px rgba(0,0,0,0.05); background: #ffffff; padding: 2px; border: 1px solid #e4e4e7;">
        @else
            <div style="width: 32px; height: 32px; min-width: 32px; border-radius: 8px; background-color: #18181b; display: flex; align-items: center; justify-content: center; color: #ffffff; box-shadow: 0 1px 2px rgba(0,0,0,0.1);">
                <svg width="18" height="18" style="width: 18px; height: 18px; min-width: 18px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
            </div>
        @endif
        <div style="display: flex; flex-direction: column; text-align: left; line-height: 1.2;">
            <span style="font-size: 13px; font-weight: 700; color: #18181b;" class="dark:text-white">{{ $siteTitle ?? 'Admin Panel' }}</span>
            <span style="font-size: 11px; font-weight: 500; color: #a1a1aa;">{{ \App\Models\Setting::get('site_subtitle') ?? 'Designera' }}</span>
        </div>
    </div>
    <div style="color: #a1a1aa; padding-left: 8px;">
        <svg width="14" height="14" style="width: 14px; height: 14px; min-width: 14px;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 15l5 5 5-5M7 9l5-5 5 5" />
        </svg>
    </div>
</div>
