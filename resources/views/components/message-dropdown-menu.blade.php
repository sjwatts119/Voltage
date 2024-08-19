<div x-data="{ open: false, isLoadingDelete: false }" @keydown.escape.window="open = false" class="relative" id="dropdown-{{ $message->id }}">
    <!-- Dropdown button -->
    <button @click="open = !open" class="invisible group-hover:visible transition inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-200 dark:hover:text-gray-500" type="button">
        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 4 15">
            <path d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"/>
        </svg>
    </button>

    <!-- Dropdown menu -->
    <div x-show="open"
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute bottom-full right-0 mb-2 z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-28 dark:bg-gray-700 dark:divide-gray-600"
         style="display: none;"
    >
        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
            <li>
                <a href="#" @click="open = false" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
            </li>
        </ul>
        <div class="py-2">
            <button @click="isLoadingDelete = true; $wire.deleteMessage({{ $message->id }})" class="transition w-full block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                <div x-show="!isLoadingDelete" class="dark:text-red-400 text-red-600 flex items-center text-md">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                    </svg>
                    <div class="ml-1">Delete</div>
                </div>
                <div x-show="isLoadingDelete" class="dark:text-red-400 text-red-600 flex items-center text-md">
                    <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z"/>
                    </svg>
                    <div class="ml-1">Deleting...</div>
                </div>
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('messageDeleted', (messageId) => {
            const dropdown = document.querySelector(`#dropdown-${messageId}`);
            dropdown.__x.$data.isLoadingDelete = false;
            dropdown.__x.$data.open = false; // Close the dropdown after delete
        });
    });
</script>
