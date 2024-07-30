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
                <h2 class="text-gray-800 dark:text-gray-200 text-4xl font-bold mb-2">{{ $conversation->getFriendlyName($conversation->id, 60) }}</h2>
                <div class="flex -space-x-4 rtl:space-x-reverse">
                    @php
                        $displayUsers = $conversation->users->slice(0, 10);
                        $remainingUsers = $conversation->users->count() - 10;
                    @endphp

                    @foreach($displayUsers as $user)
                        @if($user->profile->profile_photo)
                            <img class="w-10 h-10 border-2 border-white rounded-full dark:border-gray-800" src="{{ asset('storage/' . $user->profile->profile_photo) }}" alt="">
                        @else
                            <div class="flex items-center justify-center w-10 h-10 text-md font-medium text-gray-800 bg-purple-400 border-2 border-white rounded-full dark:border-gray-800">
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
                <p class="text-gray-500 text-md font-sans">Conversation Created on {{ $conversation->created_at->format('F j, Y') }}</p>

                {{--page divider--}}
                <div class="border-t border-gray-100 dark:border-gray-700 my-4"></div>

                <p class="mt-2 text-gray-500 text-md mt-4">
                    @if($conversation->profile->description)
                        {{ $conversation->profile->description }}
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
