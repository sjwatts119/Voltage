@if($attachments->count() === 2)
    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 mt-2 w-full lg:w-2/3 xl:w-1/2 2xl:w-1/3">
        @foreach($attachments as $attachment)
            <div class="relative">
                <x-thumbnail :attachment="$attachment" :currentIndex="$loop->index" classes="rounded-lg w-full h-[250px] object-cover cursor-pointer transition-transform duration-300 hover:scale-105 bg-gray-200 dark:bg-gray-950" />
            </div>
        @endforeach
    </div>

@elseif($attachments->count() === 3)
    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 mt-2 w-full lg:w-[79.6%] xl:w-[59.7%] 2xl:w-[39.9%]">
        @foreach($attachments as $attachment)
            @if($loop->first)
                <div class="relative md:row-span-2 h-[250px] md:h-[266px]">
                    <x-thumbnail :attachment="$attachment" :currentIndex="$loop->index" classes="rounded-lg w-full h-full object-cover cursor-pointer transition-transform duration-300 hover:scale-105 bg-gray-200 dark:bg-gray-950" />
                </div>
            @else
                <div class="relative h-[250px] md:h-[125px] w-full lg:w-2/3">
                    <x-thumbnail :attachment="$attachment" :currentIndex="$loop->index" classes="rounded-lg w-full h-full object-cover cursor-pointer transition-transform duration-300 hover:scale-105 bg-gray-200 dark:bg-gray-950" />
                </div>
            @endif
        @endforeach
    </div>

@elseif($attachments->count() > 3)
    {{-- Show the first 3 images, and a button with + the remaining images --}}
    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 mt-2 w-full lg:w-2/3 xl:w-1/2 2xl:w-1/3">
        @foreach($attachments->take(3) as $attachment)
            <div class="relative">
                <x-thumbnail :attachment="$attachment" :currentIndex="$loop->index" classes="rounded-lg w-full h-[250px] md:h-[175px] object-cover cursor-pointer transition-transform duration-300 hover:scale-105 bg-gray-200 dark:bg-gray-950" />
            </div>
        @endforeach
        <div class="relative">
            <button wire:click="$dispatch('openModal', { component: 'view-media', arguments: { message: {{ $attachments[0]->message->id }}, currentImageIndex: 3}})" class="absolute inset-0 bg-gray-900/90 hover:bg-gray-900/50 transition-all duration-300 rounded-lg flex items-center justify-center">
                <span class="text-xl font-medium text-white">+{{ $attachments->count() - 3 }}</span>
            </button>
            <x-thumbnail :attachment="$attachments[3]" :currentIndex="3" classes="rounded-lg w-full h-[250px] md:h-[175px] object-cover bg-gray-200 dark:bg-gray-950" />
        </div>
    </div>
@endif
