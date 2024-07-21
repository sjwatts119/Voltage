<div class="flex flex-col flex-auto h-[calc((100vh-4rem)-1px)]">
    <div class="flex flex-col flex-auto flex-shrink-0 rounded-none bg-gray-100 dark:bg-gray-900 h-full p-4">
        <div class="flex flex-col-reverse h-full overflow-x-auto mb-4">
            <div class="flex flex-col-reverse h-full">
                <div class="grid grid-cols-12 gap-y-2">
                    @foreach($messages as $message)
                        @if($message['user'] === auth()->user()->name)
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
