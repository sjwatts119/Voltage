<div class="relative mt-2 inline-block">
    <div class="absolute inset-0 bg-gray-900/50 opacity-0 hover:opacity-100 transition-opacity duration-300 rounded-lg flex items-center justify-center w-full h-full">
        <a href="{{ asset('storage/attachments/' . $attachment->attachment_path) }}" download>
            <button data-tooltip-target="download-image" class="inline-flex items-center justify-center rounded-full h-10 w-10 bg-white/30 hover:bg-white/50 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50">
                <svg class="w-5 h-5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 18">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 1v11m0 0 4-4m-4 4L4 8m11 4v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3"/>
                </svg>
            </button>
        </a>
        <div id="download-image" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
            Download image
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
    </div>
    <img src="{{ asset('storage/attachments/' . $attachment->attachment_path) }}" alt="An image sent by {{ $attachment->message->user->name }}" class="rounded-lg max-w-full max-h-[250px] w-full h-auto object-contain" />
</div>
