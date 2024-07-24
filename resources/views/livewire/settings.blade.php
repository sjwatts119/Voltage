<div class="container rounded-2xl overflow-auto max-w-6xl h-[75dvh]">
    <div class="flex flex-col lg:flex-row">
        {{-- Sidebar --}}
        <div class="min-w-52 xl:min-w-72 bg-white dark:bg-gray-800">
            <div class="flex flex-col items-center justify-center hidden lg:block h-[75dvh] p-8 py-16 overflow-hidden">
                <div class="text-center">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full mx-auto dark:text-gray-500 text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-10 h-10 transition" fill="currentColor" stroke="currentColor"><path d="M24 13.616v-3.232c-1.651-.587-2.694-.752-3.219-2.019v-.001c-.527-1.271.1-2.134.847-3.707l-2.285-2.285c-1.561.742-2.433 1.375-3.707.847h-.001c-1.269-.526-1.435-1.576-2.019-3.219h-3.232c-.582 1.635-.749 2.692-2.019 3.219h-.001c-1.271.528-2.132-.098-3.707-.847l-2.285 2.285c.745 1.568 1.375 2.434.847 3.707-.527 1.271-1.584 1.438-3.219 2.02v3.232c1.632.58 2.692.749 3.219 2.019.53 1.282-.114 2.166-.847 3.707l2.285 2.286c1.562-.743 2.434-1.375 3.707-.847h.001c1.27.526 1.436 1.579 2.019 3.219h3.232c.582-1.636.75-2.69 2.027-3.222h.001c1.262-.524 2.12.101 3.698.851l2.285-2.286c-.744-1.563-1.375-2.433-.848-3.706.527-1.271 1.588-1.44 3.221-2.021zm-12 2.384c-2.209 0-4-1.791-4-4s1.791-4 4-4 4 1.791 4 4-1.791 4-4 4z"/></svg>
                    </div>
                    <h2 class="text-2xl font-semibold dark:text-gray-200 text-gray-800 mt-4">Settings</h2>
                </div>
                <div class="flex flex-col mt-8 w-full">
                    <div class="flex flex-col space-y-1 mt-4 overflow-y-auto">
                        <button wire:click="changeTab('general')" class="flex flex-row items-center hover:bg-gray-300 dark:hover:bg-gray-950 rounded-xl p-2 {{ $currentTab == 'general' ? 'bg-gray-200 dark:bg-gray-900' : '' }} transition">
                            <div class="ml-2 text-md font-semibold dark:text-gray-300">
                                General
                            </div>
                        </button>
                        <button wire:click="changeTab('profile')" class="flex flex-row items-center hover:bg-gray-300 dark:hover:bg-gray-950 rounded-xl p-2 {{ $currentTab == 'profile' ? 'bg-gray-200 dark:bg-gray-900' : '' }} transition">
                            <div class="ml-2 text-md font-semibold dark:text-gray-300">
                                Profile
                            </div>
                        </button>
                        <button wire:click="changeTab('account')" class="flex flex-row items-center hover:bg-gray-300 dark:hover:bg-gray-950 rounded-xl p-2 {{ $currentTab == 'account' ? 'bg-gray-200 dark:bg-gray-900' : '' }} transition">
                            <div class="ml-2 text-md font-semibold dark:text-gray-300">
                                Account
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            {{--make a slim nav which is just one row of nav texts for mobile--}}
            <div class="flex flex-row lg:hidden justify-between fixed top-0 left-0 right-0 bg-white dark:bg-gray-800 z-50">
                <div class="flex flex-row space-x-1">
                    <button wire:click="changeTab('general')" class="flex flex-row items-center hover:bg-gray-300 dark:hover:bg-gray-950 rounded-xl rounded-b-none p-2 {{ $currentTab == 'general' ? 'bg-gray-100 dark:bg-gray-900 ' : '' }} transition">
                        <div class="mx-2 text-md font-semibold dark:text-gray-300">
                            General
                        </div>
                    </button>
                    <button wire:click="changeTab('profile')" class="flex flex-row items-center hover:bg-gray-300 dark:hover:bg-gray-950 rounded-xl rounded-b-none p-2 {{ $currentTab == 'profile' ? 'bg-gray-100 dark:bg-gray-900' : '' }} transition">
                        <div class="mx-2 text-md font-semibold dark:text-gray-300">
                            Profile
                        </div>
                    </button>
                    <button wire:click="changeTab('account')" class="flex flex-row items-center hover:bg-gray-300 dark:hover:bg-gray-950 rounded-xl rounded-b-none p-2 {{ $currentTab == 'account' ? 'bg-gray-100 dark:bg-gray-900' : '' }} transition">
                        <div class="mx-2 text-md font-semibold dark:text-gray-300">
                            Account
                        </div>
                    </button>
                </div>
                <button wire:click="$dispatch('closeModal')" class="flex flex-row items-center rounded-xl rounded-b-none px-5 pb-3.5 pt-1.5 transition">
                    <div class="mx-2 text-3xl font-sans dark:text-gray-300">
                        x
                    </div>
                </button>
            </div>
        </div>
        {{-- Main Content --}}
        <div class="flex-grow bg-gray-100 dark:bg-gray-900 overflow-auto">
            @switch($currentTab)
                @case('general')
                    <div class="min-h-[75dvh] ">
                        <x-settings-general :user="$user"/>
                    </div>
                    @break
                @case('profile')
                    <div class="min-h-[75dvh] ">
                        <livewire:settings-profile :user="$user"/>
                    </div>
                    @break
                @case('account')
                    <div class="min-h-[75dvh] ">
                        <x-settings-account :user="$user"/>
                    </div>
                    @break
            @endswitch
        </div>
    </div>
</div>


