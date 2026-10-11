<x-filament-panels::page>
    <style>
        .media-library-page {
            height: calc(100dvh - 185px);
            min-height: 0;
        }

        .media-library-page .fm-wrap {
            height: 100% !important;
            max-height: none !important;
            min-height: 0 !important;
        }

        .media-library-page .fm-grid-area {
            flex: 1 1 auto !important;
            min-height: 0 !important;
            height: auto !important;
        }

        .dark .media-library-page .fm-wrap,
        .dark .media-library-page .fm-wrap [style*="background:#ffffff"],
        .dark .media-library-page .fm-wrap [style*="background: #ffffff"] {
            background-color: #18181b !important;
            color: #f4f4f5 !important;
        }

        .dark .media-library-page .fm-wrap [style*="background:#f8fafc"],
        .dark .media-library-page .fm-wrap [style*="background: #f8fafc"],
        .dark .media-library-page .fm-wrap [style*="background:#f1f5f9"],
        .dark .media-library-page .fm-wrap [style*="background: #f1f5f9"],
        .dark .media-library-page .fm-wrap [style*="background:#faf5ff"] {
            background-color: #27272a !important;
            color: #e4e4e7 !important;
        }

        .dark .media-library-page .fm-wrap [style*="color:#0f172a"],
        .dark .media-library-page .fm-wrap [style*="color: #0f172a"],
        .dark .media-library-page .fm-wrap [style*="color:#1e293b"],
        .dark .media-library-page .fm-wrap [style*="color: #1e293b"],
        .dark .media-library-page .fm-wrap [style*="color:#334155"],
        .dark .media-library-page .fm-wrap [style*="color: #334155"],
        .dark .media-library-page .fm-wrap [style*="color:#475569"],
        .dark .media-library-page .fm-wrap [style*="color: #475569"],
        .dark .media-library-page .fm-wrap [style*="color:#64748b"],
        .dark .media-library-page .fm-wrap [style*="color: #64748b"] {
            color: #e4e4e7 !important;
        }

        .dark .media-library-page .fm-wrap [style*="border:1px solid #e2e8f0"],
        .dark .media-library-page .fm-wrap [style*="border-bottom:1px solid #e2e8f0"],
        .dark .media-library-page .fm-wrap [style*="border-bottom:1px solid #f1f5f9"] {
            border-color: #3f3f46 !important;
        }

        .dark .media-library-page .fm-wrap input[type="text"] {
            background: #27272a !important;
            border-color: #52525b !important;
            color: #f4f4f5 !important;
        }

        .dark .media-library-page .fm-wrap input::placeholder {
            color: #a1a1aa !important;
        }

        .dark .media-library-page .fm-wrap .fm-grid-area {
            background: #18181b !important;
        }
    </style>

    <div class="media-library-page">
        @include('filament.components.file-manager-modal-content')
    </div>
</x-filament-panels::page>
