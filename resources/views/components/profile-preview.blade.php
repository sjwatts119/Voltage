<div class="container rounded-2xl max-w-2xl">
    <div class="bg-white dark:bg-gray-900 overflow-hidden shadow-xl">
        <div class="relative h-28 overflow-hidden flex items-center">
            <label class="absolute inset-0 cursor-pointer">
                <div
                    x-data="{ uploading: false, progress: 0 }"
                    x-on:livewire-upload-start="uploading = true"
                    x-on:livewire-upload-finish="uploading = false"
                    x-on:livewire-upload-cancel="uploading = false"
                    x-on:livewire-upload-error="uploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                    class="w-full h-full relative"
                >
                    <div x-show="uploading" class="w-full h-full rounded-full">
                        <div x-bind:style="{ width: progress + '%' }" class="bg-gradient-to-tr from-violet-500 to-orange-300 h-full transition-all duration-300"></div>
                    </div>
                    <input type="file" wire:poll wire:model="bannerPicture" accept="image/*" class="hidden">
                </div>
                <div class="absolute inset-0 bg-black opacity-0 hover:opacity-50 transition-opacity duration-200"></div>
            </label>
            @if($bannerPicture)
                <img class="w-full h-full object-cover" src="{{ $bannerPicture->temporaryUrl() }}" alt="Banner Image" />
            @elseif($user->profile->banner_photo)
                <img class="w-full h-full object-cover" src="{{ asset('storage/' . $user->profile->banner_photo) }}" alt="Banner Image" />
            @else
                <div class="bg-gradient-to-r from-purple-500 to-indigo-500 w-full h-full"></div>
            @endif
        </div>
        <div class="flex justify-center px-5 -mt-12">
            <div class="h-26 w-26 bg-white dark:bg-gray-900 p-1 rounded-full">
                <div class="h-24 w-24 bg-white dark:bg-gray-900 p-2 rounded-full">
                    <div class="h-20 w-20 flex items-center justify-center rounded-full {{ $user->profile->profile_photo ? '' : 'bg-purple-400' }} relative">
                        <label class="absolute inset-0 cursor-pointer">
                            <input type="file" wire:poll wire:model="profilePicture" accept="image/*" class="hidden">
                            <div class="absolute inset-0 bg-black opacity-0 hover:opacity-50 transition-opacity duration-200 rounded-full"></div>
                        </label>
                        {{-- This must take priority as the user has uploaded a new image so we show that --}}
                        @if($profilePicture)
                            <img src="{{ $profilePicture->temporaryUrl() }}" alt="User Image" class="rounded-full h-full w-full object-cover">
                        @elseif($user->profile->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile->profile_photo) }}" alt="User Image" class="rounded-full h-full w-full object-cover">
                        @else
                            <div class="text-4xl">{{ $name ? $name[0] : '' }}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="text-left px-12 mb-20">
                <h2 class="text-gray-800 dark:text-gray-200 text-2xl font-bold">{{ $name ? $name : '' }}</h2>
                <div class="flex items-start">
                    <a class="text-gray-400 text-sm hover:text-purple-500 mr-1">{{ $user->username }}</a>
                    @if($pronouns)
                        <span class="text-gray-400 text-sm">·</span>
                        <p class="text-gray-400 text-sm ml-1">{{ $pronouns }}</p>
                    @endif
                </div>

                {{-- Page divider --}}
                <div class="border-t border-gray-100 dark:border-gray-700 my-4"></div>

                <p class="mt-2 text-gray-500 text-sm mt-4 break-words">
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
