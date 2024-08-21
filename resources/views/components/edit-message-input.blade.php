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
