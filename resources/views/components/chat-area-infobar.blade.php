<div class="h-16 bg-gray-200 dark:bg-gray-800 w-full shadow-xl">
    @if($activeConversation->name)
        <div class="flex items-center justify-between h-full w-full pl-8">
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center h-8 w-8 bg-purple-200 rounded-full">
                    g
                </div>
                <div class="text-lg font-semibold dark:text-gray-300">
                    {{ $activeConversation->name }}
                </div>
            </div>
        </div>
    @else
        <div class="flex items-center justify-between h-full w-full pl-8">
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center h-8 w-8 bg-purple-200 rounded-full">
                    s
                </div>
                @foreach($activeConversation->users as $user)
                    @if($user->id !== auth()->id())
                        <div class="text-lg font-semibold dark:text-gray-300">
                            {{ $user->name }}
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
</div>
