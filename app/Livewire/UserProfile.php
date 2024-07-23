<?php

namespace App\Livewire;

use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class UserProfile extends ModalComponent
{

    public User $user;
    public function render()
    {
        return view('livewire.user-profile');
    }
}
