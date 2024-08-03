<div class="lg:max-h-[75dvh] md:overflow-y-auto p-4 md:p-16 md:pt-4 lg:pt-16 mt-12 lg:mt-0">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mt-5 lg:mt-0 mb-5 lg:mb-10">Account Settings</h1>
    <div class="mx-auto space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="max-w-xl">
                <livewire:profile.update-profile-information-form />
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="max-w-xl">
                <livewire:profile.update-password-form />
            </div>
        </div>

        {{--
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="max-w-xl">
                <livewire:profile.delete-user-form />
            </div>
        </div>
        --}}
    </div>
</div>
