<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use Carbon\Carbon;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;

class Chat extends Component
{
    public $messageInput = '';
    public $conversations;
    public $activeConversation;
    public $messages;

    protected $listeners = ['messageReceived' => 'handleMessageReceived'];

    public function mount(): void
    {
        // Assuming the user is authenticated INSECURE FIXME
        $this->conversations = auth()->user()->conversations;
        //$this->loadConversation($this->conversations->first()->id);
    }

    #[On('conversation.create')]
    public function createConversation($userID, $group) : void
    {
        // We need to make a temporary conversation that will be displayed until the real conversation is created.
        // The real conversation is created when the first message is sent.
        // TODO

        if($group)
        {

        }
        else{
            $newConversation = Conversation::create(['is_group' => false]);
            $newConversation->users()->attach([auth()->id(), $userID]);

            // We need to regather the user's conversations to include the new conversation in the sidelist
            $this->conversations = auth()->user()->conversations;

            // Load the conversation
            $this->loadConversation($newConversation->id);

            // Close the modal
            $this->dispatch('closeModal');
        }
    }

    #[On('conversation.open')]
    public function loadConversation($id): void
    {
        // For security, we should check if the conversation belongs to the user
        if(!auth()->user()->conversations->contains($id)) {
            return;
        }

        // Load the conversation
        $this->activeConversation = Conversation::with('messages')->findOrFail($id);
        // We should get all messages from the model, and make a new array with the messages to display, so we can append new messages to it
        $this->messages = new Collection($this->activeConversation->messages);
        $this->messageInput = '';
    }

    public function sendMessage(): void
    {
        // Validate messageInput
        if(empty($this->messageInput)) {
            return;
        }

        $newMessage = $this->activeConversation->messages()->create([
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
        $this->activeConversation = null;
        $this->messages = null;
        $this->messageInput = '';
    }

    #[NoReturn] #[On('echo:Voltage-Conversation,.NewMessage')]
    public function receivedMessage($message): void {

        // Is the message for this conversation? if not return
        if (!$this->activeConversation || $message['message']['conversation_id'] != $this->activeConversation->id) {
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
                    'created_at' => Carbon::parse($messageData['created_at']),
                    'updated_at' => Carbon::parse($messageData['updated_at']),
                    'id' => $messageData['id'],
                ];

                // Append the new message to the $messages collection
                $this->messages->push($newMessage);
            }
        }
    }

    #[On('refresh-chat')]
    public function refresh(): void
    {
        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('livewire.pages.chat');
    }
}
