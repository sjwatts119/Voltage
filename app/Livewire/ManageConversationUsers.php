<?php

namespace App\Livewire;

use App\Events\AddedToConversation;
use App\Events\MessageSent;
use App\Events\RemovedFromConversation;
use App\Models\Conversation;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class ManageConversationUsers extends ModalComponent
{
    public $search = '';
    public Conversation $conversation;

    public function sendSystemNotification($message, $messageType) : void {
        // Create a new system message in the conversation
        $newSystemMessage = $this->conversation->messages()->create([
            'user_id' => null,
            'type' => 'system',
            'message' => $message,
        ]);

        // Mark the message as read for the current user
        $newSystemMessage->markAsRead();

        $this->dispatch('reload-messages');
        $this->dispatch('refresh-chat-info');

        MessageSent::dispatch($newSystemMessage->id, $this->conversation->id);
    }

    public function addToConversation($userId) : void {
        // Make a new record in the conversation_users table with the user_id and conversation_id
        $this->conversation->users()->attach($userId);

        // We need to mark all messages in the conversation as unread for the new user
        $this->conversation->messages->each(function ($message) use ($userId) {
            $message->reads()->create([
                'user_id' => $userId,
                'read_at' => null
            ]);
        });

        AddedToConversation::dispatch($this->conversation->id, $userId);

        // Send a system notification to the conversation
        $this->sendSystemNotification(User::find($userId)->name . ' has been added to the conversation.', "added");

        // Close the modal
        $this->dispatch('closeModal');
    }

    public function removeFromConversation($userId) : void {
        // Remove the user from the conversation
        $this->conversation->users()->detach($userId);

        // We need to remove the user's entries in the message_reads table
        // Where the conversation_id is the conversation we are removing the user from,
        // and the user_id is the user we are removing
        $this->conversation->messages->each(function ($message) use ($userId) {
            $message->reads()->where('user_id', $userId)->delete();
        });

        RemovedFromConversation::dispatch($this->conversation->id, $userId);

        // Send a system notification to the conversation
        $this->sendSystemNotification(User::find($userId)->name . ' has been removed from the conversation.', "removed");

        // Close the modal
        $this->dispatch('closeModal');
    }

    public function render()
    {
        $results = [];

        if(strlen($this->search) > 0) {
            $searchResults = User::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('username', 'like', '%' . $this->search . '%')
                ->limit(10)
                ->get();

            // Exclude the current user and the existing participants from the search results
            $searchResults = $searchResults->filter(function ($user) {
                return $user->id !== auth()->id() && !$this->conversation->users->contains($user->id);
            });

            // Get the existing participants in the conversation
            $existingParticipants = $this->conversation->users;

            // Exclude the current user from the existing participants
            $existingParticipants = $existingParticipants->filter(function ($user) {
                return $user->id !== auth()->id();
            });

            // Append the existing participants to the end of the search results
            $results = $searchResults->concat($existingParticipants);
        }
        else{
            // Show the existing participants in the conversation
            $results = $this->conversation->users;

            // Exclude the current user from the results
            $results = $results->filter(function ($user) {
                return $user->id !== auth()->id();
            });
        }

        return view('livewire.manage-conversation-users', [
            'results' => $results
        ]);
    }
}
