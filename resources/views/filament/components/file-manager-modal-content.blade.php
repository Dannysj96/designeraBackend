<div x-data="fileManager()" class="fm-wrap" @click.away="showCreateDropdown = false" style="background:#ffffff;color:#1e293b;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;border-radius:14px;overflow:hidden;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);display:flex;flex-direction:column;height:100%;max-height:88vh;">

    <style>
        .fm-wrap * { box-sizing: border-box; }
        .fm-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 500;
            border-radius: 9px;
            padding: 7px 13px;
            transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: 1px solid transparent;
            user-select: none;
            line-height: 1.25;
            white-space: nowrap;
        }
        .fm-btn:active { transform: scale(0.97); }
        .fm-btn-outline {
            background: #ffffff;
            border-color: #e2e8f0;
            color: #334155;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }
        .fm-btn-outline:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #0f172a;
        }
        .fm-btn-primary {
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            color: #ffffff;
            border: none;
            box-shadow: 0 2px 8px rgba(124, 58, 237, 0.25);
        }
        .fm-btn-primary:hover {
            background: linear-gradient(135deg, #6d28d9 0%, #5b21b6 100%);
            box-shadow: 0 4px 14px rgba(124, 58, 237, 0.35);
        }
        .fm-btn-danger {
            background: #fef2f2;
            border-color: #fecaca;
            color: #ef4444;
        }
        .fm-btn-danger:hover {
            background: #ef4444;
            border-color: #dc2626;
            color: #ffffff;
        }
        .fm-card {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .fm-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px -4px rgba(0,0,0,0.08), 0 2px 6px -1px rgba(0,0,0,0.04);
        }
        .fm-card:hover .fm-card-img {
            transform: scale(1.05);
        }
        .fm-card:hover .fm-card-img.fm-card-img-template {
            transform: none;
        }
        .fm-card:hover .fm-download-btn {
            opacity: 1 !important;
            transform: scale(1) !important;
        }
        .fm-card-img {
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .fm-card-img-template {
            object-fit: contain !important;
            background: #f8fafc;
        }
        @keyframes fm-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>

    {{-- ===== HEADER ===== --}}
    <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 20px;background:#ffffff;border-bottom:1px solid #e2e8f0;flex-shrink:0;">
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);display:flex;align-items:center;justify-content:center;color:#7c3aed;">
                <svg style="width:18px;height:18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                </svg>
            </div>
            <div>
                <h3 style="margin:0;font-size:15px;font-weight:700;color:#0f172a;line-height:1.2;">File Manager</h3>
                <p style="margin:0;font-size:11px;color:#64748b;">Browse, select or upload media files</p>
            </div>
        </div>
        <button @click="closeManager()" type="button" class="fm-btn fm-btn-outline" style="width:32px;height:32px;padding:0;border-radius:8px;" title="Close File Manager">
            <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- ===== TOOLBAR ===== --}}
    <div style="display:flex;align-items:center;gap:10px;padding:12px 18px;background:#f8fafc;border-bottom:1px solid #e2e8f0;flex-wrap:wrap;flex-shrink:0;">

        {{-- Search Box --}}
        <div style="position:relative;flex:1;min-width:200px;">
            <svg style="position:absolute;left:12px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:#94a3b8;pointer-events:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input x-model="search" type="text" placeholder="Search files and folders..."
                style="width:100%;background:#ffffff;border:1px solid #cbd5e1;border-radius:10px;padding:8px 32px 8px 36px;color:#0f172a;font-size:13px;outline:none;box-sizing:border-box;transition:border-color .15s, box-shadow .15s;"
                onfocus="this.style.borderColor='#7c3aed';this.style.boxShadow='0 0 0 3px rgba(124,58,237,0.12)';"
                onblur="this.style.borderColor='#cbd5e1';this.style.boxShadow='none';" />
            <button x-show="search" @click="search = ''" type="button"
                style="position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;color:#94a3b8;cursor:pointer;padding:2px;display:flex;">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Return (Back) --}}
        <button @click="goBack()" type="button" class="fm-btn fm-btn-outline" :disabled="!currentDir" :style="!currentDir ? 'opacity:0.5;cursor:not-allowed;' : ''">
            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            <span>Back</span>
        </button>

        {{-- Refresh --}}
        <button @click="browse(currentDir)" type="button" class="fm-btn fm-btn-outline" title="Refresh folder">
            <svg style="width:14px;height:14px;" :style="loading ? 'animation:fm-spin 1s linear infinite' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            <span>Refresh</span>
        </button>

        {{-- Multi-Select Toggle --}}
        <button @click="toggleMultiSelect()" type="button" class="fm-btn"
            :style="isMultiSelect ? 'background:linear-gradient(135deg, #7c3aed, #6d28d9);color:#ffffff;border:none;box-shadow:0 2px 8px rgba(124,58,237,0.3);' : 'background:#ffffff;border-color:#e2e8f0;color:#334155;'">
            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            <span>Multi-Select</span>
            <span x-show="selectedFiles.length > 0"
                style="border-radius:9999px;padding:1px 7px;font-size:11px;font-weight:700;"
                :style="isMultiSelect ? 'background:rgba(255,255,255,0.25);color:#ffffff;' : 'background:#7c3aed;color:#ffffff;'"
                x-text="selectedFiles.length"></span>
        </button>

        {{-- Select All / Deselect All --}}
        <button x-show="filteredFiles.length > 0" @click="toggleSelectAll()" type="button" class="fm-btn fm-btn-outline">
            <svg style="width:14px;height:14px;color:#7c3aed;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
            <span x-text="areAllFilesSelected() ? 'Deselect All' : 'Select All'"></span>
        </button>

        {{-- Delete Action --}}
        <button @click="deleteSelected()" type="button" x-show="selectedFiles.length > 0 || selectedFolder !== ''" class="fm-btn fm-btn-danger">
            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            <span x-text="selectedFiles.length > 1 ? ('Delete (' + selectedFiles.length + ')') : 'Delete'"></span>
        </button>

        {{-- Create New Dropdown --}}
        <div class="fm-dropdown" style="position:relative;display:inline-block;">
            <button @click.stop="showCreateDropdown = !showCreateDropdown" type="button" class="fm-btn fm-btn-primary">
                <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Create New</span>
                <svg style="width:11px;height:11px;opacity:0.8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            {{-- Dropdown Menu --}}
            <div x-show="showCreateDropdown" x-transition class="fm-dropdown-menu"
                style="position:absolute;top:calc(100% + 6px);right:0;background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;box-shadow:0 12px 28px -4px rgba(0,0,0,0.12), 0 4px 10px -2px rgba(0,0,0,0.06);min-width:180px;z-index:99999;padding:6px;"
                @click.stop>
                <button @click="openCreateFolder()" type="button" class="fm-btn"
                    style="display:flex;align-items:center;gap:10px;padding:9px 12px;background:transparent;border:none;border-radius:8px;color:#1e293b;font-size:13px;width:100%;text-align:left;"
                    onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='transparent';">
                    <div style="width:26px;height:26px;border-radius:6px;background:#fef3c7;display:flex;align-items:center;justify-content:center;color:#d97706;">
                        <svg style="width:15px;height:15px;" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                        </svg>
                    </div>
                    <span>New Folder</span>
                </button>
                <button @click="triggerUpload(); showCreateDropdown = false" type="button" class="fm-btn"
                    style="display:flex;align-items:center;gap:10px;padding:9px 12px;background:transparent;border:none;border-radius:8px;color:#1e293b;font-size:13px;width:100%;text-align:left;"
                    onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='transparent';">
                    <div style="width:26px;height:26px;border-radius:6px;background:#dbeafe;display:flex;align-items:center;justify-content:center;color:#2563eb;">
                        <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    <span>Upload File</span>
                </button>
                <button @click="triggerTemplateUpload(); showCreateDropdown = false" type="button" class="fm-btn"
                    style="display:flex;align-items:center;gap:10px;padding:9px 12px;background:transparent;border:none;border-radius:8px;color:#1e293b;font-size:13px;width:100%;text-align:left;"
                    onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='transparent';">
                    <div style="width:26px;height:26px;border-radius:6px;background:#dcfce7;display:flex;align-items:center;justify-content:center;color:#059669;">
                        <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span>Template File</span>
                </button>
            </div>
        </div>

        {{-- Hidden file inputs --}}
        <input type="file" id="fm-file-upload-input" multiple accept="image/*,video/*"
            style="display:none;" @change="handleUpload($event)" />
        <input type="file" id="fm-template-upload-input" multiple accept="image/*,.psd,.ai"
            style="display:none;" @change="handleUpload($event)" />
    </div>

    {{-- ===== BREADCRUMB & FOLDER STATS BAR ===== --}}
    <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 18px;font-size:12px;background:#f8fafc;border-bottom:1px solid #e2e8f0;flex-wrap:wrap;gap:8px;flex-shrink:0;">
        <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
            <button @click="browse('')" type="button" class="fm-btn"
                style="display:flex;align-items:center;gap:5px;padding:4px 9px;border-radius:6px;font-weight:600;font-size:12px;background:#f1f5f9;color:#7c3aed;border:1px solid #e2e8f0;">
                <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Root
            </button>
            <template x-for="(crumb, i) in breadcrumbs" :key="i">
                <span style="display:flex;align-items:center;gap:6px;">
                    <span style="color:#cbd5e1;font-weight:600;">›</span>
                    <button @click="browse(crumb.path)" type="button" class="fm-btn"
                        style="padding:4px 9px;border-radius:6px;background:#ffffff;border:1px solid #e2e8f0;color:#334155;font-size:12px;"
                        x-text="crumb.name"></button>
                </span>
            </template>
        </div>

        {{-- Stats Pill --}}
        <div style="display:flex;align-items:center;gap:12px;color:#64748b;font-size:12px;">
            <span x-text="filteredFolders.length + ' Folders · ' + filteredFiles.length + ' Files'"></span>
        </div>
    </div>

    {{-- ===== INLINE CREATE FOLDER BAR ===== --}}
    <div x-show="showNewFolderInput" x-transition
        style="display:flex;align-items:center;gap:10px;padding:10px 18px;background:#fffbeb;border-bottom:1px solid #fde68a;flex-shrink:0;">
        <div style="width:28px;height:28px;border-radius:6px;background:#fef3c7;display:flex;align-items:center;justify-content:center;color:#d97706;flex-shrink:0;">
            <svg style="width:16px;height:16px;" fill="currentColor" viewBox="0 0 20 20">
                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
            </svg>
        </div>
        <span style="font-size:13px;font-weight:600;color:#92400e;">New Folder Name:</span>
        <input x-ref="newFolderInput" x-model="newFolderName" @keydown.enter.prevent="submitCreateFolder()" @keydown.escape="showNewFolderInput = false; newFolderName = ''"
            type="text" placeholder="e.g. Banners, Posters..."
            style="padding:6px 12px;font-size:13px;border:1px solid #fde68a;border-radius:8px;outline:none;background:#ffffff;color:#1e293b;min-width:220px;" />
        <button @click="submitCreateFolder()" type="button" class="fm-btn fm-btn-primary" style="padding:6px 14px;">
            Create
        </button>
        <button @click="showNewFolderInput = false; newFolderName = ''" type="button" class="fm-btn fm-btn-outline" style="padding:6px 12px;">
            Cancel
        </button>
    </div>

    {{-- ===== FILE & FOLDER GRID AREA ===== --}}
    <div class="fm-grid-area" style="padding:20px;flex:1;overflow-y:auto;background:#ffffff;min-height:350px;">

        {{-- Folders Section --}}
        <div x-show="filteredFolders.length > 0" style="margin-bottom:24px;">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <span style="font-size:11px;font-weight:700;color:#64748b;letter-spacing:0.06em;text-transform:uppercase;">Folders</span>
                <span style="font-size:11px;color:#94a3b8;" x-text="'(' + filteredFolders.length + ')'"></span>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(170px, 1fr));gap:12px;">
                <template x-for="folder in filteredFolders" :key="folder.path">
                    <button @click="selectFolder(folder.path)" @dblclick="browse(folder.path)" type="button" class="fm-card"
                        :style="selectedFolder===folder.path ? 'border-color:#7c3aed;box-shadow:0 0 0 2px #7c3aed;background:#faf5ff;' : 'border:1px solid #e2e8f0;background:#ffffff;'"
                        style="border-radius:12px;padding:12px;display:flex;align-items:center;gap:12px;text-align:left;width:100%;cursor:pointer;">
                        <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg, #fffbeb, #fef3c7);border:1px solid #fde68a;display:flex;align-items:center;justify-content:center;color:#d97706;flex-shrink:0;">
                            <svg style="width:22px;height:22px;" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"/>
                            </svg>
                        </div>
                        <div style="overflow:hidden;flex:1;">
                            <p style="font-size:13px;font-weight:600;color:#1e293b;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;margin:0;" :title="folder.name" x-text="folder.name"></p>
                            <p style="font-size:11px;color:#94a3b8;margin:2px 0 0;" x-text="folder.last_modified"></p>
                        </div>
                    </button>
                </template>
            </div>
        </div>

        {{-- Files Section --}}
        <div x-show="filteredFiles.length > 0">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <span style="font-size:11px;font-weight:700;color:#64748b;letter-spacing:0.06em;text-transform:uppercase;">Files</span>
                <span style="font-size:11px;color:#94a3b8;" x-text="'(' + filteredFiles.length + ')'"></span>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(130px, 1fr));gap:14px;">
                <template x-for="file in filteredFiles" :key="file.path">
                    <button @click="handleCardClick(file)" @dblclick="handleCardDblClick(file)" type="button" class="fm-card"
                        :style="isFileSelected(file.path) ? 'border:2px solid #7c3aed;box-shadow:0 0 0 3px rgba(124,58,237,0.18);background:#faf5ff;' : 'border:1px solid #e2e8f0;background:#ffffff;'"
                        style="border-radius:12px;overflow:hidden;width:100%;text-align:left;position:relative;cursor:pointer;padding:0;">
                        
                        {{-- Thumbnail Box --}}
                        <div style="width:100%;height:110px;background:#f8fafc;position:relative;overflow:hidden;display:flex;align-items:center;justify-content:center;border-bottom:1px solid #f1f5f9;">
                            
                            {{-- Checkbox for Selection --}}
                            <div @click.stop="toggleSelectFile(file.path)"
                                :style="isFileSelected(file.path) ? 'background:#7c3aed;border-color:#7c3aed;' : 'background:rgba(255,255,255,0.92);border-color:#cbd5e1;'"
                                style="position:absolute;top:7px;left:7px;z-index:20;width:22px;height:22px;border-radius:6px;border:1.5px solid;display:flex;align-items:center;justify-content:center;transition:all .15s;cursor:pointer;box-shadow:0 2px 4px rgba(0,0,0,0.12);"
                                title="Select file">
                                <svg x-show="isFileSelected(file.path)" style="width:13px;height:13px;color:#ffffff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>

                            {{-- Image Thumbnail --}}
                            <img :src="file.thumb_url || file.url" :alt="file.name" x-show="!file.is_video"
                                :class="isTemplatePreview(file) ? 'fm-card-img fm-card-img-template' : 'fm-card-img'"
                                style="width:100%;height:100%;object-fit:cover;" onerror="this.src=file.url;" loading="lazy" />

                            {{-- Video Placeholder --}}
                            <div x-show="file.is_video" style="display:flex;align-items:center;justify-content:center;width:100%;height:100%;background:#0f172a;color:#ffffff;">
                                <svg style="width:32px;height:32px;opacity:0.8;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                </svg>
                            </div>

                            {{-- Selected Overlay --}}
                            <div x-show="isFileSelected(file.path)" style="position:absolute;inset:0;background:rgba(124,58,237,0.18);display:flex;align-items:center;justify-content:center;pointer-events:none;z-index:10;">
                                <div style="width:30px;height:30px;border-radius:50%;background:#7c3aed;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(124,58,237,0.4);">
                                    <svg style="width:16px;height:16px;color:#fff;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                            </div>

                            {{-- Quick Download Button --}}
                            <a :href="file.url" download @click.stop class="fm-download-btn"
                                style="position:absolute;bottom:6px;right:6px;background:rgba(15,23,42,0.7);backdrop-filter:blur(4px);border-radius:6px;padding:4px;display:flex;line-height:0;color:#ffffff;transition:all 0.15s;opacity:0;transform:scale(0.9);z-index:15;"
                                title="Download original">
                                <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </a>
                        </div>

                        {{-- Metadata Area --}}
                        <div style="padding:8px 10px;background:#ffffff;">
                            <p style="font-size:12px;font-weight:600;color:#0f172a;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;margin:0;" :title="file.name" x-text="file.name"></p>
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:3px;">
                                <span style="font-size:11px;color:#64748b;" x-text="file.size"></span>
                                <span style="font-size:10px;text-transform:uppercase;font-weight:700;background:#f1f5f9;color:#64748b;padding:1px 4px;border-radius:4px;" x-text="file.name.split('.').pop()"></span>
                            </div>
                        </div>
                    </button>
                </template>
            </div>
        </div>

        {{-- Loading State --}}
        <div x-show="loading" style="padding:60px 20px;text-align:center;color:#64748b;font-size:13px;">
            <svg style="width:28px;height:28px;margin:0 auto 10px;color:#7c3aed;animation:fm-spin 1s linear infinite;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            <p style="margin:0;font-weight:500;">Loading files...</p>
        </div>

        {{-- Empty State --}}
        <div x-show="!loading && filteredFolders.length===0 && filteredFiles.length===0"
            style="padding:60px 20px;text-align:center;color:#94a3b8;font-size:13px;">
            <div style="width:54px;height:54px;border-radius:50%;background:#f1f5f9;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;color:#cbd5e1;">
                <svg style="width:28px;height:28px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V7z"/>
                </svg>
            </div>
            <p style="font-size:14px;font-weight:600;color:#475569;margin:0 0 4px;">No files found</p>
            <p style="margin:0;font-size:12px;">This folder is empty or no files match your search.</p>
        </div>
    </div>

    {{-- ===== FOOTER ===== --}}
    <div style="padding:14px 20px;background:#f8fafc;border-top:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;flex-shrink:0;">
        
        {{-- Status / Hint --}}
        <div style="font-size:13px;">
            <template x-if="selectedFiles.length > 1">
                <div style="display:flex;align-items:center;gap:8px;">
                    <span style="background:#ede9fe;color:#6d28d9;border:1px solid #ddd6fe;border-radius:9999px;padding:3px 10px;font-size:12px;font-weight:600;display:flex;align-items:center;gap:5px;">
                        <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span x-text="selectedFiles.length + ' files selected'"></span>
                    </span>
                    <button @click="clearSelection()" type="button" class="fm-btn" style="padding:2px 8px;font-size:12px;color:#ef4444;background:none;border:none;">
                        Clear
                    </button>
                </div>
            </template>
            <template x-if="selectedFiles.length === 1">
                <div style="display:flex;align-items:center;gap:8px;">
                    <span style="background:#ede9fe;color:#6d28d9;border:1px solid #ddd6fe;border-radius:9999px;padding:3px 10px;font-size:12px;font-weight:600;display:flex;align-items:center;gap:5px;">
                        <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span style="max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" x-text="selectedFileName"></span>
                    </span>
                    <button @click="clearSelection()" type="button" class="fm-btn" style="padding:2px 8px;font-size:12px;color:#ef4444;background:none;border:none;">
                        Clear
                    </button>
                </div>
            </template>
            <template x-if="selectedFiles.length === 0">
                <span style="color:#64748b;font-size:12px;">Click an image or use Multi-Select to select files.</span>
            </template>
        </div>

        {{-- Action Buttons --}}
        <div style="display:flex;align-items:center;gap:10px;">
            <button @click="closeManager()" type="button" class="fm-btn fm-btn-outline" style="padding:9px 18px;">
                Cancel
            </button>

            <button @click="confirmAndApplySelection()" type="button" class="fm-btn"
                :disabled="selectedFiles.length === 0"
                :style="selectedFiles.length > 0 ? 'background:linear-gradient(135deg, #7c3aed 0%, #6366f1 100%);color:#ffffff;border:none;box-shadow:0 4px 14px rgba(124,58,237,0.35);cursor:pointer;' : 'background:#e2e8f0;color:#94a3b8;border:none;cursor:not-allowed;box-shadow:none;'"
                style="padding:9px 24px;font-size:13px;font-weight:600;border-radius:10px;">
                <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                <span x-text="selectedFiles.length > 1 ? ('Select ' + selectedFiles.length + ' Files') : 'Select File'"></span>
            </button>
        </div>
    </div>

    {{-- Hidden input synced to Filament form if needed --}}
    <input type="hidden" id="fm-selected-file" wire:model="data.selected_file" :value="selectedFile" />
</div>

<script>
    window.fileManager = function() {
        return {
            currentDir: '',
            folders: [],
            files: [],
            loading: false,
            search: '',
            selectedFiles: [],
            isMultiSelect: false,
            selectedFolder: '',
            breadcrumbs: [],
            showCreateDropdown: false,
            showNewFolderInput: false,
            newFolderName: '',

            get selectedFile() {
                return this.selectedFiles.length > 0 ? this.selectedFiles[this.selectedFiles.length - 1] : '';
            },
            set selectedFile(val) {
                if (!val) {
                    this.selectedFiles = [];
                } else if (!this.selectedFiles.includes(val)) {
                    this.selectedFiles = [val];
                }
            },
            get selectedFileName() {
                if (this.selectedFiles.length === 0) return '';
                return this.selectedFiles[this.selectedFiles.length - 1].split('/').pop();
            },

            get csrfToken() {
                return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
            },
            get baseUrl() {
                const match = window.location.pathname.match(/^(.*?)(\/admin)(\/|$)/);
                const prefix = (match && match[1]) ? match[1] : '';
                return prefix + '/admin/file-manager';
            },
            get filteredFolders() {
                if (!this.search) return this.folders;
                const s = this.search.toLowerCase();
                return this.folders.filter(f => f.name.toLowerCase().includes(s));
            },
            get filteredFiles() {
                if (!this.search) return this.files;
                const s = this.search.toLowerCase();
                return this.files.filter(f => f.name.toLowerCase().includes(s));
            },

            isTemplatePreview(file) {
                const path = String(file.path || '').toLowerCase().replaceAll('_', '-').replaceAll(' ', '-');
                return path.includes('template');
            },

            async init() {
                window.addEventListener('open-file-manager-modal', () => {
                    this.browse(this.currentDir || '');
                });
                await this.browse('');
            },

            async browse(dir) {
                this.loading = true;
                this.currentDir = dir;
                this.buildBreadcrumbs(dir);
                this.showCreateDropdown = false;
                this.showNewFolderInput = false;
                try {
                    const res = await fetch(this.baseUrl + '/browse?dir=' + encodeURIComponent(dir), {
                        headers: { 'Accept': 'application/json' }
                    });
                    if (res.ok) {
                        const data = await res.json();
                        this.folders = data.folders ?? [];
                        this.files = data.files ?? [];
                    } else {
                        console.error('FM browse failed with status:', res.status);
                    }
                } catch (e) { console.error('FM browse error:', e); }
                this.loading = false;
            },

            goBack() {
                if (!this.currentDir) return;
                const parts = this.currentDir.split('/');
                parts.pop();
                this.browse(parts.join('/'));
            },

            buildBreadcrumbs(dir) {
                this.breadcrumbs = [];
                if (!dir) return;
                const parts = dir.split('/');
                let acc = '';
                parts.forEach(p => {
                    acc = acc ? acc + '/' + p : p;
                    this.breadcrumbs.push({ name: p, path: acc });
                });
            },

            toggleMultiSelect() {
                this.isMultiSelect = !this.isMultiSelect;
            },

            isFileSelected(path) {
                return this.selectedFiles.includes(path);
            },

            toggleSelectFile(path) {
                if (this.selectedFiles.includes(path)) {
                    this.selectedFiles = this.selectedFiles.filter(p => p !== path);
                } else {
                    this.selectedFiles.push(path);
                }
                this.selectedFolder = '';
                this.syncInputs(path);
            },

            handleCardClick(file) {
                if (this.isMultiSelect) {
                    this.toggleSelectFile(file.path);
                } else {
                    if (this.selectedFiles.length === 1 && this.selectedFiles[0] === file.path) {
                        this.selectedFiles = [];
                    } else {
                        this.selectedFiles = [file.path];
                        this.syncInputs(file.path);
                    }
                    this.selectedFolder = '';
                }
            },

            handleCardDblClick(file) {
                if (!this.selectedFiles.includes(file.path)) {
                    this.selectedFiles = [file.path];
                }
                this.confirmAndApplySelection();
            },

            toggleSelectAll() {
                const allPaths = this.filteredFiles.map(f => f.path);
                const allSelected = allPaths.length > 0 && allPaths.every(p => this.selectedFiles.includes(p));
                if (allSelected) {
                    this.selectedFiles = this.selectedFiles.filter(p => !allPaths.includes(p));
                } else {
                    allPaths.forEach(p => {
                        if (!this.selectedFiles.includes(p)) {
                            this.selectedFiles.push(p);
                        }
                    });
                    this.isMultiSelect = true;
                }
                this.selectedFolder = '';
            },

            areAllFilesSelected() {
                const allPaths = this.filteredFiles.map(f => f.path);
                return allPaths.length > 0 && allPaths.every(p => this.selectedFiles.includes(p));
            },

            clearSelection() {
                this.selectedFiles = [];
                this.selectedFolder = '';
            },

            selectFolder(path) {
                this.selectedFolder = path;
                this.selectedFiles = [];
            },

            syncInputs(path) {
                const el = document.getElementById('fm-selected-file');
                if (el) {
                    el.value = path || '';
                    el.dispatchEvent(new Event('input', { bubbles: true }));
                    el.dispatchEvent(new Event('change', { bubbles: true }));
                }

                document.querySelectorAll('input').forEach(input => {
                    const name = input.getAttribute('name') || '';
                    const wireModel = input.getAttribute('wire:model') || '';
                    if (name.includes('selected_file') || wireModel.includes('selected_file')) {
                        input.value = path || '';
                        input.dispatchEvent(new Event('input', { bubbles: true }));
                        input.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                });

                try {
                    (window.Livewire?.all() ?? []).forEach(c => {
                        try { c.set('mountedActions.0.data.selected_file', path); } catch(e) {}
                        try { c.set('mountedActionData.selected_file', path); } catch(e) {}
                        try { c.set('data.selected_file', path); } catch(e) {}
                    });
                } catch(e) {}
            },

            closeModal() {
                window.dispatchEvent(new CustomEvent('close-file-manager-modal'));
                window.dispatchEvent(new CustomEvent('close-modal'));
                document.dispatchEvent(new CustomEvent('close-modal'));

                const fmWrap = document.querySelector('.fm-wrap');
                const fmModal = fmWrap ? fmWrap.closest('.fi-modal') : null;

                if (fmModal) {
                    const closeBtn = fmModal.querySelector('.fi-modal-close-btn, button[aria-label="Close"], button[aria-label="close"]');
                    if (closeBtn) {
                        closeBtn.click();
                        return;
                    }
                    if (fmModal._x_dataStack) {
                        fmModal._x_dataStack.forEach(data => {
                            if (data && 'isOpen' in data) data.isOpen = false;
                            if (data && typeof data.close === 'function') data.close();
                        });
                    }
                } else {
                    const closeBtn = document.querySelector('.fi-modal:has(.fm-wrap) .fi-modal-close-btn, .fi-modal:has(.fm-wrap) button[aria-label="Close"]');
                    if (closeBtn) closeBtn.click();
                }
            },

            closeManager() {
                const fmWrap = document.querySelector('.fm-wrap');
                const fmModal = fmWrap ? fmWrap.closest('.fi-modal') : null;

                if (!fmModal) {
                    window.location.assign(this.baseUrl.replace(/\/file-manager$/, ''));
                    return;
                }

                this.closeModal();
            },

            async confirmAndApplySelection() {
                if (this.selectedFiles.length === 0) return;

                this.loading = true;

                try {
                    const filesToApply = this.selectedFiles.map(path => {
                        const matched = this.files.find(f => f.path === path);
                        let fileUrl = matched?.url;
                        if (!fileUrl) {
                            const prefix = window.location.pathname.startsWith('/admin2') ? '/admin2' : '';
                            fileUrl = window.location.origin + prefix + '/storage/' + path.replace(/^\//, '');
                        }
                        const name = path.split('/').pop();
                        const ext = name.split('.').pop().toLowerCase();
                        let mimeType = 'image/png';
                        if (['jpg', 'jpeg'].includes(ext)) mimeType = 'image/jpeg';
                        else if (['webp'].includes(ext)) mimeType = 'image/webp';
                        else if (['svg'].includes(ext)) mimeType = 'image/svg+xml';
                        else if (['mp4'].includes(ext)) mimeType = 'video/mp4';

                        return {
                            path: path,
                            name: name,
                            size: matched?.size || 100000,
                            url: fileUrl,
                            mimeType: mimeType
                        };
                    });

                    // If triggered from custom slot (e.g. Premium Templates)
                    if (window._lastActiveUploadSlot) {
                        const slot = window._lastActiveUploadSlot;
                        const selectedPath = filesToApply[0].path;
                        window._lastActiveUploadSlot = null;

                        if (window.Livewire) {
                            window.Livewire.dispatch('set-premium-template-image', { slot: slot, path: selectedPath });
                        }

                        this.closeModal();
                        return;
                    }

                    // Determine target upload area
                    const uploadArea = window._lastActiveUploadArea || document.querySelector('.fi-fo-file-upload');

                    if (uploadArea) {
                        const alpine = uploadArea._x_dataStack ? uploadArea._x_dataStack[0] : (window.Alpine ? window.Alpine.$data(uploadArea) : null);

                        if (alpine && alpine.pond) {
                            if (filesToApply.length > 1) {
                                alpine.pond.allowMultiple = true;
                            }
                            const newFileKeyIndex = {};
                            const newUploadedFileIndex = {};
                            const newState = {};

                            filesToApply.forEach(item => {
                                const fileKey = 'fm_' + Math.random().toString(36).substring(2, 9);
                                newFileKeyIndex[fileKey] = {
                                    name: item.name,
                                    size: item.size,
                                    type: item.mimeType,
                                    url: item.url,
                                    openableUrl: item.url,
                                    downloadableUrl: item.url
                                };
                                newUploadedFileIndex[item.url] = fileKey;
                                newState[fileKey] = item.path;
                            });

                            alpine.fileKeyIndex = newFileKeyIndex;
                            alpine.uploadedFileIndex = newUploadedFileIndex;
                            alpine.state = newState;
                            alpine.lastState = JSON.stringify(newState);

                            // Load into FilePond as local files so previews are rendered cleanly
                            if (typeof alpine.buildPondFiles === 'function') {
                                alpine.pond.files = alpine.buildPondFiles();
                            } else {
                                alpine.pond.files = filesToApply.map(item => ({
                                    source: item.url,
                                    options: {
                                        type: 'local',
                                        file: { name: item.name, type: item.mimeType }
                                    }
                                }));
                            }
                        } else if (window.FilePond) {
                            const pondEl = uploadArea.querySelector('.filepond--root') || uploadArea;
                            const pond = window.FilePond.find(pondEl);
                            if (pond) {
                                if (filesToApply.length > 1) {
                                    pond.allowMultiple = true;
                                }
                                pond.removeFiles();
                                for (const item of filesToApply) {
                                    await pond.addFile(item.url, {
                                        type: 'local',
                                        file: { name: item.name, type: item.mimeType }
                                    });
                                }
                            }
                        }

                        // Remove any error messages if present
                        uploadArea.closest('.fi-fo-field-wrp')?.querySelectorAll('[class*="error"], [class*="text-danger"]')?.forEach(el => {
                            if (el.textContent.includes('failed to upload')) el.remove();
                        });

                        // If not in repeater or action modal, set Livewire state directly if possible
                        if (!uploadArea.closest('.fi-fo-repeater-item') && !uploadArea.closest('.fi-modal')) {
                            let fieldKey = 'data.design';
                            const fieldWrp = uploadArea.closest('.fi-fo-field-wrp');
                            const label = fieldWrp?.querySelector('label')?.textContent?.toLowerCase() || '';
                            if (label.includes('video')) fieldKey = 'data.video';
                            else if (label.includes('thumbnail')) fieldKey = 'data.thumbnail';
                            else if (label.includes('image')) fieldKey = 'data.image';
                            else if (label.includes('symbol')) fieldKey = 'data.symbol';

                            try {
                                (window.Livewire?.all() ?? []).forEach(c => {
                                    try { c.set(fieldKey, newState); } catch(e) {}
                                    if (filesToApply.length === 1) {
                                        try { c.set(fieldKey, filesToApply[0].path); } catch(e) {}
                                    }
                                });
                            } catch(e) {}
                        }
                    }
                } catch (err) {
                    console.error('Apply selection error:', err);
                } finally {
                    this.loading = false;
                    this.closeModal();
                }
            },

            openCreateFolder() {
                this.showCreateDropdown = false;
                this.showNewFolderInput = true;
                this.newFolderName = '';
                this.$nextTick(() => {
                    this.$refs.newFolderInput?.focus();
                });
            },

            async submitCreateFolder() {
                const name = (this.newFolderName || '').trim();
                if (!name) {
                    this.showNewFolderInput = false;
                    return;
                }
                this.showNewFolderInput = false;
                this.newFolderName = '';
                this.loading = true;
                try {
                    const res = await fetch(this.baseUrl + '/create-folder', {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/json', 
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': this.csrfToken 
                        },
                        body: JSON.stringify({ parent: this.currentDir, name })
                    });
                    const data = await res.json().catch(() => ({}));
                    if (!res.ok || data.error) {
                        alert(data.error || 'Failed to create folder');
                    }
                } catch (e) { 
                    console.error('Create folder error:', e); 
                    alert('Create folder error: ' + e.message);
                }
                await this.browse(this.currentDir);
            },

            triggerUpload() {
                this.showCreateDropdown = false;
                document.getElementById('fm-file-upload-input')?.click();
            },

            triggerTemplateUpload() {
                this.showCreateDropdown = false;
                document.getElementById('fm-template-upload-input')?.click();
            },

            async handleUpload(event) {
                const files = event.target.files;
                if (!files || !files.length) return;
                this.loading = true;
                for (let f of files) {
                    const formData = new FormData();
                    formData.append('dir', this.currentDir || '');
                    formData.append('file', f);
                    try {
                        const res = await fetch(this.baseUrl + '/upload', {
                            method: 'POST',
                            headers: { 
                                'Accept': 'application/json', 
                                'X-CSRF-TOKEN': this.csrfToken 
                            },
                            body: formData
                        });
                        const data = await res.json().catch(() => ({}));
                        if (!res.ok || data.error) {
                            alert(data.error || 'Upload failed');
                        }
                    } catch(e) { 
                        console.error('Upload error:', e); 
                        alert('Upload failed: ' + e.message);
                    }
                }
                event.target.value = '';
                await this.browse(this.currentDir);
            },

            async deleteSelected() {
                const isFolder = this.selectedFiles.length === 0 && this.selectedFolder !== '';
                if (this.selectedFiles.length === 0 && !isFolder) return;

                if (isFolder) {
                    const name = this.selectedFolder.split('/').pop();
                    if (!confirm('Delete "' + name + '"?\n\nThis will delete the folder and ALL its contents.')) return;
                    try {
                        const res = await fetch(this.baseUrl + '/delete-folder?path=' + encodeURIComponent(this.selectedFolder), {
                            method: 'DELETE',
                            headers: { 
                                'Accept': 'application/json', 
                                'X-CSRF-TOKEN': this.csrfToken 
                            }
                        });
                        const data = await res.json().catch(() => ({}));
                        if (!res.ok || data.error) alert(data.error || 'Delete folder failed');
                        this.selectedFolder = '';
                    } catch(e) { 
                        console.error('Delete error:', e); 
                        alert('Delete error: ' + e.message);
                    }
                } else {
                    const count = this.selectedFiles.length;
                    const confirmMsg = count === 1 
                        ? 'Delete "' + this.selectedFiles[0].split('/').pop() + '"?' 
                        : 'Delete ' + count + ' selected files?';
                    if (!confirm(confirmMsg)) return;

                    this.loading = true;
                    for (const path of this.selectedFiles) {
                        try {
                            const res = await fetch(this.baseUrl + '/delete-file?path=' + encodeURIComponent(path), {
                                method: 'DELETE',
                                headers: { 
                                    'Accept': 'application/json', 
                                    'X-CSRF-TOKEN': this.csrfToken 
                                }
                            });
                            const data = await res.json().catch(() => ({}));
                            if (!res.ok || data.error) console.error('Delete failed for ' + path, data.error);
                        } catch(e) { 
                            console.error('Delete error for ' + path, e); 
                        }
                    }
                    this.selectedFiles = [];
                    this.selectedFolder = '';
                }
                await this.browse(this.currentDir);
            }
        };
    };

    if (window.Alpine) {
        window.Alpine.data('fileManager', window.fileManager);
    }
    document.addEventListener('alpine:init', () => {
        window.Alpine.data('fileManager', window.fileManager);
    });
</script>
