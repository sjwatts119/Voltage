@if($activeConversation)
    <div class="flex flex-col h-[calc((100dvh-4rem)-1px)] w-full">
        <div class="flex flex-col flex-auto flex-shrink-0 rounded-none bg-gray-100 dark:bg-gray-900 h-full w-full">
            <div class="flex flex-col h-full w-full">
                <x-chat-area-infobar :activeConversation="$activeConversation" />
                <div class="flex flex-col-reverse flex-auto h-0 overflow-x-auto w-full">
                    <div class="mb-5">
                        @php
                            // Get the current user
                            $currentUser = auth()->user();

                            // Get other participants of the conversation
                            $otherParticipants = App\Models\Conversation::getParticipants($activeConversation->id)->where('id', '!=', $currentUser->id);
                        @endphp

                        @foreach($messageGroups as $messageGroup)

                            @if($messageGroup[0]['type'] === 'system')
                                <x-message-system :messageGroup="$messageGroup"/>
                            @else
                                <x-message-group :messageGroup="$messageGroup" :currentUser="$currentUser" :otherParticipants="$otherParticipants" :currentlyEditingId="$currentlyEditingId"/>
                            @endif

                        @endforeach
                    </div>

                    {{-- If there are any more messages to load --}}
                    @if($loadedMessages < $activeConversation->messages->count())
                        <div class="flex justify-center text-xs dark:text-gray-400 text-gray-600 my-10">
                            <button wire:click="loadMoreMessages" class="text-xl font-sans text-center dark:text-gray-500 dark:hover:text-gray-200 transition">
                                Load more messages
                            </button>
                        </div>
                    @endif

                    @if($messageGroups->count() === 0)
                        <div class="mx-auto p-6">
                            <div class="text-xl font-sans text-center dark:text-gray-500">
                                No messages yet, start the conversation!
                            </div>
                        </div>
                    @else
                        {{-- conversation created date --}}
                        <div class="flex justify-center text-xs dark:text-gray-400 text-gray-600 my-10">
                            <div class="text-xl font-sans uit text-center dark:text-gray-500">
                                Conversation Created on {{ $activeConversation->created_at->format('F j, Y') }}
                            </div>
                        </div>
                    @endif
                </div>

                <x-chat-area-inputs :activeConversation="$activeConversation"/>
            </div>
        </div>
    </div>
@else
    <div class="flex flex-col h-[calc((100dvh-4rem)-1px)] w-full hidden sm:block">
        <div class="flex flex-col flex-auto flex-shrink-0 rounded-none bg-gray-100 dark:bg-gray-900 h-full w-full p-4">
            <div class="flex flex-col h-full overflow-x-auto mb-4 w-full">
                <div class="mx-auto my-auto p-6">
                    <div class="text-2xl font-bold text-center dark:text-gray-500">
                        Select a conversation to start messaging.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

