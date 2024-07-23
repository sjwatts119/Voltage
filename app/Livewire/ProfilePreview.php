<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class ProfilePreview extends Component
{
    public User $user;

    public function mount() : void
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.profile-preview');
    }
}
