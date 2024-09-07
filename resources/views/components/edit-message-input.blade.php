<form wire:submit.prevent="updateMessage($event.target.elements.message.value)"
      autocomplete="off"
      x-data
      x-init="$nextTick(() => {
                              const input = $refs.messageInput;
                              input.focus();
                              input.setSelectionRange(input.value.length, input.value.length);
                          })"
      @keydown.window.escape="$dispatch('cancel-editing-message')">
    <div class="flex items-center space-x-2 my-1">
        <input
            x-ref="messageInput"
            name="message"
            type="text"
            class="text-sm w-full dark:bg-gray-800 dark:text-white rounded-lg p-1 px-2 focus:outline-none"
            placeholder="Edit your message..."
            value="{{$message->message}}"
            @keydown.escape.window="$dispatch('cancel-editing-message')"
        >
        <button type="submit" class="text-sm text-white rounded-lg focus:outline-none">
            <svg class="w-5 h-5 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11.917 9.724 16.5 19 7.5"/>
            </svg>
        </button>
        <button wire:click="cancelEditingMessage()" type="button" class="text-md dark:text-white rounded-lg focus:outline-none">X</button>
    </div>
</form>

@if($this->editedAttachments)
    <div class="flex space-x-3 my-3">
        @foreach($this->editedAttachments as $attachment)
            <div class="relative w-28 h-28">
                {{-- If the attachment is an image, display the image --}}
                @php
                    $supportedImageExtensions = ['svg', 'png', 'jpg', 'gif', 'jpeg', 'bmp', 'webp'];
                @endphp
                @if(in_array($attachment->getFileExtension(), $supportedImageExtensions))
                    <img src="{{ asset('storage/' . ($attachment->thumbnail_path ?: $attachment->attachment_path)) }}"
                         alt="An image sent by {{ $attachment->message->user->name }}"
                         class="w-full h-full rounded-lg object-cover"
                         wire:click="$dispatch('openModal', { component: 'view-media', arguments: { messageAttachment: {{ $attachment->id }} }})"
                    />
                @else
                    <div class="flex flex-col items-center justify-center dark:bg-gray-800 h-full rounded-lg">
                        <span class="text-lg font-semibold text-gray-600 dark:text-gray-300 uppercase">{{ $attachment->getFileExtension() }}</span>
                        <svg class="w-12 h-12 text-gray-600 dark:text-gray-300 mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6H6c-1.1 0-2 .9-2 2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v6h6"/>
                        </svg>
                    </div>
                @endif
                <button wire:click="removeAttachment({{ $attachment->id }})" class="transition absolute top-1 right-1 text-white bg-red-500 rounded-md hover:bg-red-700 hover:text-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endforeach
    </div>
@endif
