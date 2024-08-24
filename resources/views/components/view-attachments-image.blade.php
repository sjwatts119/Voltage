<div class="relative mt-2 inline-block">
    <button wire:click="$dispatch('openModal', { component: 'view-media', arguments: { messageAttachment: {{ $attachment->id }} }})">
        <img src="{{ asset('storage/attachments/' . $attachment->attachment_path) }}" alt="An image sent by {{ $attachment->message->user->name }}" class="rounded-lg max-w-full max-h-[250px] w-full h-auto object-contain" />
    </button>
</div>
