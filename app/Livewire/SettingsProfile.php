<?php

namespace App\Livewire;

use App\Models\User;
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

    protected $rules = [
        'name' => 'required|string|max:255',
        'pronouns' => 'nullable|string|max:255',
        'bio' => 'nullable|string|max:255',
    ];

    public function saveProfile() : void
    {
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
                'profile_photo' => $this->profilePicture->store('profile-pictures', 'public'),
            ]);
        }

        //dispatch livewire event
        $this->dispatch('profile-updated');

        //dispatch refresh-chat
        $this->dispatch('refresh-chat');

        //set $this->profilePicture to null
        $this->profilePicture = null;

    }

    public function mount() : void
    {
        $this->user = auth()->user();
        $this->name = $this->user->name;
        $this->pronouns = $this->user->profile->pronouns;
        $this->bio = $this->user->profile->bio;
        $this->profilePicture = null;
    }

    public function render()
    {
        return view('livewire.settings-profile');
    }
}
