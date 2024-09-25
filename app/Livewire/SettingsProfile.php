<?php

namespace App\Livewire;

use App\Models\User;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class SettingsProfile extends Component
{
    use WithFileUploads;

    public User $user;
    public string $name;
    public string $pronouns;
    public string $bio;
    #[Validate('nullable|image|max:1024')]
    public $profilePicture;
    #[Validate('nullable|image|max:3072')]
    public $bannerPicture;

    protected $rules = [
        'name' => 'required|string|max:255',
        'pronouns' => 'nullable|string|max:255',
        'bio' => 'nullable|string|max:255',
    ];

    public function createThumbnail($width) : string
    {
        // Create an instance of the image manager with the profile picture
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->profilePicture->getRealPath());

        $image->scale(width: $width);

        $image = $image->toWebp();

        // Storage path for the final file
        $finalPath = storage_path('app/public/profile-pictures/' . $this->user->id . '/thumb-' . $this->profilePicture->hashName());

        // Store the final file
        file_put_contents($finalPath, $image);

        // Return the path to the final file
        return 'profile-pictures/' . $this->user->id . '/thumb-' . $this->profilePicture->hashName();
    }

    public function updatedBannerPicture() : void
    {
        try{
            $this->validateOnly('bannerPicture');
        } catch (\Throwable $th) {
            $this->bannerPicture = null;

            //fire event
            $this->dispatch('upload-error', message: $th->getMessage());
        }
    }

    public function updatedProfilePicture() : void
    {
        try{
            $this->validateOnly('profilePicture');
        } catch (\Throwable $th) {
            $this->profilePicture = null;

            //fire event
            $this->dispatch('upload-error', message: $th->getMessage());
        }
    }

    public function hasChanges() : bool
    {
        return $this->user->name !== $this->name
            || ($this->user->profile->pronouns ?? '') !== ($this->pronouns ?? '')
            || ($this->user->profile->bio ?? '') !== ($this->bio ?? '')
            || $this->profilePicture
            || $this->bannerPicture;
    }

    public function setUserDefaults () : void {
        $this->name = $this->user->name;

        if(!$this->user->profile->pronouns) {
            $this->pronouns = '';
        }
        else{
            $this->pronouns = $this->user->profile->pronouns;
        }
        if(!$this->user->profile->bio) {
            $this->bio = '';
        }
        else{
            $this->bio = $this->user->profile->bio;
        }

        $this->profilePicture = null;
        $this->bannerPicture = null;
    }

    public function discardChanges() : void
    {
        $this->setUserDefaults();
    }

    public function saveProfile() : void
    {
        // This shouldn't be possible as the button is disabled, but just in case
        if(!$this->hasChanges()) {
            return;
        }

        $this->validate();

        $this->user->update([
            'name' => $this->name,
        ]);

        $this->user->profile->update([
            'pronouns' => $this->pronouns,
            'bio' => $this->bio,
        ]);

        //is there a new profile picture?
        if($this->profilePicture) {
            $this->user->profile->update([
                'profile_photo' => $this->profilePicture->store('profile-pictures/' . $this->user->id, 'public'),
            ]);

            if(!str_contains($this->profilePicture->getMimeType(), 'gif')) {
                // We should wrap this in a try-catch block to prevent the thumbnail creation from failing for file types not supported by the image manager
                try {
                    // Set the profile picture path
                    $this->user->profile->update([
                        'profile_thumb' => $this->createThumbnail(200),
                    ]);

                } catch (\Exception $e) {
                    // If the thumbnail creation fails, set the thumbnail path to null
                    $this->user->profile->update([
                        'profile_thumb' => null,
                    ]);
                }
            }
        }

        //is there a new banner picture?
        if($this->bannerPicture) {
            $this->user->profile->update([
                'banner_photo' => $this->bannerPicture->store('banner-pictures/' . $this->user->id, 'public'),
            ]);
        }

        //dispatch livewire event
        $this->dispatch('profile-updated');

        //dispatch refresh-chat
        $this->dispatch('refresh-chat-info');

        //dispatch profile-updated with name
        $this->dispatch('profile-updated', name: $this->user->name);

        //set $this->profilePicture to null
        $this->profilePicture = null;
        $this->bannerPicture = null;

    }

    public function mount() : void
    {
        $this->user = auth()->user();
        $this->setUserDefaults();
    }

    public function render()
    {
        return view('livewire.settings-profile');
    }
}
