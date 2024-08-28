<div class="relative mt-2">
    <img src="{{ asset('storage/attachments/' . $attachment->message->id. '/thumbnail-' . $attachment->attachment_path) }}"
         alt="An image sent by {{ $attachment->message->user->name }}"
         class="rounded-lg h-[300px] object-cover cursor-pointer transition-transform duration-300 hover:scale-105"
         wire:click="$dispatch('openModal', { component: 'view-media', arguments: { messageAttachment: {{ $attachment->id }} }})" />
</div>
