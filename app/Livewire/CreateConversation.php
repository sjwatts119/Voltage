<?php

namespace App\Livewire;

use LivewireUI\Modal\ModalComponent;

class CreateConversation extends ModalComponent
{
    public function render()
    {
        return view('livewire.create-conversation');
    }
}
