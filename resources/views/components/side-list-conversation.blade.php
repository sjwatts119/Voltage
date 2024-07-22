@php
    // Determine if the current conversation is the active conversation and set the button class accordingly
    $isActiveConversation = $activeConversation && $currentConversation->id === $activeConversation->id;
    $buttonClass = $isActiveConversation
        ? 'flex flex-row items-center hover:bg-gray-300 dark:hover:bg-gray-950 rounded-xl p-2 bg-gray-200 dark:bg-gray-900'
        : 'flex flex-row items-center hover:bg-gray-300 dark:hover:bg-gray-950 rounded-xl p-2';
@endphp

<x-conversation-button :conversationId="$currentConversation->id" :buttonClass="$buttonClass">
    <div class="flex items-center justify-center h-8 w-8 bg-purple-200 rounded-full">
        s
    </div>
    <div class="ml-2 text-sm font-semibold dark:text-gray-300">
        @if($currentConversation->name)
            {{ $currentConversation->name }}
        @else
            @foreach($currentConversation->users as $user)
                @if($user->id !== auth()->id())
                    {{ $user->name }}
                @endif
            @endforeach
        @endif
    </div>
</x-conversation-button>
