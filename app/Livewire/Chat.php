<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;

class Chat extends Component
{
    public $messageInput = '';

    public $conversations;

    public $conversation;


    public function loadConversation($id) : void
    {
        //pretty insecure lol
        $this->conversation = Conversation::find($id);
    }

    public function mount() : void
    {
        $this->conversation = Conversation::first();
        //get all conversations the user is part of
        $this->conversations = auth()->user()->conversations;
    }

    public function sendMessage() : void
    {
        //add to messages table
        $this->conversation->messages()->create([
            'conversation_id' => $this->conversation->id,
            'user_id' => auth()->id(),
            'message' => $this->messageInput,
        ]);

        $this->messageInput = '';
    }

    public function render()
    {
        return view('livewire.pages.chat');
    }
}
