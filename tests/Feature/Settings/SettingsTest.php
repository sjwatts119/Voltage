<?php

namespace Tests\Feature\Settings;

use App\Livewire\Settings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_tab_can_be_rendered(): void
    {
        $user = User::factory()->create();

        // Set the authenticated user
        $this->actingAs($user);

        // Assert that the 'Profile' tab is set to 'profile'.
        Livewire::test(Settings::class)
            ->set('user', $user)
            ->call('changeTab', 'profile')
            ->assertSet('currentTab', 'profile');

        // Assert that the 'Profile' tab is displayed as a nested component.
        Livewire::test(Settings::class)
            ->set('user', $user)
            ->call('changeTab', 'profile')
            ->assertSee('Profile');
    }

    public function test_general_tab_can_be_rendered(): void
    {
        $user = User::factory()->create();

        // Set the authenticated user
        $this->actingAs($user);

        // Assert that the 'General' tab is set to 'general'.
        Livewire::test(Settings::class)
            ->set('user', $user)
            ->call('changeTab', 'general')
            ->assertSet('currentTab', 'general');

        // Assert that the 'General' tab is displayed as a nested component.
        Livewire::test(Settings::class)
            ->set('user', $user)
            ->call('changeTab', 'general')
            ->assertSee('General');
    }

    public function test_account_tab_can_be_rendered(): void
    {
        $user = User::factory()->create();

        // Set the authenticated user
        $this->actingAs($user);

        // Assert that the 'Account' tab is set to 'account'.
        Livewire::test(Settings::class)
            ->set('user', $user)
            ->call('changeTab', 'account')
            ->assertSet('currentTab', 'account');

        // Assert that the 'Account' tab is displayed as a nested component.
        Livewire::test(Settings::class)
            ->set('user', $user)
            ->call('changeTab', 'account')
            ->assertSee('Account');
    }

}
