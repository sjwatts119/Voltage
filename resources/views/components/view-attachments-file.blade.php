<div class="leading-1.5 flex w-full max-w-[350px] flex-col mt-2">
    <div class="flex items-start bg-white dark:bg-gray-800 rounded-xl p-2 shadow-sm">
        <div class="me-2 flex-grow">
            <span class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white pb-2">
                <svg fill="none" aria-hidden="true" class="w-7 h-7 flex-shrink-0" viewBox="0 0 20 21">
                    <g clip-path="url(#clip0_3173_1381)">
                        <path fill="#E2E5E7" d="M5.024.5c-.688 0-1.25.563-1.25 1.25v17.5c0 .688.562 1.25 1.25 1.25h12.5c.687 0 1.25-.563 1.25-1.25V5.5l-5-5h-8.75z"/>
                        <path fill="#B0B7BD" d="M15.024 5.5h3.75l-5-5v3.75c0 .688.562 1.25 1.25 1.25z"/>
                        <path fill="#CAD1D8" d="M18.774 9.25l-3.75-3.75h3.75v3.75z"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_3173_1381">
                            <path fill="#fff" d="M0 0h20v20H0z" transform="translate(0 .5)"/>
                        </clipPath>
                    </defs>
                </svg>
                {{ $attachment->original_filename }}
            </span>
            <span class="flex text-xs font-normal text-gray-500 dark:text-gray-400 gap-2 ml-2 sm:ml-9">
                {{ $attachment->getFileSize() }}
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="self-center" width="3" height="4" viewBox="0 0 3 4" fill="none">
                    <circle cx="1.5" cy="2" r="1.5" fill="#6B7280"/>
                </svg>
                {{ $attachment->getFileExtension() }}
            </span>
        </div>
        <div class="inline-flex self-center items-center">
            <a href="{{ asset('storage/attachments/' . $attachment->attachment_path) }}" download>
                <button data-tooltip-target="download-attachment-{{ $loop->index + 1 }}" class="transition inline-flex items-center justify-center rounded-full h-8 w-8 text-gray-900 hover:text-gray-500 dark:text-white dark:hover:text-gray-500">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 18">
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
</div>
