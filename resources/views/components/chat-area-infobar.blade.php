<div class="h-16 bg-white dark:bg-gray-800 w-full border-b dark:border-none dark:shadow-xl">
    <div class="flex items-center justify-between h-full w-full pl-8 ">
        <div class="flex items-center space-x-3">
            {{--add back arrow icon button to close chat here--}}
            <button wire:click="closeChat()" class="flex flex-row w-6 h-6 dark:text-gray-200 text-gray-800 sm:hidden block">
                <svg fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g data-name="Layer 2"> <g data-name="arrow-back"> <rect width="24" height="24" transform="rotate(90 12 12)" opacity="0"></rect> <path d="M19 11H7.14l3.63-4.36a1 1 0 1 0-1.54-1.28l-5 6a1.19 1.19 0 0 0-.09.15c0 .05 0 .08-.07.13A1 1 0 0 0 4 12a1 1 0 0 0 .07.36c0 .05 0 .08.07.13a1.19 1.19 0 0 0 .09.15l5 6A1 1 0 0 0 10 19a1 1 0 0 0 .64-.23 1 1 0 0 0 .13-1.41L7.14 13H19a1 1 0 0 0 0-2z"></path> </g> </g> </g></svg>
            </button>
            <x-conversation-icon :currentConversation="$activeConversation" />
            <div class="text-lg font-semibold dark:text-gray-300">
                @if($activeConversation->name)
                    {{ $activeConversation->name }}
                @else
                    @foreach($activeConversation->users as $user)
                        @if($user->id !== auth()->id())
                            {{ $user->name }}
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
