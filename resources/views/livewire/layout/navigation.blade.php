<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo class="block h-8 w-auto text-gray-800 dark:text-gray-200 antialiased" />
                    </a>
                </div>
            </div>

            <!-- Log Out -->
            <div class="-me-2 flex items-center sm:items-center sm:ms-6">
                <button wire:click="logout" class="w-full text-start block w-full px-4 py-2 text-start text-sm leading-5 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-100 transition duration-150 ease-in-out">
                        {{ __('Log Out') }}
                </button>
            </div>
        </div>
    </div>
</nav>
