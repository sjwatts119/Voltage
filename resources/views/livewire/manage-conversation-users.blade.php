<div class="container rounded-2xl overflow-auto max-w-6xl max-h-[70dvh] dark:bg-gray-800 bg-gray-100">
    <div class="h-[70dvh]">
        <div class="sticky top-0 z-10 flex items-center justify-between p-4 border-b dark:border-gray-700 dark:bg-gray-800 bg-white">
            <input wire:model.live="search" type="text" class="w-full px-4 py-2 text-sm dark:bg-gray-800 dark:text-gray-200 rounded-lg" placeholder="Search for users...">
        </div>
        <div class="flex h-[calc(70dvh-71.4px)] overflow-y-auto">
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
                        @if(!$user->conversations->contains($conversation->id))
                            <button wire:click="addToConversation({{ $user->id }})" class="flex items-center justify-center bg-indigo-500 hover:bg-indigo-600 rounded-lg text-white border dark:border-gray-700 px-4 py-1.5 flex-shrink-0 transition">
                                Add
                            </button>
                        @else
                            <button wire:click="removeFromConversation({{ $user->id }})" class="flex items-center justify-center bg-red-500 hover:bg-red-600 rounded-lg text-white border dark:border-gray-700 px-4 py-1.5 flex-shrink-0 transition">
                                Remove
                            </button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
