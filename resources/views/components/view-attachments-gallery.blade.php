@if($attachments->count() === 2)
<div class="grid gap-4 grid-cols-1 md:grid-cols-2 mt-2 w-full lg:w-2/3 xl:w-1/2">
    @foreach($attachments as $attachment)
        <div class="relative">
            <div class="absolute w-full h-full bg-gray-900/50 opacity-0 hover:opacity-100 transition-opacity duration-300 rounded-lg flex items-center justify-center">
                <a href="{{ asset('storage/attachments/' . $attachment->attachment_path) }}" download>
                    <button data-tooltip-target="download-image-{{ $loop->index + 1 }}" class="inline-flex items-center justify-center rounded-full h-8 w-8 bg-white/30 hover:bg-white/50 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50">
                        <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 1v11m0 0 4-4m-4 4L4 8m11 4v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3"/>
                        </svg>
                    </button>
                </a>
                <div id="download-image-{{ $loop->index + 1 }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Download image
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </div>
            <img src="{{ asset('storage/attachments/' . $attachment->attachment_path) }}" alt="An image sent by {{ $attachment->message->user->name }}" class="rounded-lg w-full h-[250px] object-cover" />
        </div>
    @endforeach
</div>
@elseif($attachments->count() === 3)
    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 mt-2 w-full lg:w-2/3 xl:w-1/2">
        @foreach($attachments as $attachment)
            @if($loop->first)
                <div class="relative md:row-span-2">
                    <div class="absolute w-full h-full bg-gray-900/50 opacity-0 hover:opacity-100 transition-opacity duration-300 rounded-lg flex items-center justify-center">
                        <a href="{{ asset('storage/attachments/' . $attachment->attachment_path) }}" download>
                            <button data-tooltip-target="download-image-{{ $loop->index + 1 }}" class="inline-flex items-center justify-center rounded-full h-8 w-8 bg-white/30 hover:bg-white/50 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50">
                                <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 1v11m0 0 4-4m-4 4L4 8m11 4v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3"/>
                                </svg>
                            </button>
                        </a>
                        <div id="download-image-{{ $loop->index + 1 }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Download image
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>
                    <img src="{{ asset('storage/attachments/' . $attachment->attachment_path) }}" alt="An image sent by {{ $attachment->message->user->name }}" class="rounded-lg w-full h-[250px] md:h-full object-cover" />
                </div>
            @else
                <div class="relative md:h-full">
                    <div class="absolute inset-0 bg-gray-900/50 opacity-0 hover:opacity-100 transition-opacity duration-300 rounded-lg flex items-center justify-center">
                        <a href="{{ asset('storage/attachments/' . $attachment->attachment_path) }}" download>
                            <button data-tooltip-target="download-image-{{ $loop->index + 1 }}" class="inline-flex items-center justify-center rounded-full h-8 w-8 bg-white/30 hover:bg-white/50 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50">
                                <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 1v11m0 0 4-4m-4 4L4 8m11 4v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3"/>
                                </svg>
                            </button>
                        </a>
                        <div id="download-image-{{ $loop->index + 1 }}" role="tooltip" class="absolute z-10 invisible px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                            Download image
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </div>
                    <img src="{{ asset('storage/attachments/' . $attachment->attachment_path) }}" alt="An image sent by {{ $attachment->message->user->name }}" class="rounded-lg w-full h-[250px] md:h-[125px] object-cover" />
                </div>
            @endif
        @endforeach
    </div>
@elseif($attachments->count() > 3)
    {{-- We should show the first 3 images, and a button with + the remaining images --}}
    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 mt-2 w-full lg:w-2/3 xl:w-1/2">
        @foreach($attachments->take(3) as $attachment)
            <div class="relative">
                <div class="absolute w-full h-full bg-gray-900/50 opacity-0 hover:opacity-100 transition-opacity duration-300 rounded-lg flex items-center justify-center">
                    <a href="{{ asset('storage/attachments/' . $attachment->attachment_path) }}" download>
                        <button data-tooltip-target="download-image-{{ $loop->index + 1 }}" class="inline-flex items-center justify-center rounded-full h-8 w-8 bg-white/30 hover:bg-white/50 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50">
                            <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 18">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 1v11m0 0 4-4m-4 4L4 8m11 4v3a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-3"/>
                            </svg>
                        </button>
                    </a>
                    <div id="download-image-{{ $loop->index + 1 }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Download image
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>
                <img src="{{ asset('storage/attachments/' . $attachment->attachment_path) }}" alt="An image sent by {{ $attachment->message->user->name }}" class="rounded-lg w-full h-[250px] object-cover" />
            </div>
        @endforeach
        <div class="relative">
            <button class="absolute w-full h-full bg-gray-900/90 hover:bg-gray-900/50 transition-all duration-300 rounded-lg flex items-center justify-center">
                <span class="text-xl font-medium text-white">+{{ $attachments->count() - 3 }}</span>
                <div id="download-image" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                    Download image
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </button>
            <img src="{{ asset('storage/attachments/' . $attachments[0]->attachment_path) }}" alt="An image sent by {{ $attachments[0]->message->user->name }}" class="rounded-lg w-full h-[250px] object-cover" />
        </div>
    </div>
@endif
