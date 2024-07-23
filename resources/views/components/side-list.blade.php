{{--if there is a conversation, hide the list--}}
<div class="flex flex-col w-72 flex-shrink-0 pr-0 h-[calc((100vh-4rem)-1px)] {{ $activeConversation ? 'hidden sm:block' : 'w-full sm:w-72' }}">
    <div class="bg-white dark:bg-gray-800 h-full p-6 rounded-none sm:border-r border-gray-100 dark:border-gray-700">

        <x-side-list-logo />

        <div class="flex flex-col mt-8 flex-grow overflow-hidden h-[calc(100%-11rem)] sm:h-[calc(100%-9.9rem)] mb-5">
            <div class="flex flex-row items-center justify-between text-md dark:text-gray-200 text-gray-800">
                <span class="">Your Conversations</span>
                <span class="flex items-center justify-center bg-gray-300 text-black text-sm h-4 rounded-full w-fit-content p-2 py-3">{{$conversations->count()}}</span>
            </div>
            <div class="flex flex-col space-y-1 mt-4 overflow-y-auto">
                @foreach($conversations as $currentConversation)
                    <x-side-list-conversation :activeConversation="$activeConversation" :currentConversation="$currentConversation" />
                @endforeach
            </div>
        </div>
        {{--dividing line--}}
        <div class="border-t border-gray-100 dark:border-gray-700"></div>
        {{--user profile--}}
            <div class="flex flex-row items-center justify-between">
                <button wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ auth()->user() }} }})" class="focus:outline-none hover:bg-gray-300 dark:hover:bg-gray-950 rounded-xl p-2 w-full mt-3 transition">
                    <div class="flex items-center">
                        <x-user-icon :user="auth()->user()" />
                        <div class="ml-5 text-sm dark:text-gray-200 text-gray-800 text-left">
                            <div>{{auth()->user()->name}}</div>
                            <div class="text-xs dark:text-gray-400 text-gray-600">{{auth()->user()->username}}</div>
                        </div>
                    </div>
                </button>
            </div>

        </div>
</div>
