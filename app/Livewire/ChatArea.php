<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;

class ChatArea extends Component
{

    public $messages = [];

    public $messageInput = '';

    public $conversation;

    public function getListeners()
    {
        return ['loadConversation' => 'loadConversation'];
    }

    public function loadConversation($id) : void
    {
        $this->conversation = Conversation::find($id);
    }

    public function mount() : void
    {
        $this->conversation = Conversation::first();
    }

    public function sendMessage() : void
    {
        $this->messages[] = [
            'message' => $this->messageInput,
            'time' => time(),
            'user' => auth()->user()->name,
        ];

        $this->messageInput = '';
    }

    public function render()
    {
        return view('livewire.chat-area');
    }
}
