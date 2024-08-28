<?php

namespace App\Livewire;

use App\Events\MessageDeleted;
use App\Events\MessageEdited;
use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use App\Traits\SendsMessage;

class Chat extends Component
{
    use SendsMessage;

    public $messageInput = '';
    public $conversations;
    public $activeConversation;
    public $currentlyEditingId = null;

    public $editedAttachments;

    protected $listeners = [
        'messageReceived' => 'handleMessageReceived',
    ];

    public function validateMessage($message): bool
    {
        $rules = [
            'message' => ['required', 'string', 'max:2000'],
        ];

        $validator = Validator::make(['message' => $message], $rules);

        return !$validator->fails();
    }

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
        $this->messageInput = '';

        // Are there any unread messages in the conversation?
        if($this->activeConversation->getUnreadCount() > 0) {

            $unreadMessages = $this->activeConversation->messages->filter(function($message) {
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
        // Validate the message
        if (!$this->validateMessage($this->messageInput)) {
            $this->dispatch('message-sent-loading-finished');
            return;
        }

        // Send message with SendsMessage trait
        $this->createMessage($this->activeConversation, $this->messageInput);

        $this->reloadMessages();

        // Clear the input field
        $this->messageInput = '';

        // Close the loading spinner on the send button
        $this->dispatch('message-sent-loading-finished');
    }

    public function closeChat(): void
    {
        $this->activeConversation = null;
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
        $this->reloadMessages();

        //The message belongs to the chat which is currently open, so mark it as read
        $this->activeConversation->messages->where('id', $message['message_id'])->first()->markAsRead();
    }

    public function deleteMessage($messageId) : void
    {
        // Check if the message exists and get it from the database
        if(!$message = Message::find($messageId)) {
            return;
        }

        // Check if the user is allowed to delete the message
        if($message->user_id != auth()->id()) {
            return;
        }

        // Delete the message
        $message->delete();

        // Refresh the messages
        $this->reloadMessages();

        // Dispatch a refresh event to update the chat
        $this->dispatch('messageDeleted', $messageId);

        // Broadcast the message deletion
        MessageDeleted::dispatch($messageId, $message->conversation_id);
    }

    #[On('echo:Voltage-Conversation,.MessageDeleted')]
    public function messageDeleted($payload): void
    {
        // Check if the message belongs to the active conversation
        if (!$this->activeConversation || $payload['conversation_id'] != $this->activeConversation->id) {
            return;
        }

        // Refresh the active conversation's messages
        $this->activeConversation->load('messages');
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

    #[On('leave-conversation')]
    public function leaveConversation($conversationId): void
    {
        // Create a new system message in the conversation
        $newSystemMessage = $this->activeConversation->messages()->create([
            'user_id' => null,
            'type' => 'system',
            'actioned_by_user_id' => auth()->id(),
            'action' => 'left',
            'message' => auth()->user()->name . ' has left the conversation.',
        ]);

        MessageSent::dispatch($newSystemMessage->id, $this->activeConversation->id);

        // Remove the current user from the conversation
        $this->activeConversation->users()->detach(auth()->id());

        // We need to remove the user's entries in the message_reads table
        // Where the conversation_id is the conversation we are removing the user from,
        // and the user_id is the user we are removing
        $this->activeConversation->messages->each(function ($message) {
            $message->reads()->where('user_id', auth()->id())->delete();
        });

        // Set the active conversation to null
        $this->closeChat();

        // Refresh the conversations list
        $this->conversations = auth()->user()->conversations;

        // Close the modal
        $this->dispatch('closeModal');
    }

    public function startEditingMessage($messageId): void
    {
        // Does this message exist?
        if(!$message = Message::find($messageId)) {
            return;
        }

        // Is the user allowed to edit this message?
        if($message->user_id != auth()->id()) {
            return;
        }

        // Set the currently editing message ID to the message ID
        $this->currentlyEditingId = $messageId;

        // Set editedAttachments to the message's attachments
        $this->editedAttachments = $message->attachments;
    }

    #[On('edit-last-message')]
    public function editLastMessage(): void
    {
        // Get the last message from the active conversation sent by the current user
        $lastMessage = $this->activeConversation->messages->where('user_id', auth()->id())->last();

        // If there is a last message, start editing it
        if($lastMessage) {
            $this->startEditingMessage($lastMessage->id);
        }
    }

    #[On('cancel-editing-message')]
    public function cancelEditingMessage(): void
    {
        // Clear the currently editing message ID
        $this->currentlyEditingId = null;

        // Clear edited attachments
        $this->editedAttachments = null;
    }

    public function updateMessage($currentlyEditingValue) : void
    {
        // Check if the message exists and if the user is allowed to edit it
        $message = Message::where('id', $this->currentlyEditingId)
            ->where('user_id', auth()->id())
            ->first();

        if (!$message || !$this->validateMessage($currentlyEditingValue)) {
            return;
        }

        // Update the message content and timestamp
        $message->update([
            'message' => $currentlyEditingValue,
            'edited_at' => now(),
        ]);

        // Get the IDs of the attachments that are still included after editing
        $editedAttachmentIds = $this->editedAttachments->pluck('id')->toArray();

        // Delete any attachments that are not in the editedAttachments array
        $message->attachments()->whereNotIn('id', $editedAttachmentIds)->delete();

        // Clear the currently editing values
        $this->currentlyEditingId = null;
        $this->editedAttachments = null;

        // Broadcast the message update
        MessageEdited::dispatch($message->id, $message->conversation_id);
    }


    public function removeAttachment($attachmentId) : void
    {
        // Get from MessageAttachments model where attachment id
        $attachment = \App\Models\MessageAttachment::find($attachmentId);

        // Is it the user that sent this message?
        if (!auth()->id() == $attachment->message->user_id) {
            return;
        }

        // Remove this attachment from editedAttachments
        $this->editedAttachments = $this->editedAttachments->filter(function($editedAttachment) use ($attachmentId) {
            return $editedAttachment->id !== $attachmentId;
        });
    }

    #[On('echo:Voltage-Conversation,.MessageEdited')]
    public function messageEdited($payload): void
    {
        // Check if the message belongs to any of the user's conversations
        if (!$this->conversations->contains($payload['conversation_id'])) {
            return;
        }

        // Refresh the active conversation's messages
        $this->activeConversation->load('messages');
    }

    #[On('refresh-chat-info')]
    public function refresh(): void
    {
        $this->dispatch('$refresh');
    }

    #[On('reload-messages')]
    public function reloadMessages(): void
    {
        $this->conversations = auth()->user()->conversations;
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
            $messageGroups = $this->groupMessages($this->activeConversation->messages);
        } else {
            // If there is no active conversation, there are no messages to group
            $messageGroups = null;
        }

        return view('livewire.pages.chat', [
            'messageGroups' => $messageGroups,
        ]);
    }
}
