<?php

namespace Tests\Feature\Settings\General;

use App\Livewire\Settings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class GeneralTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_toggle_dark_mode() : Void
    {
        // Dark mode is on by default.
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Livewire::test(Settings::class)
            ->set('user', $user);

        // We know that dark mode is on by default. Call the toggleDarkMode method with parameter false.
        $component->call('toggleDarkMode', false);

        // Assert that the user's settings have been updated.
        assert($user->settings->dark_mode === false);

        // Assert that the light-mode event has been dispatched.
        $component->assertDispatched('light-mode');

        // Call the toggleDarkMode method with parameter true.
        $component->call('toggleDarkMode', true);

        // Assert that the user's settings have been updated.
        assert($user->settings->dark_mode === true);

        // Assert that the dark-mode event has been dispatched.
        $component->assertDispatched('dark-mode');

    }
}
