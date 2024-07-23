<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class UserProfile extends Component
{
    public $user;
    public $showModal = false;

    protected $listeners = ['showUserProfile'];

    public function showUserProfile($userId)
    {
        $this->user = User::find($userId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
