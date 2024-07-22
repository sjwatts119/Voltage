<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;

class Chat extends Component
{
    public $messageInput = '';
    public $conversations;
    public $conversation;
    public $messages;

    protected $listeners = ['messageReceived' => 'handleMessageReceived'];

    public function mount(): void
    {
        // Assuming the user is authenticated INSECURE FIXME
        $this->conversations = auth()->user()->conversations;
        //$this->loadConversation($this->conversations->first()->id);
    }

    public function loadConversation($id): void
    {
        // Securely load the conversation
        $this->conversation = Conversation::with('messages')->findOrFail($id);
        // We should get all messages from the model, and make a new array with the messages to display, so we can append new messages to it
        $this->messages = new Collection($this->conversation->messages);
        $this->messageInput = '';
    }

    public function sendMessage(): void
    {
        $newMessage = $this->conversation->messages()->create([
            'user_id' => auth()->id(),
            'message' => $this->messageInput,
        ]);

        $this->messages->push($newMessage);

        // Broadcast the message
        MessageSent::dispatch($newMessage);

        // Clear the input field
        $this->messageInput = '';
    }

    public function closeChat(): void
    {
        $this->conversation = null;
        $this->messages = null;
        $this->messageInput = '';
    }

    #[NoReturn] #[On('echo:Voltage-Conversation,.NewMessage')]
    public function receivedMessage($message): void {

        // Is the message for this conversation? if not return
        if ($message['message']['conversation_id'] != $this->conversation->id) {
            return;
        }

        // Did the user send this message? We don't want to display it twice
        if ($message['message']['user_id'] == auth()->id()) {
            return;
        }

        // Access the nested message array
        $messageData = $message['message'];

        // Ensure the message array contains the required keys
        if (isset($messageData['user_id']) && isset($messageData['message'])) {
            // Check if the message already exists in the collection to avoid duplicates
            $existingMessage = $this->messages->firstWhere('id', $messageData['id']);
            if (!$existingMessage) {
                // Create an array to represent the message
                $newMessage = [
                    'user_id' => $messageData['user_id'],
                    'message' => $messageData['message'],
                    'conversation_id' => $messageData['conversation_id'],
                    'created_at' => $messageData['created_at'],
                    'updated_at' => $messageData['updated_at'],
                    'id' => $messageData['id'],
                ];

                // Append the new message to the $messages collection
                $this->messages->push($newMessage);
            }
        }
    }

    public function render()
    {
        return view('livewire.pages.chat');
    }
}
