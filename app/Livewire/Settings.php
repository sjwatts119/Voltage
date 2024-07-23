<?php

namespace App\Livewire;

use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class Settings extends ModalComponent
{
    public User $user;

    public static function modalMaxWidth(): string
    {
        return '6xl';
    }

    public function mount()
    {
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.settings');
    }
}
