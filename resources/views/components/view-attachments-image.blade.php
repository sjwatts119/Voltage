<div class="relative mt-2 inline-block">
    <img src="{{ asset('storage/attachments/' . $attachment->attachment_path) }}"
         alt="An image sent by {{ $attachment->message->user->name }}"
         class="rounded-lg w-full h-[300px] object-cover cursor-pointer transition-transform duration-300 hover:scale-105"
         wire:click="$dispatch('openModal', { component: 'view-media', arguments: { messageAttachment: {{ $attachment->id }} }})" />
</div>
