<?php

namespace Tests\Feature\Settings\Profile;

use App\Livewire\SettingsProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileImagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_file_size_validation_works_as_expected() : Void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // Deliberately break the validation rules by uploading a file that is too large.
        $component = Livewire::test(SettingsProfile::class)
            ->set('user', $user)
            ->set('profilePicture', UploadedFile::fake()->image('profile.jpg')->size(1025))
            ->set('bannerPicture', UploadedFile::fake()->image('banner.jpg')->size(3073));

        // Assert that the profile picture and banner picture are too large.
        $this->assertNull($component->profilePicture);
        $this->assertNull($component->bannerPicture);

        // Upload a file that is the correct size.
        $component = Livewire::test(SettingsProfile::class)
            ->set('user', $user)
            ->set('profilePicture', UploadedFile::fake()->image('profile.jpg')->size(1024))
            ->set('bannerPicture', UploadedFile::fake()->image('banner.jpg')->size(3072));

        // Assert that the profile picture and banner picture are not null.
        $this->assertNotNull($component->profilePicture);
        $this->assertNotNull($component->bannerPicture);
    }

    public function test_file_type_validation_works_as_expected() : Void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // Deliberately break the validation rules by uploading a file that is not an image.
        $component = Livewire::test(SettingsProfile::class)
            ->set('user', $user)
            ->set('profilePicture', UploadedFile::fake()->create('profile.txt', 1024, 'text/plain'))
            ->set('bannerPicture', UploadedFile::fake()->create('banner.txt', 3072, 'text/plain'));

        // Assert that the profile picture and banner picture are null.
        $this->assertNull($component->profilePicture);
        $this->assertNull($component->bannerPicture);

        // Upload a file that is the correct type.
        $component = Livewire::test(SettingsProfile::class)
            ->set('user', $user)
            ->set('profilePicture', UploadedFile::fake()->image('profile.jpg')->size(1024))
            ->set('bannerPicture', UploadedFile::fake()->image('banner.jpg')->size(3072));

        // Assert that the profile picture and banner picture are not null.
        $this->assertNotNull($component->profilePicture);
        $this->assertNotNull($component->bannerPicture);
    }

    public function test_user_can_upload_a_profile_picture(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // Change the variable inside the Livewire component for the profile picture.
        $component = Livewire::test(SettingsProfile::class)
            ->set('user', $user)
            ->set('profilePicture', UploadedFile::fake()->image('profile.jpg')->size(800));

        // Assert that profile picture is not null.
        $this->assertNotNull($component->profilePicture);

        // Call the saveProfile method to save the profile picture.
        $component->call('saveProfile');

        // Assert that the component has no errors and no redirects.
        $component
            ->assertHasNoErrors()
            ->assertNoRedirect();

        // Refresh the user instance.
        $user->refresh();

        // Assert that the profile picture was saved.
        $this->assertNotNull($user->profile->profile_photo);

        // Assert that the profile picture is stored in the storage folder.
        $this->assertFileExists(storage_path('app/public/' . $user->profile->profile_photo));
    }

    public function test_user_can_upload_a_banner_picture() : Void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        // Change the variable inside the Livewire component for the banner picture.
        $component = Livewire::test(SettingsProfile::class)
            ->set('user', $user)
            ->set('bannerPicture', UploadedFile::fake()->image('banner.jpg')->size(3000));

        // Assert that banner picture is not null.
        $this->assertNotNull($component->bannerPicture);

        // Call the saveProfile method to save the banner picture.
        $component->call('saveProfile');

        // Assert that the component has no errors and no redirects.
        $component
            ->assertHasNoErrors()
            ->assertNoRedirect();

        // Refresh the user instance.
        $user->refresh();

        // Assert that the banner picture was saved.
        $this->assertNotNull($user->profile->banner_photo);

        // Assert that the banner picture is stored in the storage folder.
        $this->assertFileExists(storage_path('app/public/' . $user->profile->banner_photo));
    }

}
