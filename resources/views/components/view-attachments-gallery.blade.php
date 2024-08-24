@if($attachments->count() === 2)
    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 mt-2 w-full lg:w-2/3 xl:w-1/2">
        @foreach($attachments as $attachment)
            <div class="relative">
                <img src="{{ asset('storage/attachments/' . $attachment->attachment_path) }}" alt="An image sent by {{ $attachment->message->user->name }}" class="rounded-lg w-full h-[250px] object-cover cursor-pointer transition-transform duration-300 hover:scale-105" wire:click="$dispatch('openModal', { component: 'view-media', arguments: { message: {{ $attachment->message->id }} }})" />
            </div>
        @endforeach
    </div>

@elseif($attachments->count() === 3)
    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 mt-2 w-full lg:w-2/3 xl:w-1/2">
        @foreach($attachments as $attachment)
            @if($loop->first)
                <div class="relative md:row-span-2 h-[266px]">
                    <img src="{{ asset('storage/attachments/' . $attachment->attachment_path) }}" alt="An image sent by {{ $attachment->message->user->name }}" class="rounded-lg w-full h-full object-cover cursor-pointer transition-transform duration-300 hover:scale-105" wire:click="$dispatch('openModal', { component: 'view-media', arguments: { message: {{ $attachment->message->id }}, currentImageIndex: {{ $loop->index }} }})" />
                </div>
            @else
                <div class="relative h-[125px] w-full xl:w-2/3">
                    <img src="{{ asset('storage/attachments/' . $attachment->attachment_path) }}" alt="An image sent by {{ $attachment->message->user->name }}" class="rounded-lg w-full h-full object-cover cursor-pointer transition-transform duration-300 hover:scale-105" wire:click="$dispatch('openModal', { component: 'view-media', arguments: { message: {{ $attachment->message->id }}, currentImageIndex: {{ $loop->index }} }})" />
                </div>
            @endif
        @endforeach
    </div>

@elseif($attachments->count() > 3)
    {{-- Show the first 3 images, and a button with + the remaining images --}}
    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 mt-2 w-full lg:w-2/3 xl:w-1/2">
        @foreach($attachments->take(3) as $attachment)
            <div class="relative">
                <img src="{{ asset('storage/attachments/' . $attachment->attachment_path) }}" alt="An image sent by {{ $attachment->message->user->name }}" class="rounded-lg w-full h-[175px] object-cover cursor-pointer transition-transform duration-300 hover:scale-105" wire:click="$dispatch('openModal', { component: 'view-media', arguments: { message: {{ $attachment->message->id }}, currentImageIndex: {{ $loop->index }} }})" />
            </div>
        @endforeach
        <div class="relative">
            <button wire:click="$dispatch('openModal', { component: 'view-media', arguments: { message: {{ $attachments[0]->message->id }}, currentImageIndex: 3}})" class="absolute inset-0 bg-gray-900/90 hover:bg-gray-900/50 transition-all duration-300 rounded-lg flex items-center justify-center">
                <span class="text-xl font-medium text-white">+{{ $attachments->count() - 3 }}</span>
            </button>
            <img src="{{ asset('storage/attachments/' . $attachments[3]->attachment_path) }}" alt="An image sent by {{ $attachments[3]->message->user->name }}" class="rounded-lg w-full h-[175px] object-cover" />
        </div>
    </div>
@endif
