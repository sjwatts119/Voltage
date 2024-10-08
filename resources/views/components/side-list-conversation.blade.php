@php
    // Determine if the current conversation is the active conversation and set the button class accordingly
    $isActiveConversation = $activeConversation && $currentConversation->id === $activeConversation->id;
    $buttonClass = $isActiveConversation
        ? 'flex flex-row items-center hover:bg-gray-300 dark:hover:bg-gray-950 rounded-xl p-2 bg-gray-200 dark:bg-gray-900 transition'
        : 'flex flex-row items-center hover:bg-gray-300 dark:hover:bg-gray-950 rounded-xl p-2 transition';
@endphp

<x-conversation-button :conversationId="$currentConversation->id" :buttonClass="$buttonClass">
    <x-conversation-icon :currentConversation="$currentConversation" />
    <div class="flex flex-col text-left max-w-[70%]">
        @if($currentConversation)
            <div class="ml-2 text-md font-sans dark:text-gray-300 truncate">
                    {{ $currentConversation->getFriendlyName($currentConversation->id, 100) }}
            </div>
        @endif
        @if($currentConversation->messages->count())
            <div class="ml-2 text-sm font-sans dark:text-gray-400 truncate">
                    {{ $currentConversation->getFriendlyLastMessage(100) }}
            </div>
        @endif
    </div>
    @if($currentConversation->getFriendlyUnreadCount())
        <div class="ml-auto bg-red-500 text-white text-sans text-sm rounded-full w-6 h-6 min-w-6 flex items-center justify-center">
            {{ $currentConversation->getFriendlyUnreadCount() }}
        </div>
    @endif
</x-conversation-button>
