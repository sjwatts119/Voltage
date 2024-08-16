<?php

namespace Tests\Feature\Settings\Profile;

use App\Livewire\SettingsProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileChangeTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_no_changes_detected_when_nothing_is_changed(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // Test Livewire component
        $component = Livewire::test(SettingsProfile::class)
            ->set('user', $user)
            ->call('setUserDefaults');

        // Call `hasChanges()` and capture its result
        $hasChanges = $component->instance()->hasChanges();

        // Assert that no changes are detected
        $this->assertFalse($hasChanges);
    }

    public function test_changes_detected_when_name_is_changed(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // Test Livewire component
        $component = Livewire::test(SettingsProfile::class)
            ->set('user', $user)
            ->set('name', 'New Name!');

        // Call hasChanges and capture its result
        $hasChanges = $component->instance()->hasChanges();

        // Assert that changes are detected
        $this->assertTrue($hasChanges);
    }

    public function test_changes_detected_when_pronouns_are_changed(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // Test Livewire component
        $component = Livewire::test(SettingsProfile::class)
            ->set('user', $user)
            ->set('pronouns', 'they/them');

        // Call hasChanges and capture its result
        $hasChanges = $component->instance()->hasChanges();

        // Assert that changes are detected
        $this->assertTrue($hasChanges);
    }

    public function test_changes_detected_when_bio_is_changed(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // Test Livewire component
        $component = Livewire::test(SettingsProfile::class)
            ->set('user', $user)
            ->set('bio', 'New bio!');

        // Call hasChanges and capture its result
        $hasChanges = $component->instance()->hasChanges();

        // Assert that changes are detected
        $this->assertTrue($hasChanges);
    }

    public function test_changes_detected_when_profile_picture_is_changed(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // Test Livewire component
        $component = Livewire::test(SettingsProfile::class)
            ->set('user', $user)
            ->set('profilePicture', UploadedFile::fake()->image('newprofilepicture.jpg')->size(800));

        // Call hasChanges and capture its result
        $hasChanges = $component->instance()->hasChanges();

        // Assert that changes are detected
        $this->assertTrue($hasChanges);
    }

    public function test_changes_detected_when_banner_picture_is_changed(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // Test Livewire component
        $component = Livewire::test(SettingsProfile::class)
            ->set('user', $user)
            ->set('bannerPicture', UploadedFile::fake()->image('newbannerpicture.jpg')->size(2000));

        // Call hasChanges and capture its result
        $hasChanges = $component->instance()->hasChanges();

        // Assert that changes are detected
        $this->assertTrue($hasChanges);
    }

    public function test_all_changes_detected_when_all_fields_are_changed(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // Test Livewire component
        $component = Livewire::test(SettingsProfile::class)
            ->set('user', $user)
            ->set('name', 'New Name!')
            ->set('pronouns', 'they/them')
            ->set('bio', 'New bio!')
            ->set('profilePicture', UploadedFile::fake()->image('newprofilepicture.jpg')->size(800))
            ->set('bannerPicture', UploadedFile::fake()->image('newbannerpicture.jpg')->size(2000));

        // Call hasChanges and capture its result
        $hasChanges = $component->instance()->hasChanges();

        // Assert that all changes are detected
        $this->assertTrue($hasChanges);
    }

    public function test_discard_changes_resets_to_default_values(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // Test Livewire component
        $component = Livewire::test(SettingsProfile::class)
            ->set('user', $user)
            ->set('name', 'New Name!')
            ->set('pronouns', 'they/them')
            ->set('bio', 'New bio!')
            ->set('profilePicture', UploadedFile::fake()->image('newprofilepicture.jpg')->size(800))
            ->set('bannerPicture', UploadedFile::fake()->image('newbannerpicture.jpg')->size(2000));

        // Call discardChanges
        $component->call('discardChanges');

        // Assert that all values are reset to default
        $this->assertEquals($user->name, $component->name);
        $this->assertEquals($user->profile->pronouns, $component->pronouns);
        $this->assertEquals($user->profile->bio, $component->bio);
        $this->assertNull($component->profilePicture);
        $this->assertNull($component->bannerPicture);
    }
}
