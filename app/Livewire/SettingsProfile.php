<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class SettingsProfile extends Component
{
    public User $user;
    public string $name;
    public string $pronouns;
    public string $bio;

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

        session()->flash('success', 'Profile updated successfully');
    }

    public function mount() : void
    {
        $this->user = auth()->user();
        $this->name = $this->user->name;
        $this->pronouns = $this->user->profile->pronouns;
        $this->bio = $this->user->profile->bio;
    }

    public function render()
    {
        return view('livewire.settings-profile');
    }
}
