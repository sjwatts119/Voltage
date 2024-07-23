<div class="container rounded-2xl">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl">
        <div class="h-32 sm:h-52 overflow-hidden">
            {{--this will be done with spatie so this isn't correct but it's just a placeholder for now--}}
            @if($user->profile->banner)
                <img class="w-full" src="" alt="" />
            @else
                <div class="bg-gradient-to-r from-purple-500 to-indigo-500 w-full h-full"></div>
            @endif
        </div>
        <div class="flex justify-center px-5 -mt-12">
            <x-profile-icon :user="$user" />
        </div>
        <div class="">
            <div class="text-left px-12 mb-28">
                <h2 class="text-gray-800 dark:text-gray-200 text-4xl font-bold">{{  $user->name }}</h2>
                <div class="flex items-start">
                    <a class="text-gray-400 text-lg mt-1 hover:text-purple-500 mr-1">{{ $user->username }}</a>
                    @if($user->profile->pronouns)
                        <span class="text-gray-400 text-lg">.</span>
                        <p class="text-gray-400 text-lg mt-1 ml-1">{{ $user->profile->pronouns }}</p>
                    @endif
                </div>

                {{--page divider--}}
                <div class="border-t border-gray-100 dark:border-gray-700 my-4"></div>

                <p class="mt-2 text-gray-500 text-md mt-4">
                    @if($user->profile->bio)
                        {{ $user->profile->bio }}
                    @else
                        This user has not set a bio.
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>


