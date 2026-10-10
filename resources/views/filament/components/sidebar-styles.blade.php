<style>
    /* Premium Sidebar Styling & Active Highlighting */
    .fi-sidebar {
        border-right: 1px solid #e4e4e7 !important;
        background-color: #fafafa !important;
    }
    .dark .fi-sidebar {
        border-right-color: #27272a !important;
        background-color: #121215 !important;
    }

    /* Sidebar Navigation Items */
    .fi-sidebar-nav {
        padding: 12px 10px !important;
        gap: 4px !important;
    }

    .fi-sidebar-item {
        margin-bottom: 4px !important;
    }

    /* Default Inactive Item */
    .fi-sidebar-item .fi-sidebar-item-btn {
        border-radius: 8px !important;
        padding: 8px 12px !important;
        color: #52525b !important;
        font-weight: 500 !important;
        font-size: 13.5px !important;
        transition: all 0.15s ease-in-out !important;
        border: 1px solid transparent !important;
    }

    .fi-sidebar-item .fi-sidebar-item-btn:hover {
        background-color: #f4f4f5 !important;
        color: #18181b !important;
    }

    .dark .fi-sidebar-item .fi-sidebar-item-btn {
        color: #a1a1aa !important;
    }

    .dark .fi-sidebar-item .fi-sidebar-item-btn:hover {
        background-color: #27272a !important;
        color: #f4f4f5 !important;
    }

    .fi-sidebar-item .fi-sidebar-item-btn .fi-sidebar-item-icon {
        color: #71717a !important;
        transition: color 0.15s ease-in-out !important;
    }

    .fi-sidebar-item .fi-sidebar-item-btn:hover .fi-sidebar-item-icon {
        color: #18181b !important;
    }

    .dark .fi-sidebar-item .fi-sidebar-item-btn:hover .fi-sidebar-item-icon {
        color: #ffffff !important;
    }

    /* PROMINENT ACTIVE HIGHLIGHT */
    .fi-sidebar-item.fi-active .fi-sidebar-item-btn,
    .fi-sidebar-item-active .fi-sidebar-item-btn,
    .fi-sidebar-item .fi-sidebar-item-btn[aria-current="page"],
    .fi-sidebar-item-btn.fi-active {
        background: #18181b !important;
        color: #ffffff !important;
        font-weight: 600 !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1) !important;
        border: 1px solid #18181b !important;
    }

    .dark .fi-sidebar-item.fi-active .fi-sidebar-item-btn,
    .dark .fi-sidebar-item-active .fi-sidebar-item-btn,
    .dark .fi-sidebar-item .fi-sidebar-item-btn[aria-current="page"],
    .dark .fi-sidebar-item-btn.fi-active {
        background: #ffffff !important;
        color: #18181b !important;
        border-color: #ffffff !important;
    }

    /* Active Icon */
    .fi-sidebar-item.fi-active .fi-sidebar-item-btn .fi-sidebar-item-icon,
    .fi-sidebar-item-active .fi-sidebar-item-btn .fi-sidebar-item-icon,
    .fi-sidebar-item .fi-sidebar-item-btn[aria-current="page"] .fi-sidebar-item-icon,
    .fi-sidebar-item-btn.fi-active .fi-sidebar-item-icon {
        color: #ffffff !important;
    }

    .dark .fi-sidebar-item.fi-active .fi-sidebar-item-btn .fi-sidebar-item-icon,
    .dark .fi-sidebar-item-active .fi-sidebar-item-btn .fi-sidebar-item-icon,
    .dark .fi-sidebar-item .fi-sidebar-item-btn[aria-current="page"] .fi-sidebar-item-icon,
    .dark .fi-sidebar-item-btn.fi-active .fi-sidebar-item-icon {
        color: #18181b !important;
    }

    /* Active Label */
    .fi-sidebar-item.fi-active .fi-sidebar-item-btn .fi-sidebar-item-label,
    .fi-sidebar-item-active .fi-sidebar-item-btn .fi-sidebar-item-label,
    .fi-sidebar-item .fi-sidebar-item-btn[aria-current="page"] .fi-sidebar-item-label,
    .fi-sidebar-item-btn.fi-active .fi-sidebar-item-label {
        color: #ffffff !important;
    }

    .dark .fi-sidebar-item.fi-active .fi-sidebar-item-btn .fi-sidebar-item-label,
    .dark .fi-sidebar-item-active .fi-sidebar-item-btn .fi-sidebar-item-label,
    .dark .fi-sidebar-item .fi-sidebar-item-btn[aria-current="page"] .fi-sidebar-item-label,
    .dark .fi-sidebar-item-btn.fi-active .fi-sidebar-item-label {
        color: #18181b !important;
    }

    /* Badge on Active Item */
    .fi-sidebar-item.fi-active .fi-badge,
    .fi-sidebar-item-active .fi-badge,
    .fi-sidebar-item-btn[aria-current="page"] .fi-badge,
    .fi-sidebar-item.fi-active .fi-sidebar-item-badge,
    .fi-sidebar-item-active .fi-sidebar-item-badge {
        background: #27272a !important;
        color: #f4f4f5 !important;
        border: 1px solid #3f3f46 !important;
    }

    .dark .fi-sidebar-item.fi-active .fi-badge,
    .dark .fi-sidebar-item-active .fi-badge,
    .dark .fi-sidebar-item-btn[aria-current="page"] .fi-badge,
    .dark .fi-sidebar-item.fi-active .fi-sidebar-item-badge,
    .dark .fi-sidebar-item-active .fi-sidebar-item-badge {
        background: #e4e4e7 !important;
        color: #18181b !important;
        border-color: #d4d4d8 !important;
    }
    /* Full Screen Width for Content Area, Forms, Sections & Tables */
    .fi-main-ctn,
    .fi-main,
    .fi-page,
    .fi-section,
    .fi-section-content,
    .fi-form,
    .fi-sc-form,
    .fi-fo-component-ctn,
    .fi-resource-create-record-page,
    .fi-resource-edit-record-page,
    .fi-resource-list-records-page,
    div[class*="max-w-"],
    div[class*="fi-width-"],
    main,
    form {
        max-width: 100% !important;
        width: 100% !important;
    }

    /* File Manager Modal Styles */
    @keyframes fm-spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    .fm-wrap { background: #ffffff !important; color: #1f2937 !important; }
    .fm-btn { cursor: pointer; border: none; transition: all .15s ease; }
    .fm-btn:hover { opacity: .92; }
    .fm-dropdown { position: relative !important; display: inline-block !important; }
    .fm-dropdown-menu {
        position: absolute !important;
        top: calc(100% + 6px) !important;
        right: 0 !important;
        background: #ffffff !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 10px !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.12), 0 8px 10px -6px rgba(0, 0, 0, 0.08) !important;
        min-width: 170px !important;
        z-index: 99999 !important;
        padding: 6px !important;
        flex-direction: column !important;
        gap: 3px !important;
    }
    .fm-dropdown-menu:not([style*="display: none"]) {
        display: flex !important;
    }
    .fm-dropdown-item {
        display: flex !important;
        align-items: center !important;
        gap: 9px !important;
        padding: 8px 12px !important;
        background: transparent !important;
        border: none !important;
        border-radius: 6px !important;
        color: #1f2937 !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        cursor: pointer !important;
        text-align: left !important;
        width: 100% !important;
        transition: background 0.15s ease, color 0.15s ease !important;
    }
    .fm-dropdown-item:hover {
        background: #f3f4f6 !important;
        color: #111827 !important;
    }

    /* Hide separate hint button in label row for any file upload field */
    .fi-fo-field-wrp:has(.filepond--root) .fi-fo-field-wrp-hint,
    .fi-fo-field-wrp:has(.filepond--root) .fi-fo-field-wrp-hint-action,
    .fi-fo-field-wrp:has(.fi-fo-file-upload) .fi-fo-field-wrp-hint,
    .fi-fo-field-wrp:has(.fi-fo-file-upload) .fi-fo-field-wrp-hint-action,
    button[wire\:click*="file-manager"],
    button[wire\:click*="file_manager"],
    button[wire\:click*="open_file_manager"],
    button[wire\:click*="open-file-manager"],
    button[wire\:click*="select_top_template"],
    button[wire\:click*="select_bottom_template"],
    button[wire\:click*="select_notification"],
    button[wire\:click*="select_video"],
    button[wire\:click*="select_thumbnail"],
    button[wire\:click*="select_regular"] {
        position: absolute !important;
        opacity: 0 !important;
        pointer-events: none !important;
        width: 0 !important;
        height: 0 !important;
        overflow: hidden !important;
        margin: 0 !important;
        padding: 0 !important;
        clip: rect(0, 0, 0, 0) !important;
        clip-path: inset(50%) !important;
        white-space: nowrap !important;
    }

    /* Style the drag & drop area to look clickable with cursor pointer */
    .fi-fo-file-upload .filepond--root,
    .fi-fo-file-upload .filepond--drop-label,
    .fi-fo-file-upload .filepond--panel,
    .filepond--root,
    .filepond--drop-label {
        cursor: pointer !important;
    }
    .filepond--drop-label {
        transition: background-color 0.2s ease !important;
    }
    .filepond--drop-label:hover {
        background-color: #faf5ff !important;
    }
    .filepond--label-action {
        color: #7c3aed !important;
        text-decoration: underline !important;
        font-weight: 600 !important;
        cursor: pointer !important;
    }
    .filepond--action-edit-item {
        cursor: pointer !important;
        background-color: #7c3aed !important;
        color: #ffffff !important;
        transition: transform 0.15s ease, background-color 0.15s ease !important;
    }
    .filepond--action-edit-item:hover {
        background-color: #6d28d9 !important;
        transform: scale(1.15) !important;
    }

    /* Compact FilePond preview size & grid layout */
    .filepond--root .filepond--list.filepond--list {
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 12px !important;
        justify-content: flex-start !important;
    }

    .filepond--root .filepond--item {
        width: 180px !important;
        height: 140px !important;
        margin: 0 !important;
        position: relative !important;
        transform: none !important;
    }

    .filepond--root .filepond--item-panel {
        height: 100% !important;
        border-radius: 8px !important;
        background-color: #0f172a !important;
    }

    .filepond--root .filepond--image-preview-wrapper {
        height: 100% !important;
    }

    .filepond--root .filepond--image-preview {
        height: 100% !important;
    }

    .filepond--root .filepond--image-clip {
        height: 100% !important;
    }

    .filepond--root .filepond--image-canvas-wrapper {
        height: 100% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .filepond--root .filepond--image-canvas-wrapper canvas {
        max-width: 100% !important;
        max-height: 100% !important;
        object-fit: contain !important;
    }

    .filepond--root .filepond--file-info {
        font-size: 11px !important;
        max-width: 120px !important;
        top: 4px !important;
        left: 28px !important;
    }

    .filepond--root .filepond--action-remove-item {
        top: 4px !important;
        left: 4px !important;
    }

    .filepond--root .filepond--action-edit-item {
        bottom: 6px !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
    }

    .filepond--root .filepond--action-edit-item:hover {
        transform: translateX(-50%) scale(1.15) !important;
    }

    /* Modal container polish for File Manager */
    .fi-modal:has(.fm-wrap) .fi-modal-window {
        border-radius: 16px !important;
        overflow: hidden !important;
        border: 1px solid rgba(226, 232, 240, 0.8) !important;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
    }
    .fi-modal:has(.fm-wrap) .fi-modal-content {
        padding: 0 !important;
    }
    
    [x-cloak] { display: none !important; }
</style>

{{-- Global Standalone File Manager Modal Container --}}
<div id="global-file-manager-modal" 
     x-data="{ 
         isOpen: false,
         open() { 
             this.isOpen = true; 
             document.body.style.overflow = 'hidden'; 
         },
         close() { 
             this.isOpen = false; 
             document.body.style.overflow = ''; 
         }
     }"
     x-init="
        window.addEventListener('open-file-manager-modal', () => open());
        window.addEventListener('close-file-manager-modal', () => close());
     "
     @keydown.escape.window="if(isOpen) close()"
     x-show="isOpen"
     x-cloak
     style="position: fixed; inset: 0; z-index: 999999; display: flex; align-items: center; justify-content: center; background-color: rgba(15, 23, 42, 0.65); backdrop-filter: blur(4px); padding: 16px;">
    
    <div @click.away="close()"
         style="width: 100%; max-width: 1250px; max-height: 92vh; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35); display: flex; flex-direction: column;">
        @include('filament.components.file-manager-modal-content')
    </div>
</div>

<script>
(function() {
    window.openGlobalFileManager = function(uploadArea) {
        if (uploadArea) {
            window._lastActiveUploadArea = uploadArea.closest('.fi-fo-file-upload') || uploadArea;
        }
        window.dispatchEvent(new CustomEvent('open-file-manager-modal'));
    };

    if (window.__sidebarStylesInitialized) {
        return;
    }
    window.__sidebarStylesInitialized = true;

    // Intercept click on any drag & drop file upload area, file preview, or edit button to open File Manager
    document.addEventListener('click', function (e) {
        // If clicking inside the file manager itself, do not intercept
        if (e.target.closest('.fm-wrap, #global-file-manager-modal')) return;

        const uploadArea = e.target.closest('.fi-fo-file-upload, .filepond--root, .filepond--drop-label, .filepond--item');
        if (!uploadArea) return;

        // Allow native remove / delete and reorder actions
        if (e.target.closest('.filepond--action-remove-item, .filepond--action-reorder-item')) {
            return;
        }

        // Prevent opening the default browser file chooser or default FilePond image cropper/editor
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        window.openGlobalFileManager(uploadArea);
    }, true);

    // Also intercept pointerdown / mousedown on the edit pencil button so cropper never triggers
    document.addEventListener('pointerdown', function (e) {
        if (e.target.closest('.fm-wrap, #global-file-manager-modal')) return;

        if (e.target.closest('.filepond--action-edit-item, [data-action="edit-item"]')) {
            const uploadArea = e.target.closest('.fi-fo-file-upload, .filepond--root, .filepond--drop-label, .filepond--item');
            if (uploadArea) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                window.openGlobalFileManager(uploadArea);
            }
        }
    }, true);

    // Also track active upload area and open global FM when clicking any hint action or file manager button directly
    document.addEventListener('click', function (e) {
        if (e.target.closest('.fm-wrap, #global-file-manager-modal')) return;

        const hintBtn = e.target.closest('.fi-fo-field-wrp-hint button, .fi-fo-field-wrp-hint-action button, button[wire\\:click*="file_manager"], button[wire\\:click*="file-manager"], button[wire\\:click*="open_file_manager"], button[wire\\:click*="select_"]');
        if (hintBtn) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();
            const field = hintBtn.closest('.fi-fo-field-wrp') || hintBtn.closest('.fi-fo-field') || hintBtn.closest('.fi-modal') || document;
            const upload = field.querySelector('.fi-fo-file-upload');
            window.openGlobalFileManager(upload);
        }
    }, true);

    function enhanceDropLabels() {
        document.querySelectorAll('.filepond--drop-label label').forEach(label => {
            if (label.closest('.fm-wrap, #global-file-manager-modal')) return;
            if (label.getAttribute('data-fm-enhanced')) return;
            label.setAttribute('data-fm-enhanced', 'true');
            const actionSpan = label.querySelector('.filepond--label-action');
            if (actionSpan) {
                actionSpan.textContent = 'Browse File Manager';
            }
        });
    }
    document.addEventListener('DOMContentLoaded', enhanceDropLabels);
    document.addEventListener('livewire:navigated', enhanceDropLabels);
    document.addEventListener('livewire:initialized', enhanceDropLabels);
    setTimeout(enhanceDropLabels, 200);
    setTimeout(enhanceDropLabels, 600);
    setTimeout(enhanceDropLabels, 1200);

    if (!window._fmObserverInstance) {
        window._fmObserverInstance = new MutationObserver(() => enhanceDropLabels());
        if (document.body) {
            window._fmObserverInstance.observe(document.body, { childList: true, subtree: true });
        } else {
            document.addEventListener('DOMContentLoaded', () => {
                window._fmObserverInstance.observe(document.body, { childList: true, subtree: true });
            });
        }
    }

    document.addEventListener('livewire:init', () => {
        Livewire.on('file-selected', (event) => {
            const data = (event && typeof event === 'object' && 'path' in event) ? event : (event && event[0] ? event[0] : {});
            const path     = data.path;
            const fieldKey = data.fieldKey;
            if (!path || !fieldKey) return;
            Livewire.all().forEach(component => {
                try { component.set(fieldKey, path); } catch (e) {}
            });
        });
    });
})();
</script>

{{-- Global jQuery & DataTables for pages like Plans --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
