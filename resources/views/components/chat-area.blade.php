@if($activeConversation)
    <div class="flex flex-col h-[calc((100dvh-4rem)-1px)] w-full">
        <div class="flex flex-col flex-auto flex-shrink-0 rounded-none bg-gray-100 dark:bg-gray-900 h-full w-full">
            <div class="flex flex-col h-full w-full">
                <x-chat-area-infobar :activeConversation="$activeConversation" />
                <div class="flex flex-col-reverse flex-auto h-0 overflow-x-auto w-full p-4">
                    <div class="grid grid-cols-12 w-full">
                        @php
                            // Get the current user
                            $currentUser = auth()->user();

                            // Get other participants of the conversation
                            $otherParticipants = App\Models\Conversation::getParticipants($activeConversation->id)->where('id', '!=', $currentUser->id);
                        @endphp

                        @foreach($messages as $message)
                            @if($message['type'] === 'system')
                                <x-message-system :message="$message"/>
                            @elseif($message['user_id'] === $currentUser->id)
                                <x-message-user :message="$message" :user="$currentUser"/>
                            @else
                                <x-message-not-user :message="$message" :participants="$otherParticipants"/>
                            @endif
                        @endforeach
                    </div>

                    @if($messages->count() === 0)
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

                <x-chat-area-inputs />
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
