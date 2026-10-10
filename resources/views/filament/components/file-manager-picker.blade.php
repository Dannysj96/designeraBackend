<div class="space-y-4">
    <div class="flex items-center justify-between pb-2 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">
            Select a file from Media Library / File Manager
        </h3>
        <span class="text-xs text-gray-500">
            Total files: {{ count($files) }}
        </span>
    </div>

    @if(empty($files))
        <div class="p-8 text-center bg-gray-50 dark:bg-gray-800 rounded-xl border border-dashed border-gray-300 dark:border-gray-700">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="mt-2 text-sm text-gray-500">No media files found in storage. Upload a new file using the upload box!</p>
        </div>
    @else
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 max-h-[420px] overflow-y-auto p-1">
            @foreach($files as $file)
                <label 
                    class="relative group cursor-pointer border rounded-xl overflow-hidden shadow-xs hover:shadow-md transition bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 hover:border-primary-500 dark:hover:border-primary-400 p-2 text-center flex flex-col items-center justify-between"
                >
                    <input 
                        type="radio" 
                        name="{{ $statePath }}" 
                        wire:model="{{ $statePath }}" 
                        value="{{ $file['path'] }}" 
                        class="sr-only peer"
                    />

                    <div class="w-full h-24 flex items-center justify-center bg-gray-100 dark:bg-gray-900 rounded-lg overflow-hidden relative">
                        @if($file['is_video'])
                            <video src="{{ $file['url'] }}" class="w-full h-full object-cover"></video>
                            <span class="absolute inset-0 flex items-center justify-center bg-black/40 text-white">
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                </svg>
                            </span>
                        @else
                            <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" class="w-full h-full object-cover" />
                        @endif

                        <div class="absolute inset-0 bg-primary-500/20 opacity-0 peer-checked:opacity-100 transition flex items-center justify-center">
                            <span class="bg-primary-600 text-white rounded-full p-1 shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="mt-2 w-full text-left">
                        <p class="text-xs font-medium text-gray-700 dark:text-gray-300 truncate" title="{{ $file['name'] }}">
                            {{ $file['name'] }}
                        </p>
                        <p class="text-[10px] text-gray-400">
                            {{ $file['size'] }}
                        </p>
                    </div>
                </label>
            @endforeach
        </div>
    @endif
</div>
