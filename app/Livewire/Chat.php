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

    #[On('conversation.open')]
    public function loadConversation($id): void
    {
        // For security, we should check if the conversation belongs to the user
        if(!auth()->user()->conversations->contains($id)) {
            return;
        }

        // Is the conversation with $id in the conversations collection?
        if (!$this->conversations->contains($id)) {
            // If not, load the new conversation from the database
            $this->conversations->push(Conversation::with('messages')->findOrFail($id));
        }

        // Load the conversation
        $this->activeConversation = Conversation::with('messages')->findOrFail($id);
        // We should get all messages from the model, and make a new array with the messages to display, so we can append new messages to it
        $this->messages = new Collection($this->activeConversation->messages);
        $this->messageInput = '';

        // Are there any unread messages in the conversation?
        if($this->activeConversation->getUnreadCount() > 0) {

            $unreadMessages = $this->messages->filter(function($message) {
                return !$message->isRead();
            });

            if($unreadMessages) {
                // Mark the unread messages as read
                $unreadMessages->each(function($message) {
                    $message->markAsRead();
                });
            }
        }
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

        // Mark the message as read for the sender
        $newMessage->markAsRead();

        // Broadcast the message without including the message contents for security
        MessageSent::dispatch($newMessage->id, $newMessage->conversation_id);

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
    public function receivedMessage($message): void
    {
        // Check if the message belongs to the active conversation
        if (!$this->activeConversation || $message['conversation_id'] != $this->activeConversation->id) {
            return;
        }

        // Get the new message from the database
        $newMessage = Message::find($message['message_id']);

        // Did the user send this message? If so, we don't need to append it as it would be displayed already
        if ($newMessage->user_id == auth()->id()) {
            return;
        }

        // Append the new message to the messages collection
        $this->messages->push($newMessage);

        //The message belongs to the chat which is currently open, so mark it as read
        $newMessage->markAsRead();
    }

    #[On('echo:Voltage-Status,.CreatedConversation')]
    public function addedToConversation($conversation): void
    {
        $conversation = Conversation::find($conversation['conversationID']);

        // Check if the user has been added to the conversation
        if (auth()->user()->conversations->contains($conversation)) {
            // Refresh the conversations list
            $this->conversations = auth()->user()->conversations;
        }
    }

    #[On('echo:Voltage-Actions,.RemovedFromConversation')]
    public function removedFromConversation($payload): void
    {
        // Is it the user that has been removed from a conversation?
        if (auth()->user()->id == $payload['user_id']) {
            // Refresh the conversations list
            $this->conversations = auth()->user()->conversations;

            // If the user was removed from the active conversation, close the chat
            if ($this->activeConversation && $this->activeConversation->id == $payload['conversation_id']) {
                $this->closeChat();
            }
        }
    }

    #[On('refresh-chat')]
    public function refresh(): void
    {
        $this->dispatch('$refresh');
    }

    #[On('reload-messages')]
    public function reloadMessages(): void
    {
        //get the messages from the active conversation
        $this->activeConversation->load('messages');
        $this->messages = $this->activeConversation->messages;
    }

    public function render()
    {
        // Show most recently active conversations first
        $this->conversations = $this->conversations->sortByDesc(function($conversation) {
            return $conversation->messages->last()->created_at ?? $conversation->created_at;
        });

        return view('livewire.pages.chat');
    }
}
