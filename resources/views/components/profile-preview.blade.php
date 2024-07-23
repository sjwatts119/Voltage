<div class="container rounded-2xl max-w-2xl">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl">
        <div class="h-28 overflow-hidden">
            {{--this will be done with spatie so this isn't correct but it's just a placeholder for now--}}
            @if($user->profile->banner)
                <img class="w-full" src="" alt="" />
            @else
                <div class="bg-gradient-to-r from-purple-500 to-indigo-500 w-full h-full"></div>
            @endif
        </div>
        <div class="flex justify-center px-5 -mt-12">
            <div class="h-24 w-24 bg-white dark:bg-gray-800 p-2 rounded-full">
                <div class="h-20 w-20 flex items-center justify-center rounded-full {{ $user->image ? '' : 'bg-purple-400' }}">
                    @if($user->image)
                        <img src="{{ $user->image }}" alt="User Image" class="rounded-full">
                    @else
                        <div class="text-4xl">{{ $user->name[0] }}</div>
                    @endif
                </div>
            </div>

        </div>
        <div class="">
            <div class="text-left px-12 mb-20">
                <h2 class="text-gray-800 dark:text-gray-200 text-2xl font-bold">{{ $name }}</h2>
                <div class="flex items-start">
                    <a class="text-gray-400 text-sm hover:text-purple-500 mr-1">{{ $user->username }}</a>
                    @if($pronouns)
                        <span class="text-gray-400 text-sm">·</span>
                        <p class="text-gray-400 text-sm ml-1">{{ $pronouns }}</p>
                    @endif
                </div>

                {{--page divider--}}
                <div class="border-t border-gray-100 dark:border-gray-700 my-4"></div>

                <p class="mt-2 text-gray-500 text-sm mt-4">
                    @if($bio)
                        {{ $bio }}
                    @else
                        This user has not set a bio.
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>


