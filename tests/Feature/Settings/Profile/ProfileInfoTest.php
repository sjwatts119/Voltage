<?php

namespace Tests\Feature\Settings\Profile;

use App\Livewire\SettingsProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileInfoTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_profile_name() : Void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Livewire::test(SettingsProfile::class)
            ->set('user', $user)
            ->set('name', 'John Doe')
            ->call('saveProfile');

        $this->assertEquals('John Doe', $user->fresh()->name);
    }

    public function test_user_can_update_profile_pronouns() : Void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Livewire::test(SettingsProfile::class)
            ->set('user', $user)
            ->set('pronouns', 'He/Him')
            ->call('saveProfile');

        $this->assertEquals('He/Him', $user->fresh()->profile->pronouns);
    }

    public function test_user_can_update_profile_bio() : Void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Livewire::test(SettingsProfile::class)
            ->set('user', $user)
            ->set('bio', 'Hello World')
            ->call('saveProfile');

        $this->assertEquals('Hello World', $user->fresh()->profile->bio);
    }
}