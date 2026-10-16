<x-filament-panels::page>
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

    <style>
        .premium-templates-container {
            background: #ffffff;
            border: 1px solid #e4e4e7;
            border-radius: 12px;
            padding: 24px;
            color: #09090b;
            font-family: inherit;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }
        .dark .premium-templates-container {
            background: #18181b;
            border-color: #27272a;
            color: #f4f4f5;
        }

        .pt-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e4e4e7;
        }
        .dark .pt-header {
            border-bottom-color: #27272a;
        }

        .pt-title {
            font-size: 20px;
            font-weight: 700;
            color: #09090b;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .dark .pt-title {
            color: #ffffff;
        }

        .pt-user-chip {
            font-size: 12px;
            font-weight: 500;
            background: #f0f9ff;
            color: #0284c7;
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid #bae6fd;
        }
        .dark .pt-user-chip {
            background: rgba(2, 132, 199, 0.15);
            color: #38bdf8;
            border-color: rgba(2, 132, 199, 0.3);
        }

        .btn-add-template {
            background-color: #00bcd4;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 9px 18px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 1px 2px rgba(0, 188, 212, 0.2);
            transition: all 0.15s ease-in-out;
        }
        .btn-add-template:hover {
            background-color: #00acc1;
        }

        .btn-delete-selected {
            background-color: #ef4444;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 9px 18px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 1px 2px rgba(239, 68, 68, 0.2);
            transition: all 0.15s ease-in-out;
        }
        .btn-delete-selected:hover {
            background-color: #dc2626;
        }

        /* DataTables Custom Clean White Theme */
        .pt-table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        #premiumTemplatesTable_wrapper {
            color: #09090b;
            font-size: 13px;
        }
        .dark #premiumTemplatesTable_wrapper {
            color: #d1d5db;
        }

        #premiumTemplatesTable_wrapper .dataTables_length,
        #premiumTemplatesTable_wrapper .dataTables_filter {
            margin-bottom: 20px;
            color: #71717a;
        }

        #premiumTemplatesTable_wrapper .dataTables_length select {
            background-color: #ffffff;
            border: 1px solid #e4e4e7;
            color: #09090b;
            border-radius: 6px;
            padding: 5px 28px 5px 10px;
            outline: none;
            margin: 0 6px;
            font-size: 12px;
        }
        .dark #premiumTemplatesTable_wrapper .dataTables_length select {
            background-color: #18181b;
            border-color: #27272a;
            color: #ffffff;
        }

        #premiumTemplatesTable_wrapper .dataTables_filter input {
            background-color: #ffffff;
            border: 1px solid #e4e4e7;
            color: #09090b;
            border-radius: 6px;
            padding: 6px 12px;
            outline: none;
            margin-left: 8px;
            font-size: 12px;
        }
        .dark #premiumTemplatesTable_wrapper .dataTables_filter input {
            background-color: #18181b;
            border-color: #27272a;
            color: #ffffff;
        }

        table.pt-table {
            width: 100% !important;
            border-collapse: collapse !important;
            color: #09090b;
        }
        .dark table.pt-table {
            color: #e5e7eb;
        }

        table.pt-table thead th {
            background-color: transparent !important;
            border-bottom: 1px solid #e4e4e7 !important;
            color: #71717a !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.04em !important;
            padding: 10px 8px !important;
            text-align: left;
            white-space: nowrap;
        }
        .dark table.pt-table thead th {
            border-bottom-color: #27272a !important;
            color: #a1a1aa !important;
        }

        table.pt-table tbody td {
            border-bottom: 1px solid #f4f4f5 !important;
            padding: 10px 8px !important;
            vertical-align: middle !important;
            font-size: 12.5px !important;
            color: #18181b;
            background: transparent !important;
        }
        .dark table.pt-table tbody td {
            border-bottom-color: #27272a !important;
            color: #e2e8f0;
        }

        table.pt-table tbody tr:hover td {
            background-color: #fafafa !important;
        }
        .dark table.pt-table tbody tr:hover td {
            background-color: rgba(255, 255, 255, 0.02) !important;
        }

        /* Image Placeholder */
        .pt-image-card {
            width: 65px;
            height: 65px;
            border-radius: 6px;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #e4e4e7;
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
            flex-shrink: 0;
            text-align: center;
        }
        .dark .pt-image-card {
            background: #27272a;
            border-color: #3f3f46;
        }

        .pt-image-card img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 4px;
        }

        .pt-image-card .no-image-text {
            font-size: 7.5px;
            font-weight: 800;
            color: #71717a;
            line-height: 1.1;
            margin-top: 3px;
            text-transform: uppercase;
            letter-spacing: -0.2px;
        }
        .dark .pt-image-card .no-image-text {
            color: #a1a1aa;
        }

        /* Status Badge */
        .pt-status-active {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
            padding: 3px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
            white-space: nowrap;
        }
        .dark .pt-status-active {
            background-color: rgba(22, 163, 74, 0.15);
            color: #4ade80;
            border-color: rgba(22, 163, 74, 0.3);
        }

        .pt-status-inactive {
            background-color: #f4f4f5;
            color: #71717a;
            border: 1px solid #e4e4e7;
            padding: 3px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
            white-space: nowrap;
        }
        .dark .pt-status-inactive {
            background-color: #27272a;
            color: #a1a1aa;
            border-color: #3f3f46;
        }

        /* Action Buttons */
        .btn-pt-edit {
            width: 30px;
            height: 30px;
            background-color: #00bcd4;
            color: #ffffff;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            box-shadow: 0 1px 2px rgba(0, 188, 212, 0.2);
            transition: all 0.15s;
        }
        .btn-pt-edit:hover {
            background-color: #00acc1;
        }

        .btn-pt-delete {
            width: 30px;
            height: 30px;
            background-color: #ef4444;
            color: #ffffff;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            box-shadow: 0 1px 2px rgba(239, 68, 68, 0.2);
            transition: all 0.15s;
        }
        .btn-pt-delete:hover {
            background-color: #dc2626;
        }

        /* Pagination & Info */
        #premiumTemplatesTable_wrapper .dataTables_info {
            padding-top: 16px;
            color: #71717a;
            font-size: 12px;
        }

        #premiumTemplatesTable_wrapper .dataTables_paginate {
            padding-top: 14px;
        }

        #premiumTemplatesTable_wrapper .dataTables_paginate .paginate_button {
            border-radius: 6px !important;
            padding: 4px 12px !important;
            font-size: 12px !important;
            color: #71717a !important;
            border: 1px solid transparent !important;
        }
        #premiumTemplatesTable_wrapper .dataTables_paginate .paginate_button.current {
            background: #18181b !important;
            color: #ffffff !important;
            border-color: #18181b !important;
        }
        .dark #premiumTemplatesTable_wrapper .dataTables_paginate .paginate_button.current {
            background: #ffffff !important;
            color: #18181b !important;
            border-color: #ffffff !important;
        }
        #premiumTemplatesTable_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f4f4f5 !important;
            color: #09090b !important;
            border-color: #e4e4e7 !important;
        }
        .dark #premiumTemplatesTable_wrapper .dataTables_paginate .paginate_button:hover {
            background: #27272a !important;
            color: #ffffff !important;
            border-color: #3f3f46 !important;
        }

        /* Custom Modal */
        .pt-modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(4px);
            z-index: 100000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .pt-modal-box {
            background: #ffffff;
            border: 1px solid #e4e4e7;
            border-radius: 12px;
            width: 100%;
            max-width: 600px;
            color: #09090b;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }
        .dark .pt-modal-box {
            background: #18181b;
            border-color: #27272a;
            color: #ffffff;
        }

        .pt-modal-header {
            padding: 14px 20px;
            border-bottom: 1px solid #e4e4e7;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fafafa;
        }
        .dark .pt-modal-header {
            background: #18181b;
            border-bottom-color: #27272a;
        }

        .pt-modal-body {
            padding: 20px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .pt-modal-footer {
            padding: 14px 20px;
            background: #fafafa;
            border-top: 1px solid #e4e4e7;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }
        .dark .pt-modal-footer {
            background: #121214;
            border-top-color: #27272a;
        }

        .pt-label {
            display: block;
            font-size: 11.5px;
            font-weight: 600;
            color: #52525b;
            margin-bottom: 5px;
            text-transform: capitalize;
            letter-spacing: 0.01em;
        }
        .dark .pt-label {
            color: #a1a1aa;
        }

        .pt-input {
            width: 100%;
            background: #ffffff;
            border: 1px solid #e4e4e7;
            color: #09090b;
            border-radius: 7px;
            padding: 8px 12px;
            font-size: 13px;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .pt-input:focus {
            border-color: #00bcd4;
            box-shadow: 0 0 0 1px #00bcd4;
        }
        .dark .pt-input {
            background: #27272a;
            border-color: #3f3f46;
            color: #ffffff;
        }

        /* Upload Cards */
        .template-upload-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 4px;
        }
        .template-upload-card {
            background: #fafafa;
            border: 1px solid #e4e4e7;
            border-radius: 8px;
            padding: 10px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            transition: all 0.2s;
        }
        .template-upload-card:hover {
            border-color: #00bcd4;
        }
        .dark .template-upload-card {
            background: #27272a;
            border-color: #3f3f46;
        }
        .template-upload-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .template-upload-title {
            font-size: 11px;
            font-weight: 700;
            color: #18181b;
        }
        .dark .template-upload-title {
            color: #f4f4f5;
        }
        .template-dim-badge {
            background: #f4f4f5;
            color: #71717a;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
            border: 1px solid #e4e4e7;
        }
        .dark .template-dim-badge {
            background: #18181b;
            color: #a1a1aa;
            border-color: #3f3f46;
        }
        .template-upload-dropzone {
            position: relative;
            height: 76px;
            background: #ffffff;
            border: 1px dashed #cbd5e1;
            border-radius: 6px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            cursor: pointer;
            transition: border-color 0.15s;
        }
        .template-upload-dropzone:hover {
            border-color: #00bcd4;
            background: #f8fafc;
        }
        .dark .template-upload-dropzone {
            background: #18181b;
            border-color: #3f3f46;
        }
        .template-file-input {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
            z-index: 2;
        }
        .template-upload-preview {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .btn-remove-template-img {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            background: #fef2f2;
            color: #ef4444;
            border: 1px solid #fecaca;
            border-radius: 4px;
            padding: 2px 7px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            line-height: 1.2;
            z-index: 5;
        }
        .btn-remove-template-img:hover {
            background: #ef4444;
            color: #ffffff;
            border-color: #dc2626;
            box-shadow: 0 1px 3px rgba(239, 68, 68, 0.3);
        }
        .dark .btn-remove-template-img {
            background: rgba(239, 68, 68, 0.15);
            border-color: rgba(239, 68, 68, 0.3);
            color: #f87171;
        }
        .dark .btn-remove-template-img:hover {
            background: #ef4444;
            color: #ffffff;
        }

        /* Note Banner */
        .pt-note-banner {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1d4ed8;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .dark .pt-note-banner {
            background: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.3);
            color: #60a5fa;
        }

        /* Dedicated Add / Edit Page Styles */
        .pt-form-page-container {
            max-width: 840px;
            margin: 0 auto;
            padding-bottom: 40px;
        }
        .pt-form-page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 16px;
        }
        .pt-breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: #71717a;
            margin-bottom: 6px;
        }
        .pt-breadcrumb a, .pt-breadcrumb-btn {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
            background: transparent;
            border: none;
            padding: 0;
            cursor: pointer;
            font-size: 13px;
        }
        .pt-breadcrumb a:hover, .pt-breadcrumb-btn:hover {
            text-decoration: underline;
        }
        .pt-sep {
            color: #a1a1aa;
        }
        .pt-breadcrumb-current {
            color: #18181b;
            font-weight: 600;
        }
        .dark .pt-breadcrumb-current {
            color: #f4f4f5;
        }
        .pt-page-heading {
            font-size: 24px;
            font-weight: 700;
            color: #09090b;
            margin: 0 0 4px 0;
            letter-spacing: -0.02em;
        }
        .dark .pt-page-heading {
            color: #ffffff;
        }
        .pt-page-subheading {
            font-size: 13px;
            color: #71717a;
            margin: 0;
        }
        .btn-back-to-list {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ffffff;
            border: 1px solid #e4e4e7;
            color: #09090b;
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
            transition: all 0.15s;
        }
        .btn-back-to-list:hover {
            background: #f4f4f5;
            border-color: #d4d4d8;
        }
        .dark .btn-back-to-list {
            background: #27272a;
            border-color: #3f3f46;
            color: #f4f4f5;
        }
        .pt-form-card {
            background: #ffffff;
            border: 1px solid #e4e4e7;
            border-radius: 12px;
            padding: 28px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        .dark .pt-form-card {
            background: #18181b;
            border-color: #27272a;
        }
        .btn-cancel-page {
            background: #ffffff;
            border: 1px solid #e4e4e7;
            color: #71717a;
            border-radius: 8px;
            padding: 9px 20px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-cancel-page:hover {
            background: #f4f4f5;
            color: #18181b;
        }
        .dark .btn-cancel-page {
            background: #27272a;
            border-color: #3f3f46;
            color: #a1a1aa;
        }
        .btn-submit-page {
            background: #00bcd4;
            border: none;
            color: #ffffff;
            border-radius: 8px;
            padding: 9px 24px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 188, 212, 0.25);
            transition: all 0.15s;
        }
        .btn-submit-page:hover {
            background: #00acc1;
        }
    </style>

    @if ($viewMode === 'create' || $viewMode === 'edit')
        {{-- DEDICATED CREATE / EDIT TEMPLATE PAGE --}}
        <div class="pt-form-page-container">
            {{-- Breadcrumb & Back Navigation --}}
            <div class="pt-form-page-header">
                <div>
                    <div class="pt-breadcrumb">
                        <a href="{{ route('filament.admin.resources.users.index') }}">Users</a>
                        <span class="pt-sep">/</span>
                        <button type="button" wire:click="goToList" class="pt-breadcrumb-btn">Premium Templates</button>
                        <span class="pt-sep">/</span>
                        <span class="pt-breadcrumb-current">{{ $viewMode === 'create' ? 'Create Template' : 'Edit Template' }}</span>
                    </div>
                    <h1 class="pt-page-heading">{{ $viewMode === 'create' ? 'Create Template' : 'Edit Template' }}</h1>
                    <p class="pt-page-subheading">Configure template graphics, dimensions, frames, margins, and active duration.</p>
                </div>
                <div>
                    <button type="button" wire:click="goToList" class="btn-back-to-list">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        Back to Templates
                    </button>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="pt-form-card">
                {{-- Assign User (if not scoped to specific user) --}}
                @if (!$this->userId)
                    <div style="margin-bottom: 20px;">
                        <label class="pt-label">Assign User</label>
                        <select wire:model="formUserId" class="pt-input">
                            @foreach (\App\Models\User::all() as $u)
                                <option value="{{ $u->id }}">{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                    </div>
                @elseif ($selectedUser)
                    <div style="margin-bottom: 20px; display: inline-flex; align-items: center; gap: 8px; background: #f4f4f5; padding: 6px 14px; border-radius: 8px; font-size: 12.5px; border: 1px solid #e4e4e7;">
                        <span style="color: #71717a; font-weight: 500;">Configuring for User:</span>
                        <strong style="color: #09090b;">{{ $selectedUser->name }}</strong>
                        <span style="color: #a1a1aa;">({{ $selectedUser->email }})</span>
                    </div>
                @endif

                {{-- 3 Upload Templates: Middle, Top, Bottom (200x200) --}}
                <div style="margin-bottom: 22px;">
                    <label class="pt-label" style="font-size: 12px; margin-bottom: 8px;">Template Graphics (Dimensions: 200x200)</label>
                    <div class="template-upload-grid">
                        {{-- Middle Template --}}
                        <div class="template-upload-card">
                            <div class="template-upload-header" style="display: flex; align-items: center; justify-content: space-between;">
                                <span class="template-upload-title">Middle Template</span>
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    @if ($formMiddleImage || $existingMiddleImage)
                                        <button type="button" wire:click="removeMiddleImage" class="btn-remove-template-img" title="Remove image">
                                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            Remove
                                        </button>
                                    @endif
                                    <span class="template-dim-badge">200x200</span>
                                </div>
                            </div>
                            <div class="template-upload-dropzone" style="height: 92px; cursor: pointer;" onclick="window._lastActiveUploadSlot = 'middle'; window.openGlobalFileManager();">
                                @if ($formMiddleImage && is_object($formMiddleImage))
                                    <img src="{{ $formMiddleImage->temporaryUrl() }}" class="template-upload-preview">
                                @elseif ($existingMiddleImage)
                                    <img src="{{ $this->getImageUrl($existingMiddleImage) }}" class="template-upload-preview">
                                @else
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                    <span style="font-size: 10px; color: #71717a; margin-top: 4px; font-weight: 500;">Browse File Manager (200x200)</span>
                                @endif
                            </div>
                        </div>

                        {{-- Top Template --}}
                        <div class="template-upload-card">
                            <div class="template-upload-header" style="display: flex; align-items: center; justify-content: space-between;">
                                <span class="template-upload-title">Top Template</span>
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    @if ($formTopImage || $existingTopImage)
                                        <button type="button" wire:click="removeTopImage" class="btn-remove-template-img" title="Remove image">
                                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            Remove
                                        </button>
                                    @endif
                                    <span class="template-dim-badge">200x200</span>
                                </div>
                            </div>
                            <div class="template-upload-dropzone" style="height: 92px; cursor: pointer;" onclick="window._lastActiveUploadSlot = 'top'; window.openGlobalFileManager();">
                                @if ($formTopImage && is_object($formTopImage))
                                    <img src="{{ $formTopImage->temporaryUrl() }}" class="template-upload-preview">
                                @elseif ($existingTopImage)
                                    <img src="{{ $this->getImageUrl($existingTopImage) }}" class="template-upload-preview">
                                @else
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                    <span style="font-size: 10px; color: #71717a; margin-top: 4px; font-weight: 500;">Browse File Manager (200x200)</span>
                                @endif
                            </div>
                        </div>

                        {{-- Bottom Template --}}
                        <div class="template-upload-card">
                            <div class="template-upload-header" style="display: flex; align-items: center; justify-content: space-between;">
                                <span class="template-upload-title">Bottom Template</span>
                                <div style="display: flex; align-items: center; gap: 6px;">
                                    @if ($formBottomImage || $existingBottomImage)
                                        <button type="button" wire:click="removeBottomImage" class="btn-remove-template-img" title="Remove image">
                                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                            Remove
                                        </button>
                                    @endif
                                    <span class="template-dim-badge">200x200</span>
                                </div>
                            </div>
                            <div class="template-upload-dropzone" style="height: 92px; cursor: pointer;" onclick="window._lastActiveUploadSlot = 'bottom'; window.openGlobalFileManager();">
                                @if ($formBottomImage && is_object($formBottomImage))
                                    <img src="{{ $formBottomImage->temporaryUrl() }}" class="template-upload-preview">
                                @elseif ($existingBottomImage)
                                    <img src="{{ $this->getImageUrl($existingBottomImage) }}" class="template-upload-preview">
                                @else
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                    <span style="font-size: 10px; color: #71717a; margin-top: 4px; font-weight: 500;">Browse File Manager (200x200)</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Frames & Status --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                    <div>
                        <label class="pt-label">Frames</label>
                        <select wire:model="formFrameType" class="pt-input">
                            <option value="">Select an option</option>
                            @foreach ($this->frameTypes as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="pt-label">Status</label>
                        <select wire:model="formStatus" class="pt-input">
                            <option value="Active">Active</option>
                            <option value="Deactive">Deactive</option>
                        </select>
                    </div>
                </div>

                {{-- Created Date & Up To Days --}}
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                    <div>
                        <label class="pt-label">Created Date</label>
                        <input type="date" wire:model="formCreatedDate" class="pt-input">
                    </div>
                    <div>
                        <label class="pt-label">Up To Days</label>
                        <input type="number" wire:model="formUpToDays" class="pt-input" min="0" placeholder="7" readonly>
                    </div>
                </div>

                {{-- Extra Days --}}
                <div style="margin-bottom: 18px;">
                    <label class="pt-label">Extra Days</label>
                    <input type="number" wire:model.live="formExtraDays" class="pt-input" min="0" placeholder="0">
                    <div style="font-size: 12px; color: #71717a; margin-top: 5px; font-weight: 600;">
                        Added Extra Days : {{ $formExtraDays ?? 0 }}
                    </div>
                </div>

                {{-- Margins: Margin Bottom, Margin Top, Margin Left, Margin Right --}}
                <div style="margin-bottom: 22px;">
                    <label class="pt-label" style="margin-bottom: 6px;">Margins</label>
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px;">
                        <div>
                            <label style="font-size: 11px; color: #71717a; display: block; margin-bottom: 4px; font-weight: 500;">Margin Bottom</label>
                            <input type="number" wire:model="formMarginBottom" class="pt-input" placeholder="0">
                        </div>
                        <div>
                            <label style="font-size: 11px; color: #71717a; display: block; margin-bottom: 4px; font-weight: 500;">Margin Top</label>
                            <input type="number" wire:model="formMarginTop" class="pt-input" placeholder="0">
                        </div>
                        <div>
                            <label style="font-size: 11px; color: #71717a; display: block; margin-bottom: 4px; font-weight: 500;">Margin Left</label>
                            <input type="number" wire:model="formMarginLeft" class="pt-input" placeholder="0">
                        </div>
                        <div>
                            <label style="font-size: 11px; color: #71717a; display: block; margin-bottom: 4px; font-weight: 500;">Margin Right</label>
                            <input type="number" wire:model="formMarginRight" class="pt-input" placeholder="0">
                        </div>
                    </div>
                </div>

                {{-- Note Banner --}}
                <div class="pt-note-banner" style="margin-bottom: 24px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    <span>Note : {{ $formDaysLeft ?? 0 }} Days are left..!</span>
                </div>

                {{-- Action Buttons --}}
                <div style="display: flex; align-items: center; justify-content: flex-end; gap: 12px; border-top: 1px solid #f4f4f5; padding-top: 20px;">
                    <button type="button" wire:click="goToList" class="btn-cancel-page">
                        Cancel
                    </button>
                    <button type="button" wire:click="saveTemplate" class="btn-submit-page">
                        {{ $viewMode === 'create' ? 'Create Template' : 'Save Changes' }}
                    </button>
                </div>
            </div>
        </div>
    @else
        {{-- LIST VIEW --}}
        <div class="space-y-4">
            {{-- Breadcrumb & Back navigation --}}
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #71717a;">
                    <a href="{{ route('filament.admin.resources.users.index') }}" style="color: #2563eb; text-decoration: none; display: flex; align-items: center; gap: 4px; font-weight: 500;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        Users
                    </a>
                    <span>/</span>
                    <span style="color: #09090b;" class="dark:text-white font-medium">Premium Templates</span>
                </div>

                @if ($selectedUser)
                    <div style="font-size: 12px; color: #71717a;">
                        Viewing templates for: <strong style="color: #09090b;" class="dark:text-white">{{ $selectedUser->name }}</strong>
                        <a href="{{ route('filament.admin.pages.premium-templates') }}" style="margin-left: 8px; color: #2563eb; text-decoration: none; font-size: 11px; font-weight: 500;">(Show All)</a>
                    </div>
                @endif
            </div>

            {{-- Main Container Card in Clean White Theme --}}
            <div class="premium-templates-container" wire:ignore.self>
                {{-- Header Bar --}}
                <div class="pt-header">
                    <div class="pt-title">
                        {{-- <span>Premium Templates</span> --}}
                        @if ($selectedUser)
                            <span class="pt-user-chip">👤 {{ $selectedUser->name }}</span>
                        @endif
                    </div>

                    <div style="display: flex; align-items: center; gap: 10px;">
                        <button type="button" wire:click="openCreatePage" class="btn-add-template">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            +Add User Premium Template
                        </button>

                    <button type="button" onclick="bulkDeleteSelected()" class="btn-delete-selected">
                        Delete Selected Data
                    </button>
                </div>
            </div>

            {{-- Table with exact columns from user screenshot --}}
            <div class="pt-table-wrap">
                <table id="premiumTemplatesTable" class="pt-table">
                    <thead>
                        <tr>
                            <th style="width: 32px; text-align: center;">
                                <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" style="cursor: pointer; accent-color: #00bcd4;">
                            </th>
                            <th style="width: 75px; text-align: center;">Middle Image</th>
                            <th style="width: 75px; text-align: center;">Top Image</th>
                            <th style="width: 75px; text-align: center;">Bottom Image</th>
                            <th style="min-width: 100px;">Frame Type</th>
                            <th style="width: 75px;">Status</th>
                            <th style="width: 80px;">Up To Days</th>
                            <th style="min-width: 110px;">Days</th>
                            <th style="min-width: 95px;">Created At</th>
                            <th style="width: 85px; text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->templates as $template)
                            <tr id="template-row-{{ $template->id }}">
                                <td style="text-align: center;">
                                    <input type="checkbox" class="row-select-checkbox" value="{{ $template->id }}" style="cursor: pointer; accent-color: #00bcd4;">
                                </td>

                                {{-- Middle Image --}}
                                <td style="text-align: center;">
                                    <div class="pt-image-card">
                                        @if ($template->middle_image_url)
                                            <img src="{{ $template->middle_image_url }}" alt="Middle Image">
                                        @else
                                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                            <span class="no-image-text">NO IMAGE<br>FOUND</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Top Image --}}
                                <td style="text-align: center;">
                                    <div class="pt-image-card">
                                        @if ($template->top_image_url)
                                            <img src="{{ $template->top_image_url }}" alt="Top Image">
                                        @else
                                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                            <span class="no-image-text">NO IMAGE<br>FOUND</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Bottom Image --}}
                                <td style="text-align: center;">
                                    <div class="pt-image-card">
                                        @if ($template->bottom_image_url)
                                            <img src="{{ $template->bottom_image_url }}" alt="Bottom Image">
                                        @else
                                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                            <span class="no-image-text">NO IMAGE<br>FOUND</span>
                                        @endif
                                    </div>
                                </td>

                                {{-- Frame Type --}}
                                <td>
                                    <span style="font-weight: 600; color: #09090b;" class="dark:text-white">{{ $template->frame_type }}</span>
                                    @if (!$this->userId && $template->user)
                                        <div style="font-size: 11px; color: #6366f1; margin-top: 2px; font-weight: 500;">
                                            User: {{ $template->user->name }}
                                        </div>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td>
                                    @if (strtolower($template->status) === 'active')
                                        <span class="pt-status-active">Active</span>
                                    @else
                                        <span class="pt-status-inactive">{{ $template->status }}</span>
                                    @endif
                                </td>

                                {{-- Up To Days --}}
                                <td style="font-weight: 600; color: #09090b;" class="dark:text-white">
                                    {{ $template->up_to_days }}
                                </td>

                                {{-- Days Left --}}
                                <td>
                                    <strong style="color: #09090b; font-size: 13.5px;" class="dark:text-white">{{ $template->days_left }}</strong>
                                    <span style="color: #71717a;">Days are left.!</span>
                                </td>

                                {{-- Created At --}}
                                <td style="color: #71717a; white-space: nowrap;">
                                    {{ $template->created_at ? $template->created_at->format('d M Y') : '28 Apr 2025' }}
                                </td>

                                {{-- Actions: Edit & Delete --}}
                                <td style="text-align: center; white-space: nowrap;">
                                    <div style="display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
                                        <button type="button" 
                                                wire:click="openEditPage({{ $template->id }})" 
                                                class="btn-pt-edit" 
                                                title="Edit Template">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        </button>

                                        <button type="button" 
                                                onclick="confirmDeleteTemplate({{ $template->id }})" 
                                                class="btn-pt-delete" 
                                                title="Delete Template">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

    {{-- DataTables Dependencies Scripts --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script>
        let ptDataTable = null;

        function initPTDataTable() {
            if ($.fn.DataTable.isDataTable('#premiumTemplatesTable')) {
                $('#premiumTemplatesTable').DataTable().destroy();
            }

            ptDataTable = $('#premiumTemplatesTable').DataTable({
                pageLength: 10,
                order: [[8, 'desc']],
                columnDefs: [
                    { orderable: false, targets: [0, 1, 2, 3, 9] }
                ],
                language: {
                    search: "Search:",
                    searchPlaceholder: "",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        previous: "Previous",
                        next: "Next"
                    }
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (document.getElementById('premiumTemplatesTable')) {
                initPTDataTable();
            }
        });

        document.addEventListener('livewire:navigated', function () {
            if (document.getElementById('premiumTemplatesTable')) {
                initPTDataTable();
            }
        });

        document.addEventListener('livewire:initialized', function () {
            Livewire.on('init-datatables', function () {
                setTimeout(function () {
                    if (document.getElementById('premiumTemplatesTable')) {
                        initPTDataTable();
                    }
                }, 80);
            });
        });

        // Bulk select helper
        function toggleSelectAll(masterCheckbox) {
            const checkboxes = document.querySelectorAll('.row-select-checkbox');
            checkboxes.forEach(cb => cb.checked = masterCheckbox.checked);
        }

        function bulkDeleteSelected() {
            const selected = [];
            document.querySelectorAll('.row-select-checkbox:checked').forEach(cb => {
                selected.push(parseInt(cb.value));
            });

            if (selected.length === 0) {
                alert('Please select at least one template to delete.');
                return;
            }

            if (confirm(`Are you sure you want to delete ${selected.length} selected template(s)?`)) {
                @this.deleteSelected(selected);
            }
        }

        function confirmDeleteTemplate(id) {
            if (confirm('Are you sure you want to delete this premium template?')) {
                @this.deleteTemplate(id);
            }
        }
    </script>
</x-filament-panels::page>
