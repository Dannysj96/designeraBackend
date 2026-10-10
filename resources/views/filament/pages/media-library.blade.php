<x-filament-panels::page>
    <div class="space-y-6">
        <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-xl shadow-xs border border-gray-200 dark:border-gray-700">
            <div>
                <h2 class="text-base font-semibold text-gray-900 dark:text-gray-100">All Uploaded Media Files</h2>
                <p class="text-xs text-gray-500">Manage all images and video files stored in public storage.</p>
            </div>
            <div class="text-xs font-semibold px-3 py-1 bg-primary-50 dark:bg-primary-950 text-primary-600 dark:text-primary-400 rounded-full">
                Total Files: {{ count($this->mediaFiles) }}
            </div>
        </div>

        @if(empty($this->mediaFiles))
            <div class="p-12 text-center bg-white dark:bg-gray-800 rounded-xl border border-dashed border-gray-300 dark:border-gray-700">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No Media Files Uploaded Yet</h3>
                <p class="mt-1 text-xs text-gray-500">When files are uploaded via admin forms, they will appear here automatically.</p>
            </div>
        @else
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                @foreach($this->mediaFiles as $file)
                    <div class="group relative flex flex-col justify-between overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-xs transition hover:shadow-md">
                        <div class="relative h-36 w-full overflow-hidden bg-gray-100 dark:bg-gray-900 flex items-center justify-center">
                            @if($file['is_video'])
                                <video src="{{ $file['url'] }}" class="h-full w-full object-cover"></video>
                                <span class="absolute inset-0 flex items-center justify-center bg-black/40 text-white">
                                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                    </svg>
                                </span>
                            @else
                                <img src="{{ $file['url'] }}" alt="{{ $file['name'] }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" />
                            @endif
                        </div>

                        <div class="p-3">
                            <p class="truncate text-xs font-semibold text-gray-800 dark:text-gray-200" title="{{ $file['name'] }}">
                                {{ $file['name'] }}
                            </p>
                            <div class="mt-1 flex items-center justify-between text-[10px] text-gray-400">
                                <span>{{ $file['size'] }}</span>
                                <span>{{ substr($file['last_modified'], 0, 10) }}</span>
                            </div>

                            <div class="mt-3 flex items-center gap-2 pt-2 border-t border-gray-100 dark:border-gray-700/50">
                                <a href="{{ $file['url'] }}" target="_blank" class="flex-1 text-center text-xs font-medium text-primary-600 dark:text-primary-400 hover:underline">
                                    View
                                </a>
                                <button 
                                    wire:click="deleteFile('{{ $file['path'] }}')" 
                                    wire:confirm="Are you sure you want to delete this media file?"
                                    class="text-xs font-medium text-danger-600 dark:text-danger-400 hover:underline"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-filament-panels::page>
