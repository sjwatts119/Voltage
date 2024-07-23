<div class="lg:max-h-[75vh] md:overflow-y-auto p-8 xl:p-16">
    {{-- within here, we will have two areas. One for modifiying the profile stuff, and a preview of the profile where we display the x-user-profile liveview view --}}
    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-10">Profile Settings</h1>
    <div class="flex flex-col xl:flex-row xl:space-x-8 space-y-6 xl:space-y-0">
        <div class="xl:w-1/2 flex flex-col items-center">

            {{--make three dummy text inputs for now--}}
            <div class="mx-auto space-y-6 w-full">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="max-w-xl mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <input type="text" name="name" id="name" wire:model.live="name" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    </div>
                    <div class="max-w-xl mb-4">
                        <label for="pronouns" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pronouns</label>
                        <input type="text" name="pronouns" id="pronouns" wire:model.live="pronouns" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    </div>
                    <div class="max-w-xl">
                        <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bio</label>
                        <textarea name="bio" id="bio" wire:model.live="bio" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                    </div>
                    {{--add save button--}}
                    <div class="mt-4">
                        <button wire:click="saveProfile()" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="xl:w-1/2">
            <div class="overflow-hidden rounded-lg shadow">
                <x-profile-preview :user="$user" :name="$name" :pronouns="$pronouns" :bio="$bio"/>
            </div>
        </div>
    </div>


</div>
