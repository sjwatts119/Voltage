@php
    // Determine if the current conversation is the active conversation and set the button class accordingly
    $isActiveConversation = $activeConversation && $currentConversation->id === $activeConversation->id;
    $buttonClass = $isActiveConversation
        ? 'flex flex-row items-center hover:bg-gray-300 dark:hover:bg-gray-950 rounded-xl p-2 bg-gray-200 dark:bg-gray-900 transition'
        : 'flex flex-row items-center hover:bg-gray-300 dark:hover:bg-gray-950 rounded-xl p-2 transition';
@endphp

<x-conversation-button :conversationId="$currentConversation->id" :buttonClass="$buttonClass">
    <x-conversation-icon :currentConversation="$currentConversation" />
    <div class="ml-2 text-md font-semibold dark:text-gray-300">
        @if($currentConversation)
            {{ $currentConversation->getFriendlyName($currentConversation->id, 17) }}
        @endif
    </div>
</x-conversation-button>
