<div class="h-16 bg-white dark:bg-gray-800 w-full border-b dark:border-none dark:shadow-xl">
    <div class="flex items-center justify-between h-full w-full pl-8 ">
        <div class="flex items-center space-x-3">
            {{--add back arrow icon button to close chat here--}}
            <button wire:click="closeChat()" class="flex flex-row w-5 h-5 dark:text-gray-200 text-gray-800 sm:hidden block items-center">
                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" image-rendering="optimizeQuality" fill-rule="evenodd" clip-rule="evenodd" viewBox="0 0 512 404.43"><path fill-rule="nonzero" d="m68.69 184.48 443.31.55v34.98l-438.96-.54 173.67 159.15-23.6 25.79L0 199.94 218.6.02l23.6 25.79z"/></svg>
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
