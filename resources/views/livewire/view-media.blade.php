@if($messageAttachment)
    <div class="bg-gray-900 p-3 flex justify-center items-center">
        <img src="{{ asset('storage/attachments/' . $messageAttachment->attachment_path) }}" alt="Attachment" class="max-h-[80dvh] rounded-lg"/>
    </div>
@elseif($message)
    {{-- Make a carousel of all images in the message, use $currentImageIndex to determine which image to show --}}
    <div class="relative bg-gray-900 p-3 flex justify-center items-center">
        <div class="absolute left-0 top-0 bottom-0 flex items-center justify-center w-12 cursor-pointer" wire:click="previousImage">
            <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <!-- Outline stroke -->
                <path stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M15 19l-7-7 7-7"/>
                <!-- Inner stroke -->
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>

        </div>
        <div class="absolute right-0 top-0 bottom-0 flex items-center justify-center w-12 cursor-pointer" wire:click="nextImage">
            <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <!-- Outline stroke -->
                <path stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M9 5l7 7-7 7"/>
                <!-- Inner stroke -->
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
        <img src="{{ asset('storage/attachments/' . $message->attachments[$currentImageIndex]->attachment_path) }}" alt="Attachment" class="max-h-[80dvh] max-w-[88%] rounded-lg"/>
    </div>
@else
    <div class="bg-gray-900 p-3 flex justify-center items-center">
        <div class="text-gray-400 text-2xl">
            No media to display.
        </div>
    </div>
@endif
