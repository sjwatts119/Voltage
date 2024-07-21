<div class="flex flex-col flex-auto h-[calc((100vh-4rem)-1px)]">
    <div class="flex flex-col flex-auto flex-shrink-0 rounded-none bg-white dark:bg-gray-900 h-full p-4">
        <div class="flex flex-col h-full overflow-x-auto mb-4">
            <div class="flex flex-col h-full">
                <div class="grid grid-cols-12 gap-y-2">
                    <x-message-not-user />
                    <x-message-user />
                    <x-message-not-user />
                    <x-message-not-user />
                    <x-message-not-user />
                    <x-message-user />
                    <x-message-user />
                </div>
            </div>
        </div>
        <x-chat-area-inputs />
    </div>
</div>
