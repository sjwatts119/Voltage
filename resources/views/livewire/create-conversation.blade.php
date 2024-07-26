<div class="container rounded-2xl overflow-auto max-w-6xl h-[70dvh] dark:bg-gray-800 bg-gray-100">

    {{-- Starting Screen --}}
    @switch($chatType)
        @case('start')
            <div class="flex flex-col md:flex-row items-center justify-center h-full space-y-4 md:space-y-0 md:space-x-4 p-6">
                <div wire:click="selectChatType('private')" class="text-gray-800 dark:text-gray-200 w-full md:min-h-52 md:w-1/2 p-6 rounded-lg cursor-pointer transition transform hover:scale-105 shadow-xl dark:bg-gray-900 bg-white">
                    <div class="flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                    <div class="flex items-center justify-center">
                        <h2 class="text-2xl font-bold text-center">Start Private Chat</h2>
                    </div>
                    <p class="mt-2 text-center">Connect one-on-one with another user for a private conversation.</p>
                </div>
                <div wire:click="selectChatType('group')" class="text-gray-800 dark:text-gray-200 w-full md:min-h-52 md:w-1/2 p-6 rounded-lg cursor-pointer transition transform hover:scale-105 shadow-xl dark:bg-gray-900 bg-white">
                    <div class="flex items-center justify-center mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                    </div>
                    <div class="flex items-center justify-center">
                        <h2 class="text-2xl font-bold text-center">Start Group Chat</h2>
                    </div>
                    <p class="mt-2 text-center">Create a group chat to talk with multiple people simultaneously.</p>
                </div>
            </div>
            @break
        @case('private')
            {{-- Search Bar --}}
            <div class="sticky top-0 z-10 flex items-center justify-between p-4 border-b dark:border-gray-700 dark:bg-gray-800 bg-white">
                <input wire:model.live="search" type="text" class="w-full px-4 py-2 text-sm dark:bg-gray-800 dark:text-gray-200 rounded-lg" placeholder="Search for users...">
            </div>

            {{-- User List --}}
            @foreach($results as $user)
                <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
                    <div class="flex items-center space-x-4">
                        @if($user->profile->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile->profile_photo) }}" alt="User Image" class="w-12 h-12 rounded-full object-cover">
                        @else
                            <div class="w-12 h-12 bg-purple-400 rounded-full flex items-center justify-center">
                                <div class="text-xl font-sans text-gray-800">{{ $user->name[0] }}</div>
                            </div>
                        @endif
                        <div>
                            <div class="text-lg text-gray-800 dark:text-gray-200">{{ $user->name }}</div>
                            <div class="text-sm font-sans text-gray-600 dark:text-gray-500">{{ $user->username }}</div>
                        </div>
                    </div>
                    <button wire:click="createConversation({{ $user->id }})" class="flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-lg text-white border dark:border-gray-700 px-4 py-1.5 flex-shrink-0 transition">
                        Message
                    </button>
                </div>
            @endforeach
            @break
        @case('group')
            <div class="sticky top-0 z-10 flex items-center justify-between p-4 border-b dark:border-gray-700 dark:bg-gray-800 bg-white">
                <input wire:model.live="search" type="text" class="w-4/5 px-4 py-2 text-sm dark:bg-gray-800 dark:text-gray-200 rounded-lg" placeholder="Search for users...">
                <button wire:click="createGroupConversation()" class="w-1/5 ml-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Create ({{ count($selectedUsers) }} Users)
                </button>
            </div>

            <div class="flex h-[calc(100%-71.4px)]">
                {{-- User List --}}
                <div class="w-full">
                    @foreach($results as $user)
                        <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
                            <div class="flex items-center space-x-4">
                                @if($user->profile->profile_photo)
                                    <img src="{{ asset('storage/' . $user->profile->profile_photo) }}" alt="User Image" class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <div class="w-12 h-12 bg-purple-400 rounded-full flex items-center justify-center">
                                        <div class="text-xl font-sans text-gray-800">{{ $user->name[0] }}</div>
                                    </div>
                                @endif
                                <div>
                                    <div class="text-lg text-gray-800 dark:text-gray-200">{{ $user->name }}</div>
                                    <div class="text-sm font-sans text-gray-600 dark:text-gray-500">{{ $user->username }}</div>
                                </div>
                            </div>
                            {{-- if the user model is in the selectedUsers array, show the remove button, else show the add button --}}
                            @if(in_array($user->id, $selectedUserIds))
                                <button wire:click="removeUser({{ $user->id }})" class="flex items-center justify-center bg-red-500 hover:bg-red-600 rounded-lg text-white border dark:border-gray-700 px-4 py-1.5 flex-shrink-0 transition">
                                    -
                                </button>
                            @else
                                <button wire:click="addUser({{ $user->id }})" class="flex items-center justify-center bg-green-500 hover:bg-green-600 rounded-lg text-white border dark:border-gray-700 px-4 py-1.5 flex-shrink-0 transition">
                                    +
                                </button>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
            @break
    @endswitch
</div>
