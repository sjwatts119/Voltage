@php
    $classes = $classes ?? '';

    // If the attachment has a thumbnail, use it, else use the attachment path
    $thumbnailPath = $attachment->thumbnail_path ? $attachment->thumbnail_path : $attachment->attachment_path;
@endphp

<img src="{{ asset('storage/' . $thumbnailPath) }}" alt="An image sent by {{ $attachment->message->user->name }}" class="{{ $classes }}" wire:click="$dispatch('openModal', { component: 'view-media', arguments: { message: {{ $attachment->message->id }}, currentImageIndex: {{ $currentIndex }} }})" />
