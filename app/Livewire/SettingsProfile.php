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

    public function saveProfile() : void
    {
        dd($this->user);
        /*
        $this->validate([
            'user.name' => 'required|string|max:255',
            'user.email' => 'required|email|max:255',
        ]);

        $this->user->save();

        session()->flash('success', 'Profile updated successfully');*/
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
