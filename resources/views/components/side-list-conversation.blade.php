<button {{ $attributes->merge(['class' => 'flex flex-row items-center hover:bg-gray-300 dark:hover:bg-gray-950 rounded-xl p-2']) }}>
    <div class="flex items-center justify-center h-8 w-8 bg-purple-200 rounded-full">
        s
    </div>
    <div class="ml-2 text-sm font-semibold dark:text-gray-300">
        {{--if there's a conversation name, show that, if not, show the name of the other user in the conversation--}}
        @if($conversation->name)
            {{ $conversation->name }}
        @else
            {{--loop through the users in the conversation and show the name of the user that is not the authenticated user--}}
            @foreach($conversation->users as $user)
                @if($user->id !== auth()->id())
                    {{ $user->name }}
                @endif
            @endforeach
        @endif
    </div>
</button>
