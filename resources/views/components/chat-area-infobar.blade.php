<div class="h-16 bg-white dark:bg-gray-800 w-full border-b dark:border-none dark:shadow-xl">
    <div class="flex items-center justify-between h-full w-full pl-8 ">
        <div class="flex items-center space-x-3">
            {{--add back arrow icon button to close chat here--}}
            <button wire:click="closeChat()" class="dark:text-gray-200 text-gray-800 sm:hidden block items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
            </button>
            <x-conversation-icon :currentConversation="$activeConversation" />
            <div class="text-lg font-semibold dark:text-gray-300 hidden lg:block">
                {{ $activeConversation->getFriendlyName($activeConversation->id, 60)}}
            </div>
            <div class="text-lg font-semibold dark:text-gray-300 lg:hidden">
                {{ $activeConversation->getFriendlyName($activeConversation->id, 20)}}
            </div>
        </div>
    </div>
</div>
