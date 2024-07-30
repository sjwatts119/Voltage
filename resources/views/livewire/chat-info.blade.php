<div class="container rounded-2xl max-w-2xl">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl">
        <div class="h-32 sm:h-52 overflow-hidden items-center mb-10">
            @if($conversation->profile->photo)
                <img class="w-full h-full object-cover" src="{{ asset('storage/' . $conversation->profile->photo) }}" alt="" />
            @else
                <div class="bg-gradient-to-r from-purple-500 to-indigo-500 w-full h-full"></div>
            @endif
        </div>
        <div class="">
            <div class="text-left px-12 mb-28">
                <h1 class="text-gray-800 dark:text-gray-200 text-4xl font-bold mb-2">
                    @if($conversation->is_group)
                        Group Chat
                    @else
                        Private Chat
                    @endif
                </h1>

                @if($conversation->is_group)
                    @if($editMode)
                        <div class="flex items-center">
                            <input type="text" wire:model="newGroupName" class="mb-2 border rounded px-2 py-1 w-full dark:bg-gray-800 dark:text-white" />
                            <button wire:click="saveGroupName" class="transition ml-2 mb-2 text-green-500 hover:text-green-700 focus:outline-none">Save</button>
                            <button wire:click="toggleEditMode" class="transition ml-2 mb-2 text-red-500 hover:text-red-700 focus:outline-none">Discard</button>
                        </div>
                    @else
                        <div class="flex items-center">
                            <h2 class="text-gray-800 dark:text-gray-200 text-2xl font-sans mb-2">{{ $conversation->getFriendlyName($conversation->id, 40) }}</h2>
                            <button wire:click="toggleEditMode" class="transition mb-2 ml-2 text-blue-500 hover:text-blue-700 focus:outline-none">Edit</button>
                        </div>
                    @endif
                @else
                    <h2 class="text-gray-800 dark:text-gray-200 text-2xl font-sans mb-2">{{ $conversation->getFriendlyName($conversation->id, 40) }}</h2>
                @endif

                <div class="flex -space-x-4 rtl:space-x-reverse mb-2">

                @php
                    $displayUsers = $conversation->users->slice(0, 10);
                    $remainingUsers = $conversation->users->count() - 10;
                @endphp

                @foreach($displayUsers as $user)
                        @if($user->profile->profile_photo)
                            <img class="w-10 h-10 border-2 border-white rounded-full dark:border-gray-800 object-cover" src="{{ asset('storage/' . $user->profile->profile_photo) }}" title="{{ $user->name }}" alt="{{ $user->name }}">
                        @else
                            <div class="flex items-center justify-center w-10 h-10 text-md font-medium text-gray-800 bg-purple-400 border-2 border-white rounded-full dark:border-gray-800" title="{{ $user->name }}">
                                {{ $user->name[0] }}
                            </div>
                        @endif
                    @endforeach

                    @if($remainingUsers > 0)
                        <a class="flex items-center justify-center w-10 h-10 text-xs font-medium text-white bg-gray-700 border-2 border-white rounded-full hover:bg-gray-600 dark:border-gray-800" href="#">
                            +{{ $remainingUsers }}
                        </a>
                    @endif
                </div>

                <div class="border-t border-gray-100 dark:border-gray-700 my-4"></div>

                <p class="text-gray-500 text-md font-sans">Conversation Created on {{ $conversation->created_at->format('F j, Y') }}</p>
                <p class="text-gray-500 text-md font-sans">Number of Messages: {{ $conversation->messages->count() }}</p>
            </div>
        </div>
    </div>
</div>
