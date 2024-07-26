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
        // Show most recently active conversations first
        $this->conversations = $this->conversations->sortByDesc(function($conversation) {
            return $conversation->messages->last()->created_at ?? $conversation->created_at;
        });

        return view('livewire.pages.chat');
    }
}
