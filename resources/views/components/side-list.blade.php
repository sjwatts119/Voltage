{{--if there is a conversation, hide the list--}}
<div class="flex flex-col w-72 flex-shrink-0 pr-0 h-[calc((100dvh-4rem)-1px)] {{ $activeConversation ? 'hidden sm:block' : 'w-full sm:w-72' }}">
    <div class="bg-white dark:bg-gray-800 h-full p-6 rounded-none sm:border-r border-gray-100 dark:border-gray-700">
        <button wire:click="closeChat()" class="flex flex-row items-center justify-center h-12 w-full sm:pr-5">
            <div class="flex items-center justify-center py-1 text-white">
                <x-application-logo class="block h-8 w-auto text-gray-800 dark:text-gray-200 antialiased" />
            </div>
            <div class="font-bold text-2xl dark:text-gray-100">Voltage</div>
        </button>
        <div class="flex flex-col mt-8 flex-grow overflow-hidden h-[calc(100%-11rem)] sm:h-[calc(100%-9.9rem)] mb-5">
            <div class="flex flex-row items-center justify-between text-md dark:text-gray-200 text-gray-800">
                <span class="">Your Conversations</span>
                <span class="flex items-center justify-center bg-gray-300 text-black text-sm h-4 rounded-full w-fit-content p-2 py-3">{{$conversations->count()}}</span>
            </div>
            <div class="flex flex-col space-y-1 mt-4 overflow-y-auto">
                <button wire:click="$dispatch('openModal', { component: 'CreateConversation' })" class="flex flex-row items-center hover:bg-gray-300 dark:hover:bg-gray-950 rounded-xl p-2 transition">
                    <div class="ml-2 text-md font-semibold dark:text-gray-300">
                        + New Conversation
                    </div>
                </button>
                @foreach($conversations as $currentConversation)
                    <x-side-list-conversation :activeConversation="$activeConversation" :currentConversation="$currentConversation" />
                @endforeach
            </div>
        </div>

        <div class="border-t border-gray-100 dark:border-gray-700"></div>

        <div class="flex flex-row items-center justify-between">
            <div class="focus:outline-none w-full mt-5">
                <div class="flex items-center">
                    <button wire:click="$dispatch('openModal', { component: 'user-profile', arguments: { user: {{ auth()->user() }} }})" class="focus:outline-none rounded-xl">
                        <x-user-icon :user="auth()->user()" />
                    </button>
                    <div class="ml-5 text-sm dark:text-gray-200 text-gray-800 text-left">
                        <div>{{auth()->user()->name}}</div>
                        <div class="text-xs dark:text-gray-400 text-gray-600">{{auth()->user()->username}}</div>
                    </div>
                    {{--add a button max to the right of this div to open settings--}}
                    <button wire:click="$dispatch('openModal', { component: 'settings' } )" class="focus:outline-none ml-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 text-gray-500 hover:text-gray-700 dark:text-gray-500 dark:hover:text-gray-300 transition" fill="currentColor" stroke="currentColor"><path d="M24 13.616v-3.232c-1.651-.587-2.694-.752-3.219-2.019v-.001c-.527-1.271.1-2.134.847-3.707l-2.285-2.285c-1.561.742-2.433 1.375-3.707.847h-.001c-1.269-.526-1.435-1.576-2.019-3.219h-3.232c-.582 1.635-.749 2.692-2.019 3.219h-.001c-1.271.528-2.132-.098-3.707-.847l-2.285 2.285c.745 1.568 1.375 2.434.847 3.707-.527 1.271-1.584 1.438-3.219 2.02v3.232c1.632.58 2.692.749 3.219 2.019.53 1.282-.114 2.166-.847 3.707l2.285 2.286c1.562-.743 2.434-1.375 3.707-.847h.001c1.27.526 1.436 1.579 2.019 3.219h3.232c.582-1.636.75-2.69 2.027-3.222h.001c1.262-.524 2.12.101 3.698.851l2.285-2.286c-.744-1.563-1.375-2.433-.848-3.706.527-1.271 1.588-1.44 3.221-2.021zm-12 2.384c-2.209 0-4-1.791-4-4s1.791-4 4-4 4 1.791 4 4-1.791 4-4 4z"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
