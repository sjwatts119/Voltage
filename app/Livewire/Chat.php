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

    #[On('echo:Voltage-Conversation,.NewMessage')]
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
    public function createdConversation($conversation): void
    {
        $conversation = Conversation::find($conversation['conversationID']);

        // Check if the user has been added to the conversation
        if (auth()->user()->conversations->contains($conversation)) {
            // Refresh the conversations list
            $this->conversations = auth()->user()->conversations;
        }
    }

    public function addedToConversation($payload): void
    {
        // Is it the user that has been added to a conversation?
        if (auth()->user()->id == $payload['user_id']) {
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

    #[On('refresh-chat-info')]
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

    public function groupMessages($messages): Collection
    {
        // We should get all messages from the model, and make a new array with the messages to display, so we can append new messages to it
        $groupedMessages = new Collection();

        $previousMessage = null;
        $currentGroup = [];

        foreach ($messages as $message) {
            // If the current message is from the same user and sent within 5 minutes of the previous message, group them
            if ($previousMessage && $previousMessage->user_id == $message->user_id
                && $previousMessage->created_at->diffInMinutes($message->created_at) <= 5) {
                $currentGroup[] = $message;
            } else {
                // We have a new group of messages, so add the previous group to the messages array
                if (!empty($currentGroup)) {
                    $groupedMessages->push($currentGroup);
                }

                // Start a new group with the current message
                $currentGroup = [$message];
            }

            // Set the current message as the previous one for the next iteration
            $previousMessage = $message;
        }

        // Add the last group of messages to the array (if there are any messages in the group)
        if (!empty($currentGroup)) {
            $groupedMessages->push($currentGroup);
        }

        return $groupedMessages;
    }

    public function render()
    {
        // Show most recently active conversations first
        $this->conversations = $this->conversations->sortByDesc(function($conversation) {
            return $conversation->messages->last()->created_at ?? $conversation->created_at;
        });

        if($this->activeConversation) {
            // Group the messages
            $groupedMessages = $this->groupMessages($this->messages);
        } else {
            // If there is no active conversation, there are no messages to group
            $groupedMessages = null;
        }

        return view('livewire.pages.chat', [
            'groupedMessages' => $groupedMessages,
        ]);
    }
}
