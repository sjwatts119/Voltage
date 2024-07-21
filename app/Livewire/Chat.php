<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;
use Illuminate\Support\Collection;

class Chat extends Component
{
    public $messageInput = '';
    public $conversations;
    public $conversation;
    public $messages;

    protected $listeners = ['messageReceived' => 'handleMessageReceived'];

    public function mount(): void
    {
        //Assuming the user is authenticated INSECURE FIXME
        $this->conversations = auth()->user()->conversations;
        $this->loadConversation($this->conversations->first()->id);
    }

    public function loadConversation($id): void
    {
        //Securely load the conversation
        $this->conversation = Conversation::with('messages')->findOrFail($id);
        $this->messages = collect($this->conversation->messages)->sortBy('created_at');
    }

    public function sendMessage(): void
    {
        $newMessage = $this->conversation->messages()->create([
            'user_id' => auth()->id(),
            'message' => $this->messageInput,
        ]);

        $this->messages->push($newMessage);

        //Broadcast the message
        MessageSent::dispatch($newMessage);

        //Clear the input field
        $this->messageInput = '';
    }

    public function handleMessageReceived($message): void
    {
        $this->messages->push(new Message($message));
    }

    public function render()
    {
        return view('livewire.pages.chat');
    }
}
