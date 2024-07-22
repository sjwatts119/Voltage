@if($conversation)
    <div class="flex flex-col flex-auto h-[calc((100vh-4rem)-1px)]">
        <div class="flex flex-col flex-auto flex-shrink-0 rounded-none bg-gray-100 dark:bg-gray-900 h-full p-4">
            <div class="flex flex-col-reverse h-full overflow-x-auto mb-4">

                <div class="flex flex-col-reverse h-full">
                    <div class="grid grid-cols-12 gap-y-2">
                        @php
                            //store the authenticated user's id, so we don't have to call auth() loads of times
                                $authId = auth()->id();
                        @endphp

                        @foreach($messages as $message)
                            @if($message['user_id'] === $authId)
                                <x-message-user :message="$message" />
                            @else
                                <x-message-not-user :message="$message" />
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <x-chat-area-inputs />
        </div>
    </div>
@else
    <div class="flex flex-col flex-auto h-[calc((100vh-4rem)-1px)]">
        <div class="flex flex-col flex-auto flex-shrink-0 rounded-none bg-gray-100 dark:bg-gray-900 h-full p-4">
            <div class="flex flex-col-reverse h-full overflow-x-auto mb-4">
                <div class="mx-auto my-auto p-6">
                    <div class="text-2xl font-bold text-center dark:text-gray-500">Select a conversation to start messaging.</div>
                </div>
            </div>
        </div>
    </div>
@endif


