<div class="lg:max-h-[75dvh] md:overflow-y-auto p-8 xl:p-16">
    {{-- within here, we will have two areas. One for modifiying the profile stuff, and a preview of the profile where we display the x-user-profile liveview view --}}
    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-10">Profile Settings</h1>
    <div class="flex flex-col xl:flex-row xl:space-x-8 space-y-6 xl:space-y-0 p-8 bg-white dark:bg-gray-800 rounded-lg">
        <div class="xl:w-1/2 flex flex-col items-center">

            <div class="mx-auto space-y-6 w-full">
                <div class="p-4 rounded-lg border-none">
                    <div class="max-w-xl mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                        <input type="text" name="name" id="name" wire:model.live="name" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="max-w-xl mb-4">
                        <label for="pronouns" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pronouns</label>
                        <input type="text" name="pronouns" id="pronouns" wire:model.live="pronouns" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        @error('pronouns') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="max-w-xl mb-4">
                        <label for="bio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bio</label>
                        <textarea name="bio" id="bio" wire:model.live="bio" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                        @error('bio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex items-center gap-4 mt-4">
                        <x-action-message class="" on="profile-updated">
                            {{ __('Saved.') }}
                        </x-action-message>
                    </div>
                </div>
            </div>
        </div>

        <div class="xl:w-1/2">
            <div class="overflow-hidden rounded-lg shadow">
                <x-profile-preview :user="$user" :name="$name" :pronouns="$pronouns" :bio="$bio" :profilePicture="$profilePicture" :bannerPicture="$bannerPicture"/>
            </div>
        </div>
    </div>

    @if($this->hasChanges())
        <div wire:transition class="w-full mx-auto mt-4 bg-white dark:bg-gray-800 p-4 rounded-md flex justify-between items-center">
            <span class="dark:text-gray-100 text-gray-800">You have unsaved changes...</span>
            <div class="flex justify-end space-x-4">
                <x-danger-button wire:click="discardChanges()" class="">Discard</x-danger-button>
                <x-primary-button wire:click="saveProfile()" class="">Save</x-primary-button>
            </div>
        </div>
    @endif


</div>
