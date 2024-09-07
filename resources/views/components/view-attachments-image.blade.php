@php
    // If thumbnail, use it, else use the attachment path
    $thumbnailPath = $attachment->thumbnail_path ? $attachment->thumbnail_path : $attachment->attachment_path;
@endphp

<div class="relative mt-2">
    <img src="{{ asset('storage/' . $thumbnailPath) }}"
         alt="An image sent by {{ $attachment->message->user->name }}"
         class="rounded-lg h-[300px] object-cover cursor-pointer transition-transform duration-300 hover:scale-105 bg-gray-200 dark:bg-gray-950"
         wire:click="$dispatch('openModal', { component: 'view-media', arguments: { messageAttachment: {{ $attachment->id }} }})" />
</div>
