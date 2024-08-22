<div class="flex flex-row items-center h-16 py-7 bg-white dark:bg-gray-800 w-full px-4 md:px-10">
    <div>
        <button wire:click="$dispatch('openModal', { component: 'message-attachment', arguments: { conversation: {{ $activeConversation->id }} }})" class="flex items-center justify-center text-gray-400 hover:text-gray-600 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
            </svg>
        </button>
    </div>
    <div class="flex-grow ml-4">
        <div class="relative w-full" x-data="{ isFocused: false }">
            <input
                wire:model="messageInput"
                wire:keydown.enter="sendMessage(); $dispatch('message-loading-started')"
                type="text"
                class="flex w-full border dark:border-gray-700 rounded-xl focus:outline-none focus:border-indigo-300 dark:bg-gray-900 pl-4 h-10 transition dark:text-gray-100"
                placeholder="Start typing..."
                @focus="isFocused = true"
                @blur="isFocused = false"
                @keyup.arrow-up.window="if (isFocused) $dispatch('edit-last-message')"
            />
        </div>
    </div>
    <div class="ml-4" x-data="{ loading: false, timeout: null }" @message-sent-loading-finished.window="loading = false; clearTimeout(timeout);">
        <button
            wire:click="sendMessage()"
            @click="loading = true; timeout = setTimeout(() => { loading = false }, 10000)"
            x-on:message-loading-started.window="loading = true; timeout = setTimeout(() => { loading = false }, 10000)"
            class="flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-lg text-white border dark:border-gray-700 px-4 py-1.5 flex-shrink-0 transition"
            :disabled="loading"
        >
            <div x-show="!loading" class="flex items-center">
                <span>
                    <svg class="w-4 h-4 transform rotate-45 -mt-px" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </span>
                <span class="ml-2">Send</span>
            </div>
            <div x-show="loading" class="flex items-center">
                <span>
                    <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z"/>
                    </svg>
                </span>
                <span class="ml-2">Send</span>
            </div>
        </button>
    </div>
</div>
