<div class="flex items-center space-x-4 p-4 rounded-lg bg-gray-100 dark:bg-gray-800 my-1 max-w-lg">
    <div class="flex flex-col items-center ">
        <span class="text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase">{{ pathinfo($attachment->attachment_path, PATHINFO_EXTENSION) }}</span>
        <svg class="w-8 h-8 text-gray-600 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6H6c-1.1 0-2 .9-2 2z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v6h6"/>
        </svg>
    </div>

    <div class="flex-1">
        <a href="{{ asset('storage/attachments/' . $attachment->attachment_path) }}" target="_blank" class="block text-sm text-gray-900 dark:text-gray-200 hover:text-gray-700 dark:hover:text-gray-300 truncate max-w-md">
            {{ basename($attachment->attachment_path) }}
        </a>
        <span class="text-xs text-gray-500 dark:text-gray-400">
            {{ $attachment->getFileSize() }}
        </span>
    </div>

    <div class="relative">
        <a href="{{ asset('storage/attachments/' . $attachment->attachment_path) }}" download>
            <button data-tooltip-target="download-attachment-{{ $loop->index + 1 }}" class="inline-flex items-center justify-center rounded-full h-8 w-8 bg-white/30 hover:bg-white/50 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50">
                <svg class="w-4 h-4 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 1v11m0 0 4-4m-4 4L4 8m11 4v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3"/>
                </svg>
            </button>
        </a>
        <div id="download-attachment-{{ $loop->index + 1 }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
            Download attachment
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
    </div>
</div>
