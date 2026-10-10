<x-filament-panels::page>
    {{-- DataTables Stylesheets --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

    <style>
        .dt-card {
            background: #ffffff;
            border: 1px solid #e4e4e7;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.02);
            font-family: inherit;
        }
        .dark .dt-card {
            background: #18181b;
            border-color: #27272a;
        }

        /* Custom DataTables Shadcn Theme */
        .dataTables_wrapper {
            font-size: 13px;
            color: #09090b;
        }
        .dark .dataTables_wrapper {
            color: #f4f4f5;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 16px;
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
            width: 240px;
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
            margin-bottom: 16px;
            gap: 6px;
            display: inline-flex;
            flex-wrap: wrap;
        }
        .dt-button {
            background: #ffffff !important;
            border: 1px solid #e4e4e7 !important;
            border-radius: 8px !important;
            color: #18181b !important;
            padding: 5px 12px !important;
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
            margin-top: 8px !important;
            margin-bottom: 16px !important;
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
            padding: 12px 16px !important;
            background-color: transparent !important;
        }
        .dark table.dataTable thead th {
            border-bottom-color: #27272a !important;
            color: #a1a1aa !important;
        }

        table.dataTable tbody td {
            padding: 14px 16px !important;
            border-bottom: 1px solid #f4f4f5 !important;
            vertical-align: middle !important;
            font-size: 13px !important;
        }
        .dark table.dataTable tbody td {
            border-bottom-color: #27272a !important;
        }

        table.dataTable tbody tr:hover {
            background-color: #fafafa !important;
        }
        .dark table.dataTable tbody tr:hover {
            background-color: #27272a !important;
        }
        .dark table.dataTable tbody tr:hover > * {
            background-color: #27272a !important;
        }

        /* Daily Limit formatting */
        .limit-box {
            display: flex;
            flex-direction: column;
            gap: 3px;
            font-size: 12px;
        }
        .limit-row {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #09090b;
        }
        .dark .limit-row {
            color: #f4f4f5;
        }
        .limit-tag-design {
            font-size: 11px;
            font-weight: 600;
            color: #2563eb;
            background: #eff6ff;
            padding: 1px 6px;
            border-radius: 4px;
            border: 1px solid #dbeafe;
        }
        .dark .limit-tag-design {
            background: rgba(37, 99, 235, 0.15);
            color: #60a5fa;
            border-color: rgba(37, 99, 235, 0.3);
        }
        .limit-tag-video {
            font-size: 11px;
            font-weight: 600;
            color: #7c3aed;
            background: #f5f3ff;
            padding: 1px 6px;
            border-radius: 4px;
            border: 1px solid #ede9fe;
        }
        .dark .limit-tag-video {
            background: rgba(124, 58, 237, 0.15);
            color: #a78bfa;
            border-color: rgba(124, 58, 237, 0.3);
        }

        /* Action Buttons */
        .btn-action-edit {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            background-color: #f4f4f5;
            color: #18181b;
            text-decoration: none;
            transition: all 0.15s;
        }
        .dark .btn-action-edit {
            background-color: #27272a;
            color: #f4f4f5;
        }
        .btn-action-edit:hover {
            background-color: #e4e4e7;
        }
        .btn-action-delete {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            background-color: #fff1f2;
            color: #e11d48;
            border: none;
            cursor: pointer;
            transition: all 0.15s;
        }
        .dark .btn-action-delete {
            background-color: rgba(225, 29, 72, 0.15);
            color: #fb7185;
        }
        .btn-action-delete:hover {
            background-color: #ffe4e6;
        }
    </style>

    <div class="space-y-4">
        {{-- DataTables Card Container --}}
        <div class="dt-card" wire:ignore>
            <table id="plansTable" class="dataTable" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 50px;">Id</th>
                        <th>Name</th>
                        <th>Daily Limit</th>
                        <th>Updated Date</th>
                        <th>Created Date</th>
                        <th style="text-align: right; width: 140px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->plans as $plan)
                        <tr id="plan-row-{{ $plan->id }}">
                            <td style="font-weight: 600; color: #a1a1aa;">
                                {{ $plan->id }}
                            </td>
                            <td>
                                <div style="font-weight: 600; font-size: 14px;" class="text-zinc-900 dark:text-zinc-100">
                                    {{ $plan->name }}
                                </div>
                                @if ($plan->price > 0)
                                    <div style="font-size: 11px; color: #16a34a; font-weight: 500; margin-top: 2px;">
                                        ₹{{ number_format($plan->price, 0) }} @if($plan->duration_days) &bull; {{ $plan->duration_days }} Days @endif
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="limit-box">
                                    <div class="limit-row">
                                        <span class="limit-tag-design">Design</span>
                                        <strong>: {{ $plan->daily_limit_design }}</strong>
                                    </div>
                                    <div class="limit-row">
                                        <span class="limit-tag-video">Video</span>
                                        <strong>: {{ $plan->daily_limit_video }}</strong>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 500;" class="text-zinc-900 dark:text-zinc-100">
                                    {{ $plan->updated_at?->format('d M Y') ?? 'N/A' }}
                                </div>
                            </td>
                            <td>
                                <div class="text-zinc-500 dark:text-zinc-400">
                                    {{ $plan->created_at?->format('d M Y') ?? 'N/A' }}
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; align-items: center; gap: 6px;">
                                    <a href="{{ route('filament.admin.resources.plans.edit', ['record' => $plan->id]) }}" class="btn-action-edit">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    <button type="button" 
                                            onclick="confirmDeletePlan({{ $plan->id }}, '{{ addslashes($plan->name) }}')"
                                            class="btn-action-delete">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
        var plansDataTableInstance = null;

        function initPlansDataTable() {
            if (typeof window.jQuery === 'undefined' || typeof window.$ === 'undefined' || !window.$.fn || !window.$.fn.DataTable) {
                return;
            }

            if ($.fn.DataTable.isDataTable('#plansTable')) {
                $('#plansTable').DataTable().destroy();
            }

            plansDataTableInstance = $('#plansTable').DataTable({
                responsive: true,
                dom: '<"flex flex-wrap items-center justify-between gap-4 mb-4"Bf>rt<"flex flex-wrap items-center justify-between gap-4 mt-4"lip>',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<span style="display:flex;align-items:center;gap:4px;">📋 Copy</span>',
                        className: 'dt-button'
                    },
                    {
                        extend: 'csv',
                        text: '<span style="display:flex;align-items:center;gap:4px;">📄 CSV</span>',
                        className: 'dt-button'
                    },
                    {
                        extend: 'excel',
                        text: '<span style="display:flex;align-items:center;gap:4px;">📊 Excel</span>',
                        className: 'dt-button'
                    },
                    {
                        extend: 'pdf',
                        text: '<span style="display:flex;align-items:center;gap:4px;">📑 PDF</span>',
                        className: 'dt-button'
                    },
                    {
                        extend: 'print',
                        text: '<span style="display:flex;align-items:center;gap:4px;">🖨️ Print</span>',
                        className: 'dt-button'
                    }
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search plans...",
                    lengthMenu: "Show _MENU_ records",
                    info: "Showing _START_ to _END_ of _TOTAL_ plans",
                    paginate: {
                        first: "«",
                        previous: "‹",
                        next: "›",
                        last: "»"
                    }
                },
                order: [[0, 'asc']],
                pageLength: 10,
                columnDefs: [
                    { orderable: false, targets: 5 } // Disable sorting on Action column
                ]
            });
        }

        function safeInitPlansDataTable() {
            if (!document.getElementById('plansTable')) return;

            if (typeof window.jQuery === 'undefined' || typeof window.$ === 'undefined' || !window.$.fn || !window.$.fn.DataTable) {
                let attempts = 0;
                const timer = setInterval(() => {
                    attempts++;
                    if (typeof window.jQuery !== 'undefined' && typeof window.$ !== 'undefined' && window.$.fn && window.$.fn.DataTable) {
                        clearInterval(timer);
                        initPlansDataTable();
                    } else if (attempts >= 40) {
                        clearInterval(timer);
                    }
                }, 50);
                return;
            }

            initPlansDataTable();
        }

        document.addEventListener('DOMContentLoaded', safeInitPlansDataTable);
        document.addEventListener('livewire:navigated', safeInitPlansDataTable);
        document.addEventListener('livewire:initialized', safeInitPlansDataTable);

        function confirmDeletePlan(planId, planName) {
            if (confirm(`Are you sure you want to delete plan "${planName}"?`)) {
                @this.deletePlan(planId).then(() => {
                    if (plansDataTableInstance) {
                        plansDataTableInstance.row(`#plan-row-${planId}`).remove().draw();
                    }
                });
            }
        }
    </script>
</x-filament-panels::page>
