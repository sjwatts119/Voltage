@if($activeConversation)
    <div class="flex flex-col h-[calc((100dvh-4rem)-1px)] w-full">
        <div class="flex flex-col flex-auto flex-shrink-0 rounded-none bg-gray-100 dark:bg-gray-900 h-full w-full">
            <div class="flex flex-col h-full w-full">
                <x-chat-area-infobar :activeConversation="$activeConversation" />
                <div class="flex flex-col-reverse flex-auto h-0 overflow-x-auto w-full p-4">
                    <div class="grid grid-cols-12 gap-y-2 w-full">
                        @php
                            // Store the authenticated user's id, so we don't have to call auth() loads of times
                            $authId = auth()->id();

                            // Get the current user
                            $currentUser = App\Models\User::find($authId);

                            // Get other participants of the conversation
                            $otherParticipants = App\Models\Conversation::getParticipants($activeConversation->id)->where('id', '!=', $authId);
                        @endphp

                        @foreach($messages as $message)
                            @if($message['user_id'] === $authId)
                                <x-message-user :message="$message" :user="$currentUser"/>
                            @else
                                <x-message-not-user :message="$message" :participants="$otherParticipants"/>
                            @endif
                        @endforeach
                    </div>
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
