<?php

namespace App\Livewire;

use App\Models\Conversation;
use LivewireUI\Modal\ModalComponent;

class ChatInfo extends ModalComponent
{
    public Conversation $conversation;
    public function render()
    {
        return view('livewire.chat-info');
    }
}
