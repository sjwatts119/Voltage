<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class ChatArea extends Component
{

    public $messages = [];

    public $messageInput = '';

    public function mount()
    {
        $this->messages = [
            [
                'message' => 'This is a message from the logged in user',
                'time' => time(),
                'user' => auth()->user()->name,
            ],
            [
                'message' => 'This is a message from another user',
                'time' => time(),
                'user' => 'other',
            ],
            [
                'message' => 'This is a message from the logged in user 222222222222',
                'time' => time(),
                'user' => auth()->user()->name,
            ],
            [
                'message' => 'This is a message from another user 22222',
                'time' => time(),
                'user' => 'other',
            ],
        ];
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
