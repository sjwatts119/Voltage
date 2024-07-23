<div class="container rounded-2xl">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl">
        <div class="h-32 sm:h-52 overflow-hidden" >
            <img class="w-full" src="https://images.unsplash.com/photo-1605379399642-870262d3d051?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80" alt="" />
        </div>
        <div class="flex justify-center px-5 -mt-12">
            <x-profile-icon :user="$user" />
        </div>
        <div class="">
            <div class="text-left px-12 mb-28">
                <h2 class="text-gray-800 dark:text-gray-200 text-4xl font-bold">{{  $user->name }}</h2>
                <div class="flex items-start">
                    <a class="text-gray-400 text-lg mt-1 hover:text-purple-500 mr-1">{{ $user->username }}</a>
                    <span class="text-gray-400 text-lg">.</span>
                    <p class="text-gray-400 text-lg mt-1 ml-1">{{ $user->profile->pronouns }}</p>
                </div>
                <p class="mt-2 text-gray-500 text-md mt-4">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, </p>
            </div>
        </div>
    </div>
</div>


