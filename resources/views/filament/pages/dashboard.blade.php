<x-filament-panels::page>
    <style>
        .shadcn-container {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #09090b;
        }
        .dark .shadcn-container {
            color: #f4f4f5;
        }
        .shadcn-header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }
        .shadcn-title {
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.025em;
            color: #09090b;
            line-height: 1.2;
            margin: 0;
        }
        .dark .shadcn-title {
            color: #ffffff;
        }
        .shadcn-subtitle {
            font-size: 13px;
            color: #71717a;
            margin-top: 4px;
            margin-bottom: 0;
        }
        .shadcn-header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .shadcn-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            background-color: #ffffff;
            color: #18181b;
            border: 1px solid #e4e4e7;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .dark .shadcn-btn {
            background-color: #18181b;
            color: #f4f4f5;
            border-color: #27272a;
        }
        .shadcn-btn:hover {
            background-color: #f4f4f5;
            border-color: #d4d4d8;
            color: #09090b;
        }
        .dark .shadcn-btn:hover {
            background-color: #27272a;
            color: #ffffff;
        }
        .shadcn-btn-primary {
            background-color: #18181b;
            color: #ffffff;
            border-color: #18181b;
        }
        .shadcn-btn-primary:hover {
            background-color: #27272a;
            color: #ffffff;
            border-color: #27272a;
        }
        .dark .shadcn-btn-primary {
            background-color: #f4f4f5;
            color: #18181b;
            border-color: #f4f4f5;
        }
        .dark .shadcn-btn-primary:hover {
            background-color: #e4e4e7;
            color: #09090b;
        }
        .shadcn-grid-4 {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }
        @media (max-width: 1100px) {
            .shadcn-grid-4 {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (max-width: 640px) {
            .shadcn-grid-4 {
                grid-template-columns: 1fr;
            }
        }
        .shadcn-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 20px;
        }
        @media (max-width: 1024px) {
            .shadcn-grid-2 {
                grid-template-columns: 1fr;
            }
        }
        .shadcn-grid-bottom {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 16px;
        }
        @media (max-width: 1024px) {
            .shadcn-grid-bottom {
                grid-template-columns: 1fr;
            }
        }
        .shadcn-card {
            background-color: #ffffff;
            border: 1px solid #e4e4e7;
            border-radius: 12px;
            padding: 20px 22px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.02);
            box-sizing: border-box;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .shadcn-card.clickable:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .dark .shadcn-card {
            background-color: #18181b;
            border-color: #27272a;
        }
        .dark .shadcn-card.clickable:hover {
            border-color: #3f3f46;
        }
        .metric-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .metric-label {
            font-size: 13px;
            font-weight: 500;
            color: #71717a;
        }
        .metric-icon {
            color: #a1a1aa;
        }
        .metric-value {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.03em;
            color: #09090b;
            line-height: 1.1;
            margin-bottom: 8px;
        }
        .dark .metric-value {
            color: #ffffff;
        }
        .metric-trend {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 600;
        }
        .trend-positive {
            color: #16a34a;
        }
        .trend-neutral {
            color: #71717a;
        }
        .metric-caption {
            font-size: 11px;
            color: #a1a1aa;
            margin-top: 4px;
        }
        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 14px;
            border-bottom: 1px solid #f4f4f5;
            margin-bottom: 16px;
        }
        .dark .card-header {
            border-bottom-color: #27272a;
        }
        .card-header-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #09090b;
        }
        .dark .card-header-title {
            color: #ffffff;
        }
        .card-icon-wrap {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 6px;
            background-color: #f4f4f5;
            color: #27272a;
        }
        .dark .card-icon-wrap {
            background-color: #27272a;
            color: #f4f4f5;
        }
        .legend-row {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 12px;
            font-weight: 500;
        }
        .legend-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        .sub-metric-title {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #a1a1aa;
            margin-top: 2px;
        }
        .shadcn-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            text-align: left;
        }
        .shadcn-table th {
            padding: 10px;
            color: #a1a1aa;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #f4f4f5;
        }
        .dark .shadcn-table th {
            border-bottom-color: #27272a;
        }
        .shadcn-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #f4f4f5;
            vertical-align: middle;
        }
        .dark .shadcn-table td {
            border-bottom-color: #27272a;
        }
        .badge-pill {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
            line-height: 1.2;
        }
        .badge-success {
            background-color: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }
        .dark .badge-success {
            background-color: rgba(22, 163, 74, 0.15);
            color: #4ade80;
            border-color: rgba(74, 222, 128, 0.2);
        }
        .badge-warning {
            background-color: #fffbeb;
            color: #d97706;
            border: 1px solid #fef3c7;
        }
        .dark .badge-warning {
            background-color: rgba(217, 119, 6, 0.15);
            color: #fbbf24;
            border-color: rgba(251, 191, 36, 0.2);
        }
        .badge-danger {
            background-color: #fef2f2;
            color: #ef4444;
            border: 1px solid #fee2e2;
        }
        .dark .badge-danger {
            background-color: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border-color: rgba(248, 113, 113, 0.2);
        }
        .badge-neutral {
            background-color: #f4f4f5;
            color: #52525b;
            border: 1px solid #e4e4e7;
        }
        .dark .badge-neutral {
            background-color: #27272a;
            color: #a1a1aa;
            border-color: #3f3f46;
        }
        .stat-bar-container {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-top: 14px;
        }
        .stat-bar-item {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .stat-bar-label-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            font-weight: 500;
        }
        .stat-bar-track {
            width: 100%;
            height: 7px;
            border-radius: 9999px;
            background-color: #f4f4f5;
            overflow: hidden;
        }
        .dark .stat-bar-track {
            background-color: #27272a;
        }
        .stat-bar-fill {
            height: 100%;
            border-radius: 9999px;
            transition: width 0.5s ease;
        }
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #e0e7ff;
            color: #4338ca;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
        }
    </style>

    <div class="shadcn-container">
        {{-- Header Row --}}
        <div class="shadcn-header-row">
            <div>
                <h1 class="shadcn-title">Dashboard Overview</h1>
                <p class="shadcn-subtitle">Real-time summary of users, designs, videos, templates, and platform activity.</p>
            </div>

            <div class="shadcn-header-actions">
                {{-- Date Range Badge --}}
                <div class="shadcn-btn">
                    <svg width="13" height="13" fill="none" stroke="#71717a" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <span>{{ $dateRangeText }}</span>
                </div>

                {{-- Total Assets Badge --}}
                <div class="shadcn-btn">
                    <svg width="13" height="13" fill="none" stroke="#71717a" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <span>{{ number_format($totalAssets) }} Total Assets</span>
                </div>

                {{-- Quick Action: New Design --}}
                <a href="{{ route('filament.admin.resources.designs.create') }}" class="shadcn-btn shadcn-btn-primary">
                    <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>Add Design</span>
                </a>
            </div>
        </div>

        {{-- Row 1: Top 4 Dynamic KPI Cards --}}
        <div class="shadcn-grid-4">
            {{-- Card 1: Users --}}
            <a href="{{ route('filament.admin.resources.users.index') }}" class="shadcn-card clickable">
                <div class="metric-header">
                    <span class="metric-label">Total Users</span>
                    <svg class="metric-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="metric-value">{{ number_format($totalUsers) }}</div>
                <div class="metric-trend trend-positive">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="7" y1="17" x2="17" y2="7"></line>
                        <polyline points="7 7 17 7 17 17"></polyline>
                    </svg>
                    <span>{{ $activeUsers }} Active ({{ $verifiedUsers }} Verified)</span>
                </div>
                <div class="metric-caption">{{ $newUsersThisMonth }} new registrations this month</div>
            </a>

            {{-- Card 2: Designs Library --}}
            <a href="{{ route('filament.admin.resources.designs.index') }}" class="shadcn-card clickable">
                <div class="metric-header">
                    <span class="metric-label">Designs Library</span>
                    <svg class="metric-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="metric-value">{{ number_format($totalDesigns) }}</div>
                <div class="metric-trend trend-positive">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="7" y1="17" x2="17" y2="7"></line>
                        <polyline points="7 7 17 7 17 17"></polyline>
                    </svg>
                    <span>{{ $activeDesigns }} Published</span>
                </div>
                <div class="metric-caption">{{ $freeDesigns }} Free &bull; {{ $premiumDesigns }} Premium</div>
            </a>

            {{-- Card 3: Videos --}}
            <a href="{{ route('filament.admin.resources.videos.index') }}" class="shadcn-card clickable">
                <div class="metric-header">
                    <span class="metric-label">Video Templates</span>
                    <svg class="metric-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="metric-value">{{ number_format($totalVideos) }}</div>
                <div class="metric-trend trend-neutral">
                    <span>{{ $activeVideos }} Active in catalog</span>
                </div>
                <div class="metric-caption">{{ $newVideosThisMonth }} added this month</div>
            </a>

            {{-- Card 4: Premium Templates & Plans --}}
            <a href="{{ route('filament.admin.pages.premium-templates') }}" class="shadcn-card clickable">
                <div class="metric-header">
                    <span class="metric-label">Premium Templates</span>
                    <svg class="metric-icon" width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                    </svg>
                </div>
                <div class="metric-value">{{ number_format($totalPremiumTemplates) }}</div>
                <div class="metric-trend trend-positive">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <line x1="7" y1="17" x2="17" y2="7"></line>
                        <polyline points="7 7 17 7 17 17"></polyline>
                    </svg>
                    <span>{{ $activePremiumTemplates }} Active Assignments</span>
                </div>
                <div class="metric-caption">{{ $totalCategories }} Categories &bull; {{ $totalSubCategories }} Subcategories</div>
            </a>
        </div>

        {{-- Row 2: Middle Analytics Grid --}}
        <div class="shadcn-grid-2">
            {{-- Left Card: Dynamic 7-Day Activity Chart --}}
            <div class="shadcn-card" style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div class="card-header">
                        <div class="card-header-title">
                            <div class="card-icon-wrap">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <span>Activity & Upload Trend</span>
                        </div>

                        <div class="legend-row">
                            <div style="display: flex; align-items: center;">
                                <span class="legend-dot" style="background-color: #18181b;"></span>
                                <span style="color: #27272a; font-weight: 500;">Media (Designs & Videos)</span>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <span class="legend-dot" style="background-color: #a1a1aa;"></span>
                                <span style="color: #71717a; font-weight: 500;">User Signups</span>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 4px;">
                        <div class="metric-value" style="margin-bottom: 2px; font-size: 22px;">
                            {{ number_format(collect($chartDays)->sum('total')) }} Total Actions
                        </div>
                        <div class="sub-metric-title">LAST 7 DAYS ACTIVITY LOG</div>
                    </div>
                </div>

                {{-- Dynamic SVG Activity Chart --}}
                <div style="margin-top: 20px; width: 100%;">
                    <svg viewBox="0 0 540 210" style="width: 100%; height: 210px; display: block;">
                        {{-- Gridlines --}}
                        <line x1="45" y1="20" x2="530" y2="20" stroke="#f4f4f5" stroke-width="1" stroke-dasharray="3 3"/>
                        <text x="35" y="24" text-anchor="end" font-size="11" fill="#a1a1aa" font-weight="500">{{ max($maxDailyActivity, 4) }}</text>

                        <line x1="45" y1="75" x2="530" y2="75" stroke="#f4f4f5" stroke-width="1" stroke-dasharray="3 3"/>
                        <text x="35" y="79" text-anchor="end" font-size="11" fill="#a1a1aa" font-weight="500">{{ max(round($maxDailyActivity * 0.6), 2) }}</text>

                        <line x1="45" y1="130" x2="530" y2="130" stroke="#f4f4f5" stroke-width="1" stroke-dasharray="3 3"/>
                        <text x="35" y="134" text-anchor="end" font-size="11" fill="#a1a1aa" font-weight="500">{{ max(round($maxDailyActivity * 0.3), 1) }}</text>

                        <line x1="45" y1="180" x2="530" y2="180" stroke="#e4e4e7" stroke-width="1"/>
                        <text x="35" y="184" text-anchor="end" font-size="11" fill="#a1a1aa" font-weight="500">0</text>

                        {{-- Dynamic Bar Groups --}}
                        @php
                            $barPositions = [75, 140, 205, 270, 335, 400, 465];
                        @endphp
                        @foreach($chartDays as $idx => $dayItem)
                            @php
                                $x = $barPositions[$idx] ?? (75 + $idx * 65);
                                $mediaH = $dayItem['media_bar_h'];
                                $userH = $dayItem['user_bar_h'];
                                $mediaY = 180 - $mediaH;
                                $userY = $mediaY - $userH;
                            @endphp
                            <g>
                                <title>{{ $dayItem['date'] }}: {{ $dayItem['media'] }} Media, {{ $dayItem['users'] }} Users</title>
                                
                                @if($mediaH > 0)
                                    <rect x="{{ $x }}" y="{{ $mediaY }}" width="38" height="{{ $mediaH }}" rx="4" fill="#18181b" />
                                @endif
                                
                                @if($userH > 0)
                                    <rect x="{{ $x }}" y="{{ $userY }}" width="38" height="{{ $userH }}" rx="4" fill="#a1a1aa" />
                                @endif

                                @if($mediaH == 0 && $userH == 0)
                                    <rect x="{{ $x }}" y="177" width="38" height="3" rx="1.5" fill="#f4f4f5" />
                                @endif

                                <text x="{{ $x + 19 }}" y="198" text-anchor="middle" font-size="11" fill="#71717a" font-weight="500">
                                    {{ $dayItem['day'] }}
                                </text>
                            </g>
                        @endforeach
                    </svg>
                </div>
            </div>

            {{-- Right Card: Platform Assets & Distribution --}}
            <div class="shadcn-card" style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div class="card-header">
                        <div class="card-header-title">
                            <div class="card-icon-wrap">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                                </svg>
                            </div>
                            <span>Platform Assets & Operations</span>
                        </div>

                        <a href="{{ route('filament.admin.resources.categories.index') }}" class="shadcn-btn">
                            <span>Browse Catalog</span>
                        </a>
                    </div>

                    <div class="stat-bar-container">
                        {{-- Designs Distribution --}}
                        <div class="stat-bar-item">
                            <div class="stat-bar-label-row">
                                <span style="color: #52525b; font-weight: 600;">Designs (Posts & Stories)</span>
                                <span style="color: #09090b; font-weight: 700;">{{ $totalDesigns }} items</span>
                            </div>
                            <div class="stat-bar-track">
                                <div class="stat-bar-fill" style="width: {{ $totalAssets > 0 ? round(($totalDesigns / $totalAssets) * 100) : 0 }}%; background-color: #18181b;"></div>
                            </div>
                        </div>

                        {{-- Videos Distribution --}}
                        <div class="stat-bar-item">
                            <div class="stat-bar-label-row">
                                <span style="color: #52525b; font-weight: 600;">Video Templates</span>
                                <span style="color: #09090b; font-weight: 700;">{{ $totalVideos }} items</span>
                            </div>
                            <div class="stat-bar-track">
                                <div class="stat-bar-fill" style="width: {{ $totalAssets > 0 ? round(($totalVideos / $totalAssets) * 100) : 0 }}%; background-color: #6366f1;"></div>
                            </div>
                        </div>

                        {{-- Coupons & Offers --}}
                        <div class="stat-bar-item">
                            <div class="stat-bar-label-row">
                                <span style="color: #52525b; font-weight: 600;">Active Coupons & Discounts</span>
                                <span style="color: #09090b; font-weight: 700;">{{ $activeCoupons }} active / {{ $totalCoupons }} total</span>
                            </div>
                            <div class="stat-bar-track">
                                <div class="stat-bar-fill" style="width: {{ $totalCoupons > 0 ? round(($activeCoupons / $totalCoupons) * 100) : 0 }}%; background-color: #10b981;"></div>
                            </div>
                        </div>

                        {{-- Special Days & Campaigns --}}
                        <div class="stat-bar-item">
                            <div class="stat-bar-label-row">
                                <span style="color: #52525b; font-weight: 600;">Special Days & Festivals</span>
                                <span style="color: #09090b; font-weight: 700;">{{ $totalSpecialDays }} events configured</span>
                            </div>
                            <div class="stat-bar-track">
                                <div class="stat-bar-fill" style="width: 100%; background-color: #f59e0b;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 24px; padding-top: 14px; border-top: 1px solid #f4f4f5; display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
                    <span style="color: #71717a;">Registered Political Parties & Morchas</span>
                    <span style="font-weight: 700; color: #09090b;">{{ $totalParties }} Parties</span>
                </div>
            </div>
        </div>

        {{-- Row 3: Bottom Cards (Top Categories & Recent Registrations) --}}
        <div class="shadcn-grid-bottom">
            {{-- Top Categories Breakdown Card --}}
            <div class="shadcn-card">
                <div class="card-header">
                    <div class="card-header-title">
                        <div class="card-icon-wrap">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <span>Top Categories</span>
                    </div>
                    <span class="badge-pill badge-neutral">{{ $totalCategories }} total</span>
                </div>

                <div class="stat-bar-container">
                    @forelse($topCategories as $cat)
                        <div class="stat-bar-item">
                            <div class="stat-bar-label-row">
                                <span style="color: #52525b; font-weight: 600;">{{ $cat['title'] }}</span>
                                <span style="color: #09090b; font-weight: 700;">{{ $cat['count'] }} designs ({{ $cat['pct'] }}%)</span>
                            </div>
                            <div class="stat-bar-track">
                                <div class="stat-bar-fill" style="width: {{ max($cat['pct'], 8) }}%; background-color: #18181b;"></div>
                            </div>
                        </div>
                    @empty
                        <div style="color: #a1a1aa; font-size: 12px; text-align: center; padding: 20px 0;">
                            No category data available yet.
                        </div>
                    @endforelse
                </div>

                <div style="margin-top: 20px; padding-top: 14px; border-top: 1px solid #f4f4f5;">
                    <a href="{{ route('filament.admin.resources.categories.index') }}" style="font-size: 12px; font-weight: 600; color: #52525b; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                        <span>Manage all categories</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

            {{-- Recent Users Table --}}
            <div class="shadcn-card">
                <div class="card-header">
                    <div class="card-header-title">
                        <div class="card-icon-wrap">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <span>Recent User Registrations</span>
                    </div>

                    <a href="{{ route('filament.admin.resources.users.index') }}" style="font-size: 12px; font-weight: 600; color: #52525b; text-decoration: none;">
                        View all users ({{ $totalUsers }}) &rarr;
                    </a>
                </div>

                <div style="overflow-x: auto; margin-top: 6px;">
                    <table class="shadcn-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Status</th>
                                <th>Location</th>
                                <th>Plan</th>
                                <th style="text-align: right;">Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentUsers as $user)
                                @php
                                    $initials = collect(explode(' ', $user->name))
                                        ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                                        ->take(2)
                                        ->join('');
                                    if (empty($initials)) {
                                        $initials = 'U';
                                    }
                                @endphp
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <div class="user-avatar">
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <div style="font-weight: 600; color: #09090b;">
                                                    <a href="{{ route('filament.admin.resources.users.edit', ['record' => $user->id]) }}" style="color: inherit; text-decoration: none;">
                                                        {{ $user->name }}
                                                    </a>
                                                </div>
                                                <div style="font-size: 11px; color: #a1a1aa;">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($user->status === 'active' || $user->status === '1')
                                            <span class="badge-pill badge-success">Active</span>
                                        @elseif($user->status === 'suspended')
                                            <span class="badge-pill badge-danger">Suspended</span>
                                        @else
                                            <span class="badge-pill badge-warning">{{ ucfirst($user->status ?? 'Pending') }}</span>
                                        @endif
                                    </td>
                                    <td style="color: #52525b; font-size: 12px;">
                                        {{ $user->city ?? $user->state ?? '—' }}
                                    </td>
                                    <td>
                                        <span class="badge-pill badge-neutral">
                                            {{ $user->plan_id ?? 'Trial' }}
                                        </span>
                                    </td>
                                    <td style="text-align: right; font-weight: 500; color: #71717a; font-size: 11px;">
                                        {{ $user->created_at?->diffForHumans() ?? '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: #a1a1aa; padding: 24px;">
                                        No users registered yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
