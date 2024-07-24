<div class="lg:max-h-[75dvh] p-4 md:p-16 md:pt-4 lg:pt-16 mt-12 lg:mt-0 md:overflow-y-auto">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mt-5 lg:mt-0 mb-5 lg:mb-10">General Settings</h1>

    <div class="w-full rounded-lg dark:bg-gray-800 p-8">
        <label class="inline-flex items-center cursor-pointer dark:bg-gray-800">
            <input type="checkbox" value="" class="sr-only peer" wire:change="toggleDarkMode($event.target.checked)" {{ $user->settings->dark_mode ? 'checked' : ''}}>
            <div class="relative w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Dark Mode</span>
        </label>
    </div>
</div>
