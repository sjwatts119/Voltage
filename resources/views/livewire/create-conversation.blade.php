<div class="container rounded-2xl overflow-auto max-w-6xl h-[40dvh] dark:bg-gray-800 bg-white">

    {{-- Search Bar --}}
    <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
        <input wire:model.live="search" type="text" class="w-full px-4 py-2 text-sm dark:bg-gray-800 dark:text-gray-200 rounded-lg" placeholder="Search for users...">
    </div>

    @foreach($results as $user)
        <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
            <div class="flex items-center space-x-4">

                @if($user->profile->profile_photo)
                    <img src="{{ asset('storage/' . $user->profile->profile_photo) }}" alt="User Image" class="w-12 h-12 rounded-full object-cover">
                @else
                    <div class="w-12 h-12 bg-purple-400 rounded-full flex items-center justify-center">
                        <div class="text-2xl font-sans text-gray-800">{{ $user->name[0] }}</div>
                    </div>
                @endif

                <div>
                    <div class="text-lg font-semibold dark:text-gray-200">{{ $user->name }}</div>
                    <div class="text-sm dark:text-gray-300">{{ $user->email }}</div>
                </div>
            </div>
            <button wire:click="createConversation({{ $user->id }})" class="flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg">
                Message
            </button>
        </div>
        @endforeach

</div>
