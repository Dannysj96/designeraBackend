<x-filament-panels::page>
    <style>
        .api-tester-wrap {
            font-family: inherit;
            color: #09090b;
        }
        .dark .api-tester-wrap {
            color: #f4f4f5;
        }

        .api-top-bar {
            background: #ffffff;
            border: 1px solid #e4e4e7;
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }
        .dark .api-top-bar {
            background: #18181b;
            border-color: #27272a;
        }

        .api-base-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
            padding: 5px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
        }
        .dark .api-base-pill {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border-color: rgba(16, 185, 129, 0.3);
        }

        .api-grid {
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 20px;
            align-items: start;
        }
        @media (max-width: 1024px) {
            .api-grid {
                grid-template-columns: 1fr;
            }
        }

        .api-card {
            background: #ffffff;
            border: 1px solid #e4e4e7;
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }
        .dark .api-card {
            background: #18181b;
            border-color: #27272a;
        }

        .api-search-box {
            width: 100%;
            box-sizing: border-box;
            padding: 8px 12px;
            font-size: 12px;
            border-radius: 8px;
            border: 1px solid #d4d4d8;
            background: #f4f4f5;
            color: #18181b;
            outline: none;
            margin-bottom: 12px;
            transition: all 0.15s;
        }
        .api-search-box:focus {
            background: #ffffff;
            border-color: #18181b;
        }
        .dark .api-search-box {
            background: #27272a;
            border-color: #3f3f46;
            color: #f4f4f5;
        }
        .dark .api-search-box:focus {
            background: #18181b;
            border-color: #71717a;
        }

        .api-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
            max-height: 480px;
            overflow-y: auto;
            padding-right: 4px;
        }

        .api-item-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid transparent;
            background: transparent;
            text-align: left;
            cursor: pointer;
            transition: all 0.15s;
            font-family: inherit;
        }
        .api-item-btn:hover {
            background: #f4f4f5;
        }
        .dark .api-item-btn:hover {
            background: #27272a;
        }
        .api-item-btn.active {
            background: #f4f4f5;
            border-color: #18181b;
        }
        .dark .api-item-btn.active {
            background: #27272a;
            border-color: #71717a;
        }

        .method-tag {
            font-size: 10px;
            font-weight: 700;
            font-family: monospace;
            padding: 2px 6px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            flex-shrink: 0;
        }
        .method-tag-get { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }
        .method-tag-post { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .method-tag-put, .method-tag-patch { background: #fefce8; color: #a16207; border: 1px solid #fef08a; }
        .method-tag-delete { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

        .dark .method-tag-get { background: rgba(5, 150, 105, 0.2); color: #34d399; border-color: rgba(5, 150, 105, 0.4); }
        .dark .method-tag-post { background: rgba(37, 99, 235, 0.2); color: #60a5fa; border-color: rgba(37, 99, 235, 0.4); }
        .dark .method-tag-put, .dark .method-tag-patch { background: rgba(202, 138, 4, 0.2); color: #facc15; border-color: rgba(202, 138, 4, 0.4); }
        .dark .method-tag-delete { background: rgba(220, 38, 38, 0.2); color: #f87171; border-color: rgba(220, 38, 38, 0.4); }

        .api-request-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }
        .api-method-select {
            padding: 9px 12px;
            font-size: 12px;
            font-weight: 700;
            font-family: monospace;
            border-radius: 8px;
            border: 1px solid #d4d4d8;
            background: #f4f4f5;
            color: #18181b;
            outline: none;
            cursor: pointer;
        }
        .dark .api-method-select {
            background: #27272a;
            border-color: #3f3f46;
            color: #f4f4f5;
        }

        .api-url-input {
            flex: 1;
            min-width: 220px;
            padding: 9px 12px;
            font-size: 12px;
            font-family: monospace;
            border-radius: 8px;
            border: 1px solid #d4d4d8;
            background: #f4f4f5;
            color: #18181b;
            outline: none;
            box-sizing: border-box;
        }
        .api-url-input:focus {
            background: #ffffff;
            border-color: #18181b;
        }
        .dark .api-url-input {
            background: #27272a;
            border-color: #3f3f46;
            color: #f4f4f5;
        }
        .dark .api-url-input:focus {
            background: #18181b;
            border-color: #71717a;
        }

        .api-send-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            font-size: 12px;
            font-weight: 600;
            color: #ffffff;
            background: #18181b;
            border: 1px solid #18181b;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.15s;
            white-space: nowrap;
        }
        .api-send-btn:hover {
            opacity: 0.9;
        }
        .dark .api-send-btn {
            background: #ffffff;
            color: #18181b;
            border-color: #ffffff;
        }

        .api-tab-btn {
            padding: 8px 14px;
            font-size: 12px;
            font-weight: 500;
            background: transparent;
            border: none;
            border-bottom: 2px solid transparent;
            color: #71717a;
            cursor: pointer;
            transition: all 0.15s;
        }
        .api-tab-btn.active {
            color: #18181b;
            border-bottom-color: #18181b;
            font-weight: 600;
        }
        .dark .api-tab-btn.active {
            color: #ffffff;
            border-bottom-color: #ffffff;
        }

        .api-code-view {
            background: #09090b;
            color: #4ade80;
            border-radius: 8px;
            padding: 14px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 12px;
            line-height: 1.6;
            max-height: 460px;
            overflow: auto;
            margin: 0;
            border: 1px solid #27272a;
        }

        .status-badge {
            font-size: 11px;
            font-weight: 700;
            font-family: monospace;
            padding: 3px 8px;
            border-radius: 6px;
        }
        .status-badge-ok { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
        .status-badge-err { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

        .dark .status-badge-ok { background: rgba(5, 150, 105, 0.2); color: #34d399; border-color: rgba(5, 150, 105, 0.4); }
        .dark .status-badge-err { background: rgba(220, 38, 38, 0.2); color: #f87171; border-color: rgba(220, 38, 38, 0.4); }

        .api-icon {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }
        .api-icon-sm {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
        }
    </style>

    <div class="api-tester-wrap" x-data="{
        copied: false,
        activeResponseTab: 'body',
        copyResponse() {
            const text = document.getElementById('api-response-output')?.innerText;
            if (text) {
                navigator.clipboard.writeText(text);
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            }
        }
    }">

        <!-- Top Header Bar -->
        <div class="api-top-bar">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 36px; height: 36px; border-radius: 8px; background: #f4f4f5; display: flex; align-items: center; justify-content: center;" class="dark:bg-zinc-800">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="api-icon">
                        <polyline points="4 17 10 11 4 5"></polyline>
                        <line x1="12" y1="19" x2="20" y2="19"></line>
                    </svg>
                </div>
                <div>
                    <div style="font-size: 15px; font-weight: 700;">API Console & Tester</div>
                    <div style="font-size: 12px; color: #71717a;">Test and debug your application endpoints in real-time.</div>
                </div>
            </div>

            <div class="api-base-pill">
                <span style="width: 6px; height: 6px; border-radius: 50%; background: #059669; display: inline-block;"></span>
                <span>Base URL: {{ url('/') }}</span>
            </div>
        </div>

        <!-- 2-Column Grid -->
        <div class="api-grid">

            <!-- LEFT: Discovered APIs -->
            <div class="api-card">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                    <span style="font-size: 13px; font-weight: 700;">Discovered APIs</span>
                    <span style="font-size: 11px; font-weight: 600; padding: 2px 7px; border-radius: 999px; background: #f4f4f5; color: #71717a;" class="dark:bg-zinc-800 dark:text-zinc-400">
                        {{ count($this->discovered_routes) }}
                    </span>
                </div>

                <!-- Search box -->
                <input
                    type="text"
                    wire:model.live.debounce.200ms="search"
                    placeholder="Filter endpoints..."
                    class="api-search-box"
                />

                <!-- Endpoints List -->
                <div class="api-list">
                    @forelse($this->discovered_routes as $route)
                        @php
                            $m = strtoupper($route['method']);
                            $tagClass = match($m) {
                                'GET' => 'method-tag-get',
                                'POST' => 'method-tag-post',
                                'PUT', 'PATCH' => 'method-tag-put',
                                'DELETE' => 'method-tag-delete',
                                default => '',
                            };
                            $isActive = ($endpoint === $route['uri'] && $method === $route['method']);
                        @endphp
                        <button
                            type="button"
                            wire:click="selectEndpoint('{{ $route['uri'] }}', '{{ $route['method'] }}')"
                            class="api-item-btn {{ $isActive ? 'active' : '' }}"
                        >
                            <div style="display: flex; align-items: center; gap: 8px; overflow: hidden;">
                                <span class="method-tag {{ $tagClass }}">{{ $m }}</span>
                                <span style="font-size: 12px; font-family: monospace; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $route['uri'] }}
                                </span>
                            </div>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="api-icon-sm" style="color: #a1a1aa;">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
                    @empty
                        <div style="text-align: center; padding: 20px; font-size: 12px; color: #a1a1aa;">
                            No matching routes found.
                        </div>
                    @endforelse
                </div>

                <!-- Recent History -->
                @if(count($history) > 0)
                    <div style="margin-top: 20px; padding-top: 14px; border-top: 1px solid #e4e4e7;" class="dark:border-zinc-800">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #71717a;">Recent Tests</span>
                            <button type="button" wire:click="clearHistory" style="font-size: 11px; color: #ef4444; background: none; border: none; cursor: pointer; padding: 0;">
                                Clear
                            </button>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                            @foreach($history as $h)
                                <div style="display: flex; align-items: center; justify-content: space-between; font-size: 11px; padding: 4px 6px; border-radius: 4px; background: #fafafa;" class="dark:bg-zinc-800/50">
                                    <div style="display: flex; align-items: center; gap: 6px; overflow: hidden;">
                                        <span style="font-weight: 700; font-family: monospace;" class="{{ $h['method'] === 'GET' ? 'text-emerald-600' : 'text-blue-600' }}">{{ $h['method'] }}</span>
                                        <span style="font-family: monospace; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 140px;">{{ $h['endpoint'] }}</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 6px; flex-shrink: 0;">
                                        <span style="font-weight: 700; font-family: monospace;" class="{{ $h['status'] < 400 ? 'text-emerald-600' : 'text-rose-600' }}">{{ $h['status'] }}</span>
                                        <span style="color: #a1a1aa; font-family: monospace;">{{ $h['time'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- RIGHT: Request Builder & Response -->
            <div style="display: flex; flex-direction: column; gap: 16px;">

                <!-- Request Box -->
                <div class="api-card">
                    <!-- URL Bar -->
                    <div class="api-request-bar">
                        <select wire:model.live="method" class="api-method-select">
                            <option value="GET">GET</option>
                            <option value="POST">POST</option>
                            <option value="PUT">PUT</option>
                            <option value="PATCH">PATCH</option>
                            <option value="DELETE">DELETE</option>
                        </select>

                        <input
                            type="text"
                            wire:model="endpoint"
                            wire:keydown.enter="sendRequest"
                            placeholder="/api/v1/..."
                            class="api-url-input"
                        />

                        <button type="button" wire:click="sendRequest" wire:loading.attr="disabled" class="api-send-btn">
                            <span wire:loading.remove wire:target="sendRequest" style="display: flex; align-items: center; gap: 6px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="api-icon-sm">
                                    <line x1="22" y1="2" x2="11" y2="13"></line>
                                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                </svg>
                                Send Request
                            </span>
                            <span wire:loading wire:target="sendRequest" style="display: flex; align-items: center; gap: 6px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="api-icon-sm" style="animation: spin 1s linear infinite;">
                                    <circle cx="12" cy="12" r="10" stroke-opacity="0.25"></circle>
                                    <path d="M4 12a8 8 0 0 1 8-8"></path>
                                </svg>
                                Sending...
                            </span>
                        </button>
                    </div>

                    <!-- Tabs Bar -->
                    <div style="display: flex; gap: 4px; border-bottom: 1px solid #e4e4e7; margin-bottom: 14px;" class="dark:border-zinc-800">
                        <button type="button" wire:click="$set('activeTab', 'params')" class="api-tab-btn {{ $activeTab === 'params' ? 'active' : '' }}">
                            Params ({{ count($params) }})
                        </button>
                        <button type="button" wire:click="$set('activeTab', 'headers')" class="api-tab-btn {{ $activeTab === 'headers' ? 'active' : '' }}">
                            Headers ({{ count($headers) }})
                        </button>
                        <button type="button" wire:click="$set('activeTab', 'body')" class="api-tab-btn {{ $activeTab === 'body' ? 'active' : '' }}">
                            Body (JSON)
                        </button>
                        <button type="button" wire:click="$set('activeTab', 'auth')" class="api-tab-btn {{ $activeTab === 'auth' ? 'active' : '' }}">
                            Authorization
                        </button>
                    </div>

                    <!-- TAB: Params -->
                    @if($activeTab === 'params')
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            @foreach($params as $i => $param)
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <input type="checkbox" wire:model="params.{{ $i }}.enabled" style="cursor: pointer;" />
                                    <input type="text" placeholder="Key (e.g. state_id)" wire:model="params.{{ $i }}.key" class="api-url-input" style="flex: 1;" />
                                    <input type="text" placeholder="Value" wire:model="params.{{ $i }}.value" class="api-url-input" style="flex: 1;" />
                                    <button type="button" wire:click="removeParam({{ $i }})" style="background: none; border: none; color: #a1a1aa; cursor: pointer; font-size: 16px; padding: 0 6px;">
                                        &times;
                                    </button>
                                </div>
                            @endforeach
                            <div>
                                <button type="button" wire:click="addParam" style="background: none; border: none; color: #2563eb; font-size: 12px; font-weight: 600; cursor: pointer; padding: 4px 0;">
                                    + Add Parameter
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- TAB: Headers -->
                    @if($activeTab === 'headers')
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            @foreach($headers as $i => $h)
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <input type="checkbox" wire:model="headers.{{ $i }}.enabled" style="cursor: pointer;" />
                                    <input type="text" placeholder="Header name" wire:model="headers.{{ $i }}.key" class="api-url-input" style="flex: 1;" />
                                    <input type="text" placeholder="Value" wire:model="headers.{{ $i }}.value" class="api-url-input" style="flex: 1;" />
                                    <button type="button" wire:click="removeHeader({{ $i }})" style="background: none; border: none; color: #a1a1aa; cursor: pointer; font-size: 16px; padding: 0 6px;">
                                        &times;
                                    </button>
                                </div>
                            @endforeach
                            <div>
                                <button type="button" wire:click="addHeader" style="background: none; border: none; color: #2563eb; font-size: 12px; font-weight: 600; cursor: pointer; padding: 4px 0;">
                                    + Add Header
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- TAB: Body -->
                    @if($activeTab === 'body')
                        <div>
                            <div style="display: flex; justify-content: flex-end; margin-bottom: 6px;">
                                <button type="button" wire:click="prettifyJson" style="background: none; border: none; color: #2563eb; font-size: 11px; font-weight: 600; cursor: pointer;">
                                    Prettify JSON
                                </button>
                            </div>
                            <textarea
                                wire:model="body"
                                rows="6"
                                placeholder="{\n  &quot;key&quot;: &quot;value&quot;\n}"
                                style="width: 100%; box-sizing: border-box; font-family: monospace; font-size: 12px; padding: 10px; border-radius: 8px; border: 1px solid #d4d4d8; background: #f4f4f5; outline: none;"
                                class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-100"
                            ></textarea>
                        </div>
                    @endif

                    <!-- TAB: Auth -->
                    @if($activeTab === 'auth')
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="font-size: 12px; font-weight: 600;">Bearer Token</label>
                            <input
                                type="text"
                                wire:model="bearerToken"
                                placeholder="Paste token here..."
                                class="api-url-input"
                                style="width: 100%;"
                            />
                            <span style="font-size: 11px; color: #71717a;">
                                Automatically adds <code style="background: #f4f4f5; padding: 2px 5px; border-radius: 4px;">Authorization: Bearer &lt;token&gt;</code> to request headers.
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Live Response Box -->
                <div class="api-card">
                    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; padding-bottom: 12px; margin-bottom: 12px; border-bottom: 1px solid #e4e4e7;" class="dark:border-zinc-800">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 13px; font-weight: 700;">Response</span>

                            @if($responseStatus !== null)
                                <span class="status-badge {{ $responseStatus < 400 ? 'status-badge-ok' : 'status-badge-err' }}">
                                    {{ $responseStatus }} {{ $responseStatusText }}
                                </span>
                                <span style="font-size: 11px; font-family: monospace; color: #71717a;">
                                    ⏱️ {{ $responseTime }} ms
                                </span>
                                <span style="font-size: 11px; font-family: monospace; color: #71717a;">
                                    📦 {{ $responseSize }}
                                </span>
                            @else
                                <span style="font-size: 11px; color: #a1a1aa;">Ready</span>
                            @endif
                        </div>

                        @if($responseBody !== null)
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="display: flex; background: #f4f4f5; border-radius: 6px; padding: 2px;" class="dark:bg-zinc-800">
                                    <button
                                        type="button"
                                        @click="activeResponseTab = 'body'"
                                        :style="activeResponseTab === 'body' ? 'background: #ffffff; font-weight: 600; box-shadow: 0 1px 2px rgba(0,0,0,0.05);' : 'color: #71717a;'"
                                        style="border: none; padding: 4px 10px; border-radius: 4px; font-size: 11px; cursor: pointer;"
                                        class="dark:bg-zinc-700 dark:text-white"
                                    >
                                        Body
                                    </button>
                                    <button
                                        type="button"
                                        @click="activeResponseTab = 'headers'"
                                        :style="activeResponseTab === 'headers' ? 'background: #ffffff; font-weight: 600; box-shadow: 0 1px 2px rgba(0,0,0,0.05);' : 'color: #71717a;'"
                                        style="border: none; padding: 4px 10px; border-radius: 4px; font-size: 11px; cursor: pointer;"
                                        class="dark:bg-zinc-700 dark:text-white"
                                    >
                                        Headers ({{ count($responseHeaders) }})
                                    </button>
                                </div>

                                <button
                                    type="button"
                                    @click="copyResponse()"
                                    style="border: 1px solid #d4d4d8; background: #f4f4f5; border-radius: 6px; padding: 4px 10px; font-size: 11px; font-weight: 600; cursor: pointer;"
                                    class="dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-200"
                                >
                                    <span x-show="!copied">📋 Copy</span>
                                    <span x-show="copied" style="color: #059669;">✓ Copied!</span>
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Response Output -->
                    @if($responseBody !== null)
                        <div x-show="activeResponseTab === 'body'">
                            <pre class="api-code-view"><code id="api-response-output">{{ $responseBody }}</code></pre>
                        </div>

                        <div x-show="activeResponseTab === 'headers'" style="max-height: 460px; overflow-y: auto; display: flex; flex-direction: column; gap: 6px;">
                            @foreach($responseHeaders as $hKey => $hVal)
                                <div style="display: flex; gap: 8px; font-size: 11px; font-family: monospace; padding: 4px 0; border-bottom: 1px solid #f4f4f5;" class="dark:border-zinc-800">
                                    <span style="font-weight: 700; width: 160px; flex-shrink: 0;">{{ $hKey }}:</span>
                                    <span style="color: #71717a; word-break: break-all;">{{ $hVal }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="text-align: center; padding: 40px 20px; color: #a1a1aa;">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width: 36px; height: 36px; margin: 0 auto 10px; opacity: 0.5;">
                                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                            </svg>
                            <div style="font-size: 12px; font-weight: 500;">Select an API endpoint from the left or enter a path and click "Send Request"</div>
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div>
</x-filament-panels::page>
