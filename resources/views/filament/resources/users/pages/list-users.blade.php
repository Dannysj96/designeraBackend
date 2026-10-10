<x-filament-panels::page>
    {{-- DataTables Stylesheets --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <style>
        .dt-card {
            background: #ffffff;
            border: 1px solid #e4e4e7;
            border-radius: 12px;
            padding: 20px 16px;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.02);
            font-family: inherit;
            width: 100%;
            box-sizing: border-box;
            overflow: hidden;
        }
        .dark .dt-card {
            background: #18181b;
            border-color: #27272a;
        }

        .dt-table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-top: 6px;
            margin-bottom: 12px;
        }

        /* Custom DataTables Neutral Theme */
        .dataTables_wrapper {
            font-size: 13px;
            color: #09090b;
            width: 100%;
            box-sizing: border-box;
        }
        .dark .dataTables_wrapper {
            color: #f4f4f5;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 14px;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #e4e4e7;
            border-radius: 8px;
            padding: 5px 28px 5px 10px;
            font-size: 12px;
            background-color: #ffffff;
            color: #09090b;
            margin: 0 6px;
            outline: none;
        }
        .dark .dataTables_wrapper .dataTables_length select {
            background-color: #18181b;
            border-color: #27272a;
            color: #f4f4f5;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e4e4e7;
            border-radius: 8px;
            padding: 6px 12px;
            font-size: 12px;
            background-color: #ffffff;
            color: #09090b;
            margin-left: 8px;
            outline: none;
            width: 210px;
            transition: border-color 0.15s;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #18181b;
        }
        .dark .dataTables_wrapper .dataTables_filter input {
            background-color: #18181b;
            border-color: #27272a;
            color: #f4f4f5;
        }

        /* DataTables Buttons */
        .dt-buttons {
            margin-bottom: 14px;
            gap: 6px;
            display: inline-flex;
            flex-wrap: wrap;
        }
        .dt-button {
            background: #ffffff !important;
            border: 1px solid #e4e4e7 !important;
            border-radius: 8px !important;
            color: #18181b !important;
            padding: 5px 11px !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02) !important;
            transition: all 0.15s !important;
        }
        .dark .dt-button {
            background: #27272a !important;
            border-color: #3f3f46 !important;
            color: #f4f4f5 !important;
        }
        .dt-button:hover {
            background: #f4f4f5 !important;
            border-color: #d4d4d8 !important;
        }
        .dark .dt-button:hover {
            background: #3f3f46 !important;
        }

        /* Table Structure */
        table.dataTable {
            border-collapse: collapse !important;
            width: 100% !important;
            margin: 0 !important;
            border-bottom: 1px solid #e4e4e7 !important;
        }
        .dark table.dataTable {
            border-bottom-color: #27272a !important;
        }

        table.dataTable thead th {
            border-bottom: 1px solid #e4e4e7 !important;
            color: #71717a !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            padding: 10px 8px !important;
            background-color: transparent !important;
            white-space: nowrap !important;
        }
        .dark table.dataTable thead th {
            border-bottom-color: #27272a !important;
            color: #a1a1aa !important;
        }

        table.dataTable tbody td {
            padding: 10px 8px !important;
            border-bottom: 1px solid #f4f4f5 !important;
            vertical-align: middle !important;
            font-size: 12.5px !important;
        }
        .dark table.dataTable tbody td {
            border-bottom-color: #27272a !important;
        }

        table.dataTable tbody tr:hover {
            background-color: #fafafa !important;
        }
        .dark table.dataTable tbody tr:hover {
            background-color: #27272a80 !important;
        }

        /* Pagination & Info */
        .dataTables_wrapper .dataTables_info {
            padding-top: 12px;
            font-size: 12px;
            color: #71717a;
        }
        .dataTables_wrapper .dataTables_paginate {
            padding-top: 8px;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 8px !important;
            padding: 4px 10px !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            border: 1px solid transparent !important;
            color: #71717a !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #18181b !important;
            border-color: #18181b !important;
            color: #ffffff !important;
        }
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #ffffff !important;
            border-color: #ffffff !important;
            color: #18181b !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #f4f4f5 !important;
            border-color: #e4e4e7 !important;
            color: #09090b !important;
        }

        /* ===================== NEUTRAL STATUS & PILLS =====================
           No semantic color fills — status is conveyed with icon + weight,
           not hue, so the table reads as one calm tone. */
        .pill-active {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 10.5px;
            font-weight: 600;
            background-color: #f4f4f5;
            color: #18181b;
            border: 1px solid #e4e4e7;
            white-space: nowrap;
        }
        .dark .pill-active {
            background-color: #27272a;
            color: #f4f4f5;
            border-color: #3f3f46;
        }
        .pill-active svg { color: #52525b; }
        .dark .pill-active svg { color: #a1a1aa; }

        .pill-inactive {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 10.5px;
            font-weight: 600;
            background-color: #fafafa;
            color: #a1a1aa;
            border: 1px solid #ececec;
            white-space: nowrap;
        }
        .dark .pill-inactive {
            background-color: #18181b;
            color: #71717a;
            border-color: #27272a;
        }

        .pill-suspended {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 10.5px;
            font-weight: 600;
            background-color: #ffffff;
            color: #52525b;
            border: 1px solid #d4d4d8;
            white-space: nowrap;
        }
        .dark .pill-suspended {
            background-color: #18181b;
            color: #d4d4d8;
            border-color: #3f3f46;
        }

        .pill-feature {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 1px 6px;
            border-radius: 4px;
            font-size: 9.5px;
            font-weight: 600;
            background-color: #f4f4f5;
            color: #3f3f46;
            border: 1px solid #e4e4e7;
            white-space: nowrap;
        }
        .dark .pill-feature {
            background-color: #27272a;
            color: #d4d4d8;
            border-color: #3f3f46;
        }

        .badge-party {
            display: inline-block;
            padding: 1px 6px;
            border-radius: 4px;
            font-size: 10.5px;
            font-weight: 600;
            background-color: #f4f4f5;
            color: #18181b;
            border: 1px solid #e4e4e7;
            white-space: nowrap;
        }
        .dark .badge-party {
            background-color: #27272a;
            color: #f4f4f5;
            border-color: #3f3f46;
        }

        .badge-lang {
            display: inline-block;
            padding: 1px 5px;
            border-radius: 4px;
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            background-color: #f4f4f5;
            color: #52525b;
        }
        .dark .badge-lang {
            background-color: #27272a;
            color: #a1a1aa;
        }

        .badge-template-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            background: #f4f4f5;
            color: #18181b;
            border: 1px solid #e4e4e7;
            white-space: nowrap;
        }
        .dark .badge-template-chip {
            background: #27272a;
            border-color: #3f3f46;
            color: #f4f4f5;
        }

        /* ===================== AVATAR (neutral initials, no gradient) ===================== */
        .avatar-initials {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #f4f4f5;
            color: #3f3f46;
            border: 1px solid #e4e4e7;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            flex-shrink: 0;
        }
        .dark .avatar-initials {
            background: #27272a;
            color: #e4e4e7;
            border-color: #3f3f46;
        }

        /* ===================== SOCIAL ICONS (monochrome outline) ===================== */
        .social-icon-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 21px;
            height: 21px;
            border-radius: 5px;
            background: #f4f4f5;
            color: #52525b;
            border: 1px solid #e4e4e7;
            font-size: 10px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.15s;
        }
        .social-icon-link:hover {
            background: #e4e4e7;
            color: #18181b;
        }
        .dark .social-icon-link {
            background: #27272a;
            color: #a1a1aa;
            border-color: #3f3f46;
        }
        .dark .social-icon-link:hover {
            background: #3f3f46;
            color: #f4f4f5;
        }

        /* GEAR TRIGGER BUTTON — neutral, matches the rest of the UI */
        .btn-gear-trigger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 7px;
            border: 1px solid #e4e4e7;
            background: #ffffff;
            color: #52525b;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
            flex-shrink: 0;
        }
        .btn-gear-trigger:hover,
        .btn-gear-trigger:focus {
            background: #f4f4f5;
            border-color: #d4d4d8;
            color: #18181b;
            outline: none;
        }
        .dark .btn-gear-trigger {
            background: #27272a;
            border-color: #3f3f46;
            color: #d4d4d8;
        }
        .dark .btn-gear-trigger:hover,
        .dark .btn-gear-trigger:focus {
            background: #3f3f46;
            color: #ffffff;
        }

        /* DROPDOWN MENU — light, neutral card (matches modals/table instead of a dark navy popover) */
        .action-dropdown-menu {
            position: fixed;
            width: 215px;
            background: #ffffff;
            border: 1px solid #e4e4e7;
            border-radius: 9px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
            z-index: 99999;
            padding: 6px 0;
            font-family: inherit;
            text-align: left;
        }
        .dark .action-dropdown-menu {
            background: #18181b;
            border-color: #27272a;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5);
        }

        .dropdown-item-link {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 8px 14px;
            font-size: 13px;
            font-weight: 500;
            color: #3f3f46;
            text-decoration: none;
            transition: all 0.15s;
            background: transparent;
            border: none;
            cursor: pointer;
            box-sizing: border-box;
            text-align: left;
        }
        .dropdown-item-link:hover {
            background: #f4f4f5;
            color: #09090b;
        }
        .dropdown-item-link svg {
            flex-shrink: 0;
            color: #a1a1aa;
            transition: color 0.15s;
        }
        .dropdown-item-link:hover svg {
            color: #18181b;
        }
        .dark .dropdown-item-link {
            color: #d4d4d8;
        }
        .dark .dropdown-item-link:hover {
            background: #27272a;
            color: #ffffff;
        }
        .dark .dropdown-item-link svg {
            color: #71717a;
        }
        .dark .dropdown-item-link:hover svg {
            color: #ffffff;
        }

        /* ACTION BUTTONS */
        .btn-action-primary {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 4px 8px;
            border-radius: 6px;
            border: 1px solid #e4e4e7;
            background: #ffffff;
            color: #18181b;
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.15s;
            white-space: nowrap;
        }
        .btn-action-primary:hover {
            background: #f4f4f5;
            border-color: #d4d4d8;
            color: #09090b;
        }
        .dark .btn-action-primary {
            background: #27272a;
            border-color: #3f3f46;
            color: #f4f4f5;
        }
        .dark .btn-action-primary:hover {
            background: #3f3f46;
        }

        .btn-action-danger {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 25px;
            height: 25px;
            border-radius: 6px;
            border: 1px solid #e4e4e7;
            background: #ffffff;
            color: #3f3f46;
            cursor: pointer;
            transition: all 0.15s;
            flex-shrink: 0;
        }
        .btn-action-danger:hover {
            background: #f4f4f5;
            border-color: #d4d4d8;
            color: #18181b;
        }
        .dark .btn-action-danger {
            background: #27272a;
            border-color: #3f3f46;
            color: #d4d4d8;
        }
        .dark .btn-action-danger:hover {
            background: #3f3f46;
            color: #ffffff;
        }

        /* Modal Styles */
        .custom-modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(4px);
            z-index: 100000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .custom-modal-content {
            background: #ffffff;
            border-radius: 12px;
            width: 100%;
            max-width: 480px;
            border: 1px solid #e4e4e7;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: modalFadeIn 0.2s ease-out;
        }
        .custom-modal-content-lg {
            max-width: 760px;
            width: 95%;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }
        .dark .custom-modal-content {
            background: #18181b;
            border-color: #27272a;
        }

        .badge-plan-trigger {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 7px;
            background: #f4f4f5;
            color: #18181b;
            border: 1px solid #e4e4e7;
            border-radius: 9999px;
            font-size: 10.5px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .badge-plan-trigger:hover {
            background: #18181b;
            color: #ffffff;
            border-color: #18181b;
        }
        .dark .badge-plan-trigger {
            background: #27272a;
            color: #f4f4f5;
            border-color: #3f3f46;
        }
        .dark .badge-plan-trigger:hover {
            background: #ffffff;
            color: #18181b;
            border-color: #ffffff;
        }

        .plan-status-active {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .dark .plan-status-active {
            background: #064e3b;
            color: #a7f3d0;
            border-color: #059669;
        }

        .plan-status-expired {
            background: #f4f4f5;
            color: #71717a;
            border: 1px solid #e4e4e7;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .dark .plan-status-expired {
            background: #27272a;
            color: #a1a1aa;
            border-color: #3f3f46;
        }

        .plan-status-upgraded {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .dark .plan-status-upgraded {
            background: #1e3a8a;
            color: #bfdbfe;
            border-color: #2563eb;
        }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.96); }
            to { opacity: 1; transform: scale(1); }
        }

        .modal-header {
            padding: 16px 20px;
            border-bottom: 1px solid #e4e4e7;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .dark .modal-header {
            border-bottom-color: #27272a;
        }

        .modal-body {
            padding: 18px 20px;
        }

        .modal-footer {
            padding: 12px 20px;
            background: #fafafa;
            border-top: 1px solid #e4e4e7;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }
        .dark .modal-footer {
            background: #121214;
            border-top-color: #27272a;
        }

        .form-input-box {
            width: 100%;
            border: 1px solid #e4e4e7;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 13px;
            background-color: #ffffff;
            color: #09090b;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.15s;
        }
        .form-input-box:focus {
            border-color: #18181b;
        }
        .dark .form-input-box {
            background-color: #27272a;
            border-color: #3f3f46;
            color: #f4f4f5;
        }

        .btn-submit-action {
            padding: 6px 16px;
            border-radius: 7px;
            background: #18181b;
            color: #ffffff;
            font-size: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-submit-action:hover {
            background: #27272a;
        }
        .dark .btn-submit-action {
            background: #ffffff;
            color: #18181b;
        }
        .dark .btn-submit-action:hover {
            background: #f4f4f5;
        }

        .btn-submit-action-secondary {
            padding: 6px 16px;
            border-radius: 7px;
            background: #ffffff;
            color: #18181b;
            font-size: 12px;
            font-weight: 600;
            border: 1px solid #d4d4d8;
            cursor: pointer;
            transition: all 0.15s;
        }
        .btn-submit-action-secondary:hover {
            background: #f4f4f5;
        }
        .dark .btn-submit-action-secondary {
            background: #27272a;
            color: #f4f4f5;
            border-color: #3f3f46;
        }
        .dark .btn-submit-action-secondary:hover {
            background: #3f3f46;
        }

        .btn-cancel-modal {
            padding: 6px 14px;
            border-radius: 7px;
            background: #ffffff;
            border: 1px solid #e4e4e7;
            font-size: 12px;
            font-weight: 600;
            color: #71717a;
            cursor: pointer;
        }
        .dark .btn-cancel-modal {
            background: #27272a;
            border-color: #3f3f46;
            color: #a1a1aa;
        }

        /* Neutral text helpers used in place of green/red inline colors */
        .text-muted { color: #71717a; }
        .dark .text-muted { color: #a1a1aa; }
        .text-primary { color: #09090b; }
        .dark .text-primary { color: #f4f4f5; }
        .text-strong { color: #18181b; font-weight: 700; }
        .dark .text-strong { color: #f4f4f5; }
    </style>

    <div class="space-y-4">
        {{-- DataTables Card Container --}}
        <div class="dt-card" wire:ignore>
            <div class="dt-table-responsive">
                <table id="usersTable" class="dataTable" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 32px; text-align: center;">#</th>
                            <th style="min-width: 170px;">User Profile</th>
                            <th style="min-width: 140px;">Contact</th>
                            <th style="min-width: 130px;">Location & Party</th>
                            <th style="min-width: 140px;">Limits & Privileges</th>
                            <th style="width: 90px; text-align: center;">Social</th>
                            <th style="width: 80px; text-align: center;">Status</th>
                            <th style="width: 125px; text-align: center;">Template</th>
                            <th style="width: 85px; text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->users as $user)
                            <tr id="user-row-{{ $user->id }}">
                                <td style="font-weight: 600; color: #a1a1aa; text-align: center;">
                                    #{{ $user->id }}
                                </td>
                                <td>
                                    {{-- CLEAN USER PROFILE: AVATAR + NAME + WALLET --}}
                                    <div style="display: flex; align-items: center; gap: 9px;">
                                        {{-- User Photo or Initials --}}
                                        @if ($user->profile_photo_url)
                                            <img src="{{ $user->profile_photo_url }}"
                                                 alt="{{ $user->name }}"
                                                 style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 1px solid #e4e4e7; flex-shrink: 0;">
                                        @else
                                            <div class="avatar-initials">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                        @endif

                                        {{-- Name & Details --}}
                                        <div>
                                            <div style="font-weight: 600; font-size: 13px;" class="text-primary">
                                                {{ $user->name }}
                                            </div>
                                            @php
                                                $activePlan = $user->activePlanHistory;
                                                $currentPlanName = $activePlan ? $activePlan->plan_name : ($user->plan?->name ?? ($user->plan_id ? 'Plan #' . $user->plan_id : '24 hrs Free Trial'));
                                                $remDays = $activePlan ? $activePlan->remaining_days : null;
                                            @endphp
                                            <div style="font-size: 11px; color: #a1a1aa; display: flex; align-items: center; gap: 4px; flex-wrap: wrap; margin-top: 2px;">
                                                <span class="badge-lang">{{ $user->language ?? 'en' }}</span>
                                                <span>&bull;</span>
                                                <span title="Wallet Balance" class="text-strong" style="font-size: 11px;">₹{{ number_format($user->wallet_balance ?? 0, 0) }}</span>
                                                <span>&bull;</span>
                                                <button type="button"
                                                        onclick="openPlanHistoryModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                                        class="badge-plan-trigger"
                                                        title="Click to view Plan History">
                                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                                    <span>{{ $currentPlanName }}</span>
                                                    @if ($remDays !== null && $remDays > 0)
                                                        <span style="opacity: 0.85; font-size: 9.5px;">({{ $remDays }}d)</span>
                                                    @endif
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 12.5px;" class="text-primary font-medium">
                                        {{ $user->email }}
                                    </div>
                                    @if ($user->mobile)
                                        <div style="font-size: 11px; color: #71717a; display: flex; align-items: center; gap: 3px; margin-top: 1px;">
                                            <span>&#9742;</span> {{ $user->mobile }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->party)
                                        <div>
                                            <span class="badge-party">{{ $user->party }}</span>
                                        </div>
                                    @endif
                                    <div style="font-size: 11px; color: #71717a; margin-top: 2px;">
                                        @if ($user->city || $user->state)
                                            {{ $user->city ?? '' }}{{ $user->city && $user->state ? ', ' : '' }}{{ $user->state ?? '' }}
                                        @endif
                                        @if (($user->city || $user->state) && ($user->designation_1 || $user->designation_2)) &bull; @endif
                                        {{ $user->designation_1 ?? $user->designation_2 ?? '' }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 11px;" class="text-primary">
                                        <span style="color: #71717a;">Limits:</span>
                                        <strong>{{ $user->daily_download_limit_video ?? 0 }}</strong> vid / <strong>{{ $user->daily_download_limit_design ?? 0 }}</strong> des
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 4px; margin-top: 3px;">
                                        @if ($user->remove_watermark)
                                            <span class="pill-feature" title="Watermark removal enabled">No Watermark</span>
                                        @endif
                                        @if ($user->remove_copyright)
                                            <span class="pill-feature" title="Copyright removal enabled">No Copyright</span>
                                        @endif
                                        @if (!$user->remove_watermark && !$user->remove_copyright)
                                            <span style="color: #a1a1aa; font-size: 10.5px;">Standard</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; justify-content: center; gap: 4px;">
                                        @if ($user->whatsapp)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->whatsapp) }}" target="_blank" title="WhatsApp: {{ $user->whatsapp }}" class="social-icon-link">
                                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                            </a>
                                        @endif
                                        @if ($user->facebook)
                                            <a href="{{ $user->facebook }}" target="_blank" title="Facebook" class="social-icon-link">
                                                <span style="font-size: 11px; font-weight: 700;">f</span>
                                            </a>
                                        @endif
                                        @if ($user->twitter)
                                            <a href="{{ str_starts_with($user->twitter, 'http') ? $user->twitter : 'https://x.com/' . ltrim($user->twitter, '@') }}" target="_blank" title="Twitter / X" class="social-icon-link">
                                                <span style="font-size: 10px; font-weight: 700;">X</span>
                                            </a>
                                        @endif
                                        @if ($user->instagram)
                                            <a href="{{ str_starts_with($user->instagram, 'http') ? $user->instagram : 'https://instagram.com/' . ltrim($user->instagram, '@') }}" target="_blank" title="Instagram" class="social-icon-link">
                                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                                            </a>
                                        @endif
                                        @if (!$user->whatsapp && !$user->facebook && !$user->twitter && !$user->instagram)
                                            <span style="color: #a1a1aa; font-size: 11px;">—</span>
                                        @endif
                                    </div>
                                </td>
                                <td style="text-align: center;">
                                    @php
                                        $status = strtolower($user->status ?? 'active');
                                    @endphp
                                    @if ($status === 'active')
                                        <span class="pill-active">
                                            <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                            Active
                                        </span>
                                    @elseif ($status === 'suspended')
                                        <span class="pill-suspended">
                                            <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                                            </svg>
                                            Suspended
                                        </span>
                                    @else
                                        <span class="pill-inactive">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                {{-- TEMPLATE COLUMN (SEPARATE DEDICATED COLUMN) --}}
                                <td style="text-align: center; vertical-align: middle; white-space: nowrap;">
                                    <div style="display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
                                        {{-- GEAR TRIGGER BUTTON --}}
                                        <div class="action-dropdown-wrapper" style="position: relative; display: inline-block;">
                                            <button type="button"
                                                    onclick="toggleUserDropdown(event, {{ $user->id }})"
                                                    class="btn-gear-trigger"
                                                    title="Template & User Options">
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="8" cy="8" r="2.5"></circle>
                                                    <path d="M8 2v2m0 8v2m-6-6h2m8 0h2m-1.5-4.5l-1.4 1.4m-4.2 4.2l-1.4 1.4m0-7l1.4 1.4m4.2 4.2l1.4 1.4"></path>
                                                    <circle cx="16" cy="16" r="2.5"></circle>
                                                    <path d="M16 11v1.5m0 7v1.5m-4.5-4.5h1.5m7 0h1.5m-1.4-3.4l-1.1 1.1m-3.2 3.2l-1.1 1.1m0-5.4l1.1 1.1m3.2 3.2l1.1 1.1"></path>
                                                </svg>
                                            </button>

                                            {{-- DROPDOWN MENU --}}
                                            <div id="dropdown-menu-{{ $user->id }}" class="action-dropdown-menu" style="display: none;">
                                                <a href="{{ route('filament.admin.pages.premium-templates', ['user_id' => $user->id]) }}"
                                                   class="dropdown-item-link">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                                    <span>Premium Template</span>
                                                </a>

                                                <button type="button"
                                                        onclick="openVideoTemplateModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                                        class="dropdown-item-link">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>
                                                    <span>Premium Video Template</span>
                                                </button>

                                                <button type="button"
                                                        onclick="openWalletHistoryModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->wallet_balance ?? 0 }}')"
                                                        class="dropdown-item-link">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"></path><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"></path><path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z"></path></svg>
                                                    <span>Wallet History</span>
                                                </button>

                                                <button type="button"
                                                        onclick="openAddMoneyModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->wallet_balance ?? 0 }}')"
                                                        class="dropdown-item-link">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="6" width="20" height="12" rx="2"></rect><circle cx="12" cy="12" r="2"></circle><path d="M6 12h.01M18 12h.01"></path></svg>
                                                    <span>Add Money</span>
                                                </button>

                                                <button type="button"
                                                        onclick="openRemoveMoneyModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->wallet_balance ?? 0 }}')"
                                                        class="dropdown-item-link">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="6" width="20" height="12" rx="2"></rect><circle cx="12" cy="12" r="2"></circle><path d="M6 12h.01M18 12h.01"></path></svg>
                                                    <span>Remove Money</span>
                                                </button>

                                                <button type="button"
                                                        onclick="openPlanHistoryModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                                        class="dropdown-item-link">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                                    <span>Plan History</span>
                                                </button>

                                                <button type="button"
                                                        onclick="openUpgradePlanModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->plan?->name ?? $user->plan_id ?? '24 hrs Free Trial') }}')"
                                                        class="dropdown-item-link">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="17 11 12 6 7 11"></polyline><polyline points="17 18 12 13 7 18"></polyline></svg>
                                                    <span>Upgrade Plan</span>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </td>

                                {{-- ACTION COLUMN (SEPARATE CLEAN EDIT & DELETE) --}}
                                <td style="text-align: right; vertical-align: middle; white-space: nowrap;">
                                    <div style="display: inline-flex; align-items: center; justify-content: flex-end; gap: 5px;">
                                        <a href="{{ route('filament.admin.resources.users.edit', ['record' => $user->id]) }}"
                                           class="btn-action-primary"
                                           title="Edit User">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                            </svg>
                                            <span>Edit</span>
                                        </a>

                                        <button type="button"
                                                onclick="confirmDeleteUser({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                                class="btn-action-danger"
                                                title="Delete User">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            </svg>
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

    {{-- MODAL 1: PREMIUM TEMPLATE --}}
    <div id="premiumTemplateModal" class="custom-modal-overlay" wire:ignore.self style="display: none;">
        <div class="custom-modal-content">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div>
                        <h3 id="ptModalUserName" style="font-size: 14px; font-weight: 700; color: #09090b; margin: 0;" class="dark:text-white">Premium Template</h3>
                        <p style="font-size: 11px; color: #71717a; margin: 0;">Active poster frame & branding templates</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('premiumTemplateModal')" style="background: transparent; border: none; font-size: 18px; color: #a1a1aa; cursor: pointer;">&times;</button>
            </div>
            <div class="modal-body space-y-3">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div style="border: 2px solid #18181b; border-radius: 8px; padding: 10px; background: #fafafa;" class="dark:bg-zinc-900 dark:border-white">
                        <div style="font-size: 11px; font-weight: 700; color: #52525b; margin-bottom: 4px;">✓ ACTIVE TEMPLATE</div>
                        <div style="font-size: 13px; font-weight: 600; color: #09090b;" class="dark:text-white">Political Frame #1</div>
                        <p style="font-size: 11px; color: #71717a; margin-top: 2px;">Bottom bar with photo & 2 designations</p>
                    </div>
                    <div style="border: 1px solid #e4e4e7; border-radius: 8px; padding: 10px; background: #ffffff; cursor: pointer;" class="dark:bg-zinc-900 dark:border-zinc-800">
                        <div style="font-size: 11px; font-weight: 600; color: #71717a; margin-bottom: 4px;">OPTION 2</div>
                        <div style="font-size: 13px; font-weight: 600; color: #09090b;" class="dark:text-white">Festival Ribbon #2</div>
                        <p style="font-size: 11px; color: #71717a; margin-top: 2px;">Modern corner badge with gold ribbon</p>
                    </div>
                </div>
                <div style="padding: 10px; background: #f4f4f5; border-radius: 8px; font-size: 12px; color: #52525b;" class="dark:bg-zinc-900 dark:text-zinc-400">
                    All premium templates automatically merge user profile photo, party logo, and contact details.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('premiumTemplateModal')" class="btn-cancel-modal">Close</button>
                <button type="button" onclick="saveTemplateSelection()" class="btn-submit-action">Apply Template</button>
            </div>
        </div>
    </div>

    {{-- MODAL 2: PREMIUM VIDEO TEMPLATE --}}
    <div id="videoTemplateModal" class="custom-modal-overlay" wire:ignore.self style="display: none;">
        <div class="custom-modal-content">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div>
                        <h3 id="vtModalUserName" style="font-size: 14px; font-weight: 700; color: #09090b; margin: 0;" class="dark:text-white">Premium Video Template</h3>
                        <p style="font-size: 11px; color: #71717a; margin: 0;">Animated video reels & motion poster templates</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('videoTemplateModal')" style="background: transparent; border: none; font-size: 18px; color: #a1a1aa; cursor: pointer;">&times;</button>
            </div>
            <div class="modal-body space-y-3">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div style="border: 2px solid #18181b; border-radius: 8px; padding: 10px; background: #fafafa;" class="dark:bg-zinc-900 dark:border-white">
                        <div style="font-size: 11px; font-weight: 700; color: #52525b; margin-bottom: 4px;">✓ ACTIVE REEL</div>
                        <div style="font-size: 13px; font-weight: 600; color: #09090b;" class="dark:text-white">9:16 Story Motion</div>
                        <p style="font-size: 11px; color: #71717a; margin-top: 2px;">Full HD animated lower-third overlay</p>
                    </div>
                    <div style="border: 1px solid #e4e4e7; border-radius: 8px; padding: 10px; background: #ffffff; cursor: pointer;" class="dark:bg-zinc-900 dark:border-zinc-800">
                        <div style="font-size: 11px; font-weight: 600; color: #71717a; margin-bottom: 4px;">OPTION 2</div>
                        <div style="font-size: 13px; font-weight: 600; color: #09090b;" class="dark:text-white">1:1 Square Feed Video</div>
                        <p style="font-size: 11px; color: #71717a; margin-top: 2px;">Square frame with audio waveform bar</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('videoTemplateModal')" class="btn-cancel-modal">Close</button>
                <button type="button" onclick="closeModal('videoTemplateModal')" class="btn-submit-action">Save Video Format</button>
            </div>
        </div>
    </div>

    {{-- MODAL 3: WALLET HISTORY --}}
    <div id="walletHistoryModal" class="custom-modal-overlay" wire:ignore.self style="display: none;">
        <div class="custom-modal-content">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div>
                        <h3 id="whModalUserName" style="font-size: 14px; font-weight: 700; color: #09090b; margin: 0;" class="dark:text-white">Wallet History</h3>
                        <p id="whModalBalance" style="font-size: 11px; color: #52525b; margin: 0; font-weight: 600;">Current Balance: ₹0.00</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('walletHistoryModal')" style="background: transparent; border: none; font-size: 18px; color: #a1a1aa; cursor: pointer;">&times;</button>
            </div>
            <div class="modal-body space-y-2">
                <div style="font-size: 11px; font-weight: 600; color: #71717a; text-transform: uppercase;">Recent Transactions</div>
                <div style="border: 1px solid #e4e4e7; border-radius: 8px; overflow: hidden; font-size: 12px;" class="dark:border-zinc-800">
                    <div style="display: flex; justify-content: space-between; padding: 9px 12px; border-bottom: 1px solid #f4f4f5; background: #ffffff;" class="dark:bg-zinc-900 dark:border-zinc-800">
                        <div>
                            <div style="font-weight: 600; color: #09090b;" class="dark:text-white">Admin Wallet Credit</div>
                            <div style="font-size: 10.5px; color: #71717a;">Opening Balance Deposit</div>
                        </div>
                        <div style="text-align: right;">
                            <span class="text-strong">+₹500.00</span>
                            <div style="font-size: 10px; color: #a1a1aa;">Completed</div>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 9px 12px; background: #ffffff;" class="dark:bg-zinc-900">
                        <div>
                            <div style="font-weight: 600; color: #09090b;" class="dark:text-white">Plan Purchase</div>
                            <div style="font-size: 10.5px; color: #71717a;">Basic Plan Activation</div>
                        </div>
                        <div style="text-align: right;">
                            <span class="text-muted" style="font-weight: 700;">-₹199.00</span>
                            <div style="font-size: 10px; color: #a1a1aa;">Completed</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('walletHistoryModal')" class="btn-cancel-modal">Close</button>
            </div>
        </div>
    </div>

    {{-- MODAL 4: ADD MONEY --}}
    <div id="addMoneyModal" class="custom-modal-overlay" wire:ignore.self style="display: none;">
        <div class="custom-modal-content">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div>
                        <h3 id="amModalUserName" style="font-size: 14px; font-weight: 700; color: #09090b; margin: 0;" class="dark:text-white">Add Money</h3>
                        <p id="amModalCurrentBal" style="font-size: 11px; color: #71717a; margin: 0;">Current: ₹0.00</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('addMoneyModal')" style="background: transparent; border: none; font-size: 18px; color: #a1a1aa; cursor: pointer;">&times;</button>
            </div>
            <div class="modal-body space-y-3">
                <input type="hidden" id="amUserId">
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 600; color: #71717a; margin-bottom: 4px; text-transform: uppercase;">Amount (₹)</label>
                    <input type="number" id="amAmount" class="form-input-box" placeholder="e.g. 500" value="500" min="1" step="1">
                </div>
                <div style="display: flex; gap: 6px;">
                    <button type="button" onclick="setAddAmount(100)" class="btn-cancel-modal" style="padding: 3px 8px; font-size: 11px;">+₹100</button>
                    <button type="button" onclick="setAddAmount(500)" class="btn-cancel-modal" style="padding: 3px 8px; font-size: 11px;">+₹500</button>
                    <button type="button" onclick="setAddAmount(1000)" class="btn-cancel-modal" style="padding: 3px 8px; font-size: 11px;">+₹1,000</button>
                    <button type="button" onclick="setAddAmount(2000)" class="btn-cancel-modal" style="padding: 3px 8px; font-size: 11px;">+₹2,000</button>
                </div>
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 600; color: #71717a; margin-bottom: 4px; text-transform: uppercase;">Note / Reference</label>
                    <input type="text" id="amNote" class="form-input-box" placeholder="e.g. UPI payment, recharge">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('addMoneyModal')" class="btn-cancel-modal">Cancel</button>
                <button type="button" onclick="submitAddMoney()" class="btn-submit-action">Add to Wallet</button>
            </div>
        </div>
    </div>

    {{-- MODAL 5: REMOVE MONEY --}}
    <div id="removeMoneyModal" class="custom-modal-overlay" wire:ignore.self style="display: none;">
        <div class="custom-modal-content">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div>
                        <h3 id="rmModalUserName" style="font-size: 14px; font-weight: 700; color: #09090b; margin: 0;" class="dark:text-white">Remove Money</h3>
                        <p id="rmModalCurrentBal" style="font-size: 11px; color: #71717a; margin: 0;">Current: ₹0.00</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('removeMoneyModal')" style="background: transparent; border: none; font-size: 18px; color: #a1a1aa; cursor: pointer;">&times;</button>
            </div>
            <div class="modal-body space-y-3">
                <input type="hidden" id="rmUserId">
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 600; color: #71717a; margin-bottom: 4px; text-transform: uppercase;">Amount to Deduct (₹)</label>
                    <input type="number" id="rmAmount" class="form-input-box" placeholder="e.g. 100" value="100" min="1" step="1">
                </div>
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 600; color: #71717a; margin-bottom: 4px; text-transform: uppercase;">Reason</label>
                    <input type="text" id="rmReason" class="form-input-box" placeholder="e.g. Refund, correction, penalty">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('removeMoneyModal')" class="btn-cancel-modal">Cancel</button>
                <button type="button" onclick="submitRemoveMoney()" class="btn-submit-action-secondary">Deduct from Wallet</button>
            </div>
        </div>
    </div>

    {{-- MODAL 6: UPGRADE PLAN --}}
    <div id="upgradePlanModal" class="custom-modal-overlay" wire:ignore.self style="display: none;">
        <div class="custom-modal-content">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div>
                        <h3 id="upModalUserName" style="font-size: 14px; font-weight: 700; color: #09090b; margin: 0;" class="dark:text-white">Upgrade / Assign Plan</h3>
                        <p id="upModalCurrentPlan" style="font-size: 11px; color: #71717a; margin: 0;">Current: 24 hrs Free Trial</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('upgradePlanModal')" style="background: transparent; border: none; font-size: 18px; color: #a1a1aa; cursor: pointer;">&times;</button>
            </div>
            <div class="modal-body space-y-3">
                <input type="hidden" id="upUserId">
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 600; color: #71717a; margin-bottom: 4px; text-transform: uppercase;">Select Plan</label>
                    <select id="upPlanSelect" class="form-input-box">
                        @forelse ($this->plans as $plan)
                            <option value="{{ $plan->id }}">
                                {{ $plan->name }} (₹{{ number_format($plan->price ?? 0, 0) }} • {{ $plan->duration_days ?? 30 }} Days)
                            </option>
                        @empty
                            <option value="">No plans available</option>
                        @endforelse
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 11px; font-weight: 600; color: #71717a; margin-bottom: 4px; text-transform: uppercase;">Note / Reason (Optional)</label>
                    <input type="text" id="upPlanNote" class="form-input-box" placeholder="e.g. Plan activated manually by Admin">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeModal('upgradePlanModal')" class="btn-cancel-modal">Cancel</button>
                <button type="button" onclick="submitUpgradePlan()" class="btn-submit-action">Activate Plan</button>
            </div>
        </div>
    </div>

    {{-- MODAL 7: PLAN HISTORY MODAL --}}
    <div id="planHistoryModal" class="custom-modal-overlay" wire:ignore.self style="display: none;">
        <div class="custom-modal-content custom-modal-content-lg">
            <div class="modal-header">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div>
                        <h3 id="phModalUserName" style="font-size: 15px; font-weight: 700; color: #09090b; margin: 0;" class="dark:text-white">Plan History</h3>
                        <p id="phModalSubTitle" style="font-size: 11px; color: #71717a; margin: 0;">Subscription & plan purchase records</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('planHistoryModal')" style="background: transparent; border: none; font-size: 18px; color: #a1a1aa; cursor: pointer;">&times;</button>
            </div>
            <div class="modal-body" style="overflow-y: auto; max-height: calc(85vh - 130px); padding: 16px 20px;">
                {{-- Quick Summary Stats --}}
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px; margin-bottom: 16px;">
                    <div style="background: #fafafa; border: 1px solid #e4e4e7; border-radius: 8px; padding: 10px 14px;" class="dark:bg-zinc-900 dark:border-zinc-800">
                        <div style="font-size: 10px; font-weight: 600; color: #71717a; text-transform: uppercase;">Active Plan</div>
                        <div id="phCurrentPlanText" style="font-size: 14px; font-weight: 700; color: #09090b; margin-top: 2px;" class="dark:text-white">—</div>
                    </div>
                    <div style="background: #fafafa; border: 1px solid #e4e4e7; border-radius: 8px; padding: 10px 14px;" class="dark:bg-zinc-900 dark:border-zinc-800">
                        <div style="font-size: 10px; font-weight: 600; color: #71717a; text-transform: uppercase;">Wallet Balance</div>
                        <div id="phWalletBalanceText" style="font-size: 14px; font-weight: 700; color: #047857; margin-top: 2px;">₹0.00</div>
                    </div>
                    <div style="background: #fafafa; border: 1px solid #e4e4e7; border-radius: 8px; padding: 10px 14px;" class="dark:bg-zinc-900 dark:border-zinc-800">
                        <div style="font-size: 10px; font-weight: 600; color: #71717a; text-transform: uppercase;">Total Subscriptions</div>
                        <div id="phTotalPlansCount" style="font-size: 14px; font-weight: 700; color: #09090b; margin-top: 2px;" class="dark:text-white">0</div>
                    </div>
                </div>

                {{-- Table/List Container --}}
                <div style="font-size: 11px; font-weight: 700; color: #71717a; text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.04em;">All Plan Subscriptions</div>
                
                <div id="phLoadingState" style="text-align: center; padding: 30px; color: #71717a; font-size: 12.5px;">
                    <div style="display: inline-block; width: 24px; height: 24px; border: 2px solid #e4e4e7; border-top-color: #18181b; border-radius: 50%; animation: spin 0.8s linear infinite; margin-bottom: 8px;"></div>
                    <div>Loading plan history...</div>
                </div>

                <div id="phEmptyState" style="display: none; text-align: center; padding: 36px 16px; background: #fafafa; border: 1px dashed #d4d4d8; border-radius: 8px;" class="dark:bg-zinc-900 dark:border-zinc-800">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#a1a1aa" stroke-width="1.8" style="margin: 0 auto 8px;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <div style="font-weight: 600; font-size: 13px; color: #09090b;" class="dark:text-white">No Plan History Found</div>
                    <p style="font-size: 11.5px; color: #71717a; margin-top: 4px;">This user has not been assigned any subscription plans yet.</p>
                </div>

                <div id="phTableWrapper" style="display: none; border: 1px solid #e4e4e7; border-radius: 8px; overflow: hidden;" class="dark:border-zinc-800">
                    <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                        <thead style="background: #fafafa; border-bottom: 1px solid #e4e4e7;" class="dark:bg-zinc-900 dark:border-zinc-800">
                            <tr>
                                <th style="text-align: left; padding: 9px 12px; font-weight: 600; color: #71717a; font-size: 10.5px; text-transform: uppercase;">Plan Details</th>
                                <th style="text-align: left; padding: 9px 12px; font-weight: 600; color: #71717a; font-size: 10.5px; text-transform: uppercase;">Validity Period</th>
                                <th style="text-align: left; padding: 9px 12px; font-weight: 600; color: #71717a; font-size: 10.5px; text-transform: uppercase;">Limits</th>
                                <th style="text-align: center; padding: 9px 12px; font-weight: 600; color: #71717a; font-size: 10.5px; text-transform: uppercase;">Status</th>
                                <th style="text-align: right; padding: 9px 12px; font-weight: 600; color: #71717a; font-size: 10.5px; text-transform: uppercase;">Source / Notes</th>
                            </tr>
                        </thead>
                        <tbody id="phTableBody" class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            {{-- Rows populated by JS --}}
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer" style="justify-content: space-between;">
                <button type="button" onclick="closeModal('planHistoryModal')" class="btn-cancel-modal">Close</button>
                <button type="button" onclick="openUpgradePlanFromHistory()" class="btn-submit-action">
                    + Upgrade / Assign New Plan
                </button>
            </div>
        </div>
    </div>

    {{-- DataTables Dependencies Scripts --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script>
        var dataTableInstance = null;

        function initUsersDataTable() {
            if ($.fn.DataTable.isDataTable('#usersTable')) {
                $('#usersTable').DataTable().destroy();
            }

            dataTableInstance = $('#usersTable').DataTable({
                responsive: false,
                dom: '<"flex flex-wrap items-center justify-between gap-4 mb-3"Bf>rt<"flex flex-wrap items-center justify-between gap-4 mt-3"lip>',
                buttons: [
                    { extend: 'copy', text: 'Copy', className: 'dt-button' },
                    { extend: 'csv', text: 'CSV', className: 'dt-button' },
                    { extend: 'excel', text: 'Excel', className: 'dt-button' },
                    { extend: 'pdf', text: 'PDF', className: 'dt-button' },
                    { extend: 'print', text: 'Print', className: 'dt-button' }
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search users, limits, status...",
                    lengthMenu: "Show _MENU_ records",
                    info: "Showing _START_ to _END_ of _TOTAL_ users",
                    paginate: {
                        first: "«",
                        previous: "‹",
                        next: "›",
                        last: "»"
                    }
                },
                order: [[0, 'desc']],
                pageLength: 10,
                columnDefs: [
                    { orderable: false, targets: [5, 7, 8] } // Disable sorting on Social, Template, and Action columns
                ]
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            initUsersDataTable();
        });

        document.addEventListener('livewire:navigated', function () {
            if (document.getElementById('usersTable')) {
                initUsersDataTable();
            }
        });

        // Toggle dropdown for gear icon with fixed positioning
        function toggleUserDropdown(event, userId) {
            event.stopPropagation();
            const btn = event.currentTarget;
            const targetDropdown = document.getElementById('dropdown-menu-' + userId);
            const allDropdowns = document.querySelectorAll('.action-dropdown-menu');

            allDropdowns.forEach(dd => {
                if (dd !== targetDropdown) {
                    dd.style.display = 'none';
                }
            });

            if (!targetDropdown) return;

            if (targetDropdown.style.display === 'block') {
                targetDropdown.style.display = 'none';
            } else {
                targetDropdown.style.display = 'block';
                const rect = btn.getBoundingClientRect();
                targetDropdown.style.position = 'fixed';
                targetDropdown.style.top = (rect.bottom + 4) + 'px';
                const dropdownWidth = 215;
                if (rect.left + dropdownWidth > window.innerWidth - 16) {
                    targetDropdown.style.left = Math.max(10, rect.right - dropdownWidth) + 'px';
                } else {
                    targetDropdown.style.left = Math.max(10, rect.left) + 'px';
                }
                targetDropdown.style.zIndex = '99999';
            }
        }

        // Close dropdown when clicking outside or scrolling
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.action-dropdown-wrapper')) {
                document.querySelectorAll('.action-dropdown-menu').forEach(dd => {
                    dd.style.display = 'none';
                });
            }
        });

        window.addEventListener('scroll', function() {
            document.querySelectorAll('.action-dropdown-menu').forEach(dd => dd.style.display = 'none');
        }, true);

        // Modal Helpers
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) modal.style.display = 'none';
        }

        function closeAllDropdowns() {
            document.querySelectorAll('.action-dropdown-menu').forEach(dd => dd.style.display = 'none');
        }

        // 1. Premium Template
        function openPremiumTemplateModal(userId, userName) {
            closeAllDropdowns();
            document.getElementById('ptModalUserName').innerText = userName + ' - Templates';
            document.getElementById('premiumTemplateModal').style.display = 'flex';
        }

        function saveTemplateSelection() {
            closeModal('premiumTemplateModal');
            alert('Template applied successfully!');
        }

        // 2. Video Template
        function openVideoTemplateModal(userId, userName) {
            closeAllDropdowns();
            document.getElementById('vtModalUserName').innerText = userName + ' - Video Reels';
            document.getElementById('videoTemplateModal').style.display = 'flex';
        }

        // 3. Wallet History
        function openWalletHistoryModal(userId, userName, balance) {
            closeAllDropdowns();
            document.getElementById('whModalUserName').innerText = userName + ' - Wallet';
            document.getElementById('whModalBalance').innerText = 'Current Balance: ₹' + parseFloat(balance).toFixed(2);
            document.getElementById('walletHistoryModal').style.display = 'flex';
        }

        // 4. Add Money
        function openAddMoneyModal(userId, userName, balance) {
            closeAllDropdowns();
            document.getElementById('amUserId').value = userId;
            document.getElementById('amModalUserName').innerText = userName;
            document.getElementById('amModalCurrentBal').innerText = 'Current Balance: ₹' + parseFloat(balance).toFixed(2);
            document.getElementById('addMoneyModal').style.display = 'flex';
        }

        function setAddAmount(val) {
            document.getElementById('amAmount').value = val;
        }

        function submitAddMoney() {
            const userId = document.getElementById('amUserId').value;
            const amount = parseFloat(document.getElementById('amAmount').value) || 0;
            const note = document.getElementById('amNote').value;
            if (amount <= 0) {
                alert('Please enter a valid amount');
                return;
            }
            closeModal('addMoneyModal');
            @this.addMoney(userId, amount, note);
        }

        // 5. Remove Money
        function openRemoveMoneyModal(userId, userName, balance) {
            closeAllDropdowns();
            document.getElementById('rmUserId').value = userId;
            document.getElementById('rmModalUserName').innerText = userName;
            document.getElementById('rmModalCurrentBal').innerText = 'Current Balance: ₹' + parseFloat(balance).toFixed(2);
            document.getElementById('removeMoneyModal').style.display = 'flex';
        }

        function submitRemoveMoney() {
            const userId = document.getElementById('rmUserId').value;
            const amount = parseFloat(document.getElementById('rmAmount').value) || 0;
            const reason = document.getElementById('rmReason').value;
            if (amount <= 0) {
                alert('Please enter a valid amount');
                return;
            }
            closeModal('removeMoneyModal');
            @this.removeMoney(userId, amount, reason);
        }

        // 6. Plan History
        var currentHistoryUserId = null;
        var currentHistoryUserName = '';
        var currentHistoryCurrentPlan = '';

        function openPlanHistoryModal(userId, userName) {
            if (window.event) {
                window.event.stopPropagation();
            }
            closeAllDropdowns();
            currentHistoryUserId = userId;
            currentHistoryUserName = userName;
            
            var modal = document.getElementById('planHistoryModal');
            if (modal) {
                modal.style.display = 'flex';
            }

            document.getElementById('phModalUserName').innerText = userName + ' — Plan History';
            document.getElementById('phModalSubTitle').innerText = 'User ID #' + userId + ' subscription records';
            document.getElementById('phCurrentPlanText').innerText = 'Loading...';
            document.getElementById('phWalletBalanceText').innerText = '—';
            document.getElementById('phTotalPlansCount').innerText = '—';
            
            document.getElementById('phLoadingState').style.display = 'block';
            document.getElementById('phEmptyState').style.display = 'none';
            document.getElementById('phTableWrapper').style.display = 'none';

            @this.loadPlanHistory(userId);
        }

        window.addEventListener('open-plan-history-modal', function (event) {
            var modal = document.getElementById('planHistoryModal');
            if (modal) {
                modal.style.display = 'flex';
            }
            const data = event.detail ? (event.detail[0] || event.detail) : {};
            document.getElementById('phLoadingState').style.display = 'none';

            document.getElementById('phCurrentPlanText').innerText = data.currentPlan || 'None';
            currentHistoryCurrentPlan = data.currentPlan || 'None';
            document.getElementById('phWalletBalanceText').innerText = '₹' + parseFloat(data.wallet || 0).toFixed(2);
            
            const histories = data.histories || [];
            document.getElementById('phTotalPlansCount').innerText = histories.length;

            if (histories.length === 0) {
                document.getElementById('phEmptyState').style.display = 'block';
                document.getElementById('phTableWrapper').style.display = 'none';
                return;
            }

            document.getElementById('phEmptyState').style.display = 'none';
            document.getElementById('phTableWrapper').style.display = 'block';

            const tbody = document.getElementById('phTableBody');
            tbody.innerHTML = '';

            histories.forEach(h => {
                const tr = document.createElement('tr');
                tr.style.background = '#ffffff';
                tr.className = 'dark:bg-zinc-900';

                let statusBadgeClass = 'plan-status-expired';
                if (h.status === 'active') statusBadgeClass = 'plan-status-active';
                else if (h.status === 'upgraded') statusBadgeClass = 'plan-status-upgraded';

                let remText = '';
                if (h.status === 'active' && h.remaining_days > 0) {
                    remText = ` <span style="font-size: 10px; color: #047857; font-weight: 600;">(${h.remaining_days} days left)</span>`;
                }

                tr.innerHTML = `
                    <td style="padding: 10px 12px; vertical-align: top;">
                        <div style="font-weight: 700; color: #09090b;" class="dark:text-white">${h.plan_name}</div>
                        <div style="font-size: 11px; color: #71717a; margin-top: 1px;">
                            ₹${parseFloat(h.price || 0).toFixed(2)} &bull; ${h.duration_days} Days
                        </div>
                    </td>
                    <td style="padding: 10px 12px; vertical-align: top;">
                        <div style="font-size: 11.5px; color: #09090b; font-weight: 500;" class="dark:text-white">
                            ${h.start_date} &rarr; ${h.end_date}
                        </div>
                        <div style="font-size: 10.5px; color: #71717a; margin-top: 1px;">
                            ${remText || 'Expired on ' + h.end_date}
                        </div>
                    </td>
                    <td style="padding: 10px 12px; vertical-align: top;">
                        <div style="font-size: 11px; color: #09090b;" class="dark:text-white">
                            ${h.daily_limit_video} vid / ${h.daily_limit_design} des
                        </div>
                        <div style="font-size: 10px; color: #a1a1aa;">per day limits</div>
                    </td>
                    <td style="padding: 10px 12px; text-align: center; vertical-align: middle;">
                        <span class="${statusBadgeClass}">${h.status}</span>
                    </td>
                    <td style="padding: 10px 12px; text-align: right; vertical-align: top;">
                        <div style="font-size: 11px; font-weight: 600; color: #09090b;" class="dark:text-white">${h.payment_method || 'Admin'}</div>
                        <div style="font-size: 10.5px; color: #71717a; margin-top: 1px;">${h.notes || '—'}</div>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        });

        function openUpgradePlanFromHistory() {
            closeModal('planHistoryModal');
            openUpgradePlanModal(currentHistoryUserId, currentHistoryUserName, currentHistoryCurrentPlan);
        }

        // 7. Upgrade Plan Modal
        function openUpgradePlanModal(userId, userName, currentPlan) {
            closeAllDropdowns();
            document.getElementById('upUserId').value = userId;
            document.getElementById('upModalUserName').innerText = userName;
            document.getElementById('upModalCurrentPlan').innerText = 'Current: ' + (currentPlan || 'None');
            document.getElementById('upPlanNote').value = '';
            
            const select = document.getElementById('upPlanSelect');
            if (currentPlan) {
                for (let i = 0; i < select.options.length; i++) {
                    if (select.options[i].text.includes(currentPlan)) {
                        select.selectedIndex = i;
                        break;
                    }
                }
            } else if (select.options.length > 0) {
                select.selectedIndex = 0;
            }

            document.getElementById('upgradePlanModal').style.display = 'flex';
        }

        function submitUpgradePlan() {
            const userId = document.getElementById('upUserId').value;
            const planId = document.getElementById('upPlanSelect').value;
            const note = document.getElementById('upPlanNote').value;
            closeModal('upgradePlanModal');
            @this.upgradePlan(userId, planId, note);
        }

        // Delete User
        function confirmDeleteUser(userId, userName) {
            closeAllDropdowns();
            if (confirm(`Are you sure you want to delete "${userName}"?`)) {
                @this.deleteUser(userId).then(() => {
                    if (dataTableInstance) {
                        dataTableInstance.row(`#user-row-${userId}`).remove().draw();
                    }
                });
            }
        }
    </script>
</x-filament-panels::page>
