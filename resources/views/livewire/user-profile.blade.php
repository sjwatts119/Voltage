<div x-data="{ showModal: @entangle('showModal') }">
    <!-- Modal Background -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" x-show="showModal">
        <!-- Modal Content -->
        <div class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full mx-auto mt-20"
             @click.away="showModal = false">
            <div class="px-4 py-5 sm:p-6">
                @if($user)
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</h2>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Username: {{ $user->username }}</h2>
                    <p class="text-gray-900 dark:text-gray-100">Email: {{ $user->email }}</p>
                    <p class="text-gray-900 dark:text-gray-100">Joined: {{ $user->created_at->format('M d, Y') }}</p>
                @endif
                <button wire:click="closeModal" class="mt-5 bg-red-500 text-white px-4 py-2 rounded">Close</button>
            </div>
        </div>
    </div>
</div>
