<?php

namespace App\Livewire;

use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class Settings extends ModalComponent
{
    public User $user;
    public $currentTab;

    public static function modalMaxWidth(): string
    {
        return '6xl';
    }

    public function changeTab($tab)
    {
        $this->currentTab = $tab;
    }

    public function mount()
    {
        $this->user = auth()->user();
        $this->currentTab = 'general';
    }

    public function render()
    {
        return view('livewire.settings');
    }
}
