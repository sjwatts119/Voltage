<div class="flex flex-col w-72 flex-shrink-0 p-6 pr-0 h-screen">
    <div class="bg-white dark:bg-slate-800 h-full p-6 rounded-xl">

        <x-side-list-logo />

        <div class="flex flex-col mt-8 flex-grow overflow-hidden h-[calc(100%-5rem)]">
            <div class="flex flex-row items-center justify-between text-md dark:text-gray-200 text-gray-800">
                <span class="">Active Conversations</span>
                <span class="flex items-center justify-center bg-gray-300 text-black text-sm h-4 rounded-full w-fit-content p-2 py-3">2</span>
            </div>
            <div class="flex flex-col space-y-1 mt-4 overflow-y-auto">
                @for($i = 0; $i < 20; $i++)
                    {{--if on first iteration, give class bg-gray-100 TEMPORARY FOR TESTING FIXME--}}
                    @if($i == 0)
                        <x-side-list-user class="bg-gray-100 dark:bg-gray-900" />
                    @else
                        <x-side-list-user />
                    @endif
                @endfor
            </div>
        </div>
    </div>
</div>
