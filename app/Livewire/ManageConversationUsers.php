<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class ManageConversationUsers extends ModalComponent
{
    public $search = '';
    public Conversation $conversation;

    public function addToConversation($userId) : void {
        // Make a new record in the conversation_users table with the user_id and conversation_id
        $this->conversation->users()->attach($userId);

        // For each message in the conversation, we need to make a new record in the message_reads table
        $this->conversation->messages->each(function($message) use ($userId) {
            $message->reads()->create([
                'user_id' => $userId,
                'read_at' => null,
            ]);
        });

        // Send a system message to the conversation to notify the participants of the new user
        $newSystemMessage = $this->conversation->messages()->create([
            'user_id' => null,
            'type' => 'system',
            'message' => User::find($userId)->name . ' has been added to the conversation',
        ]);

        // Mark the message as read for the current user
        $newSystemMessage->markAsRead();

        $this->dispatch('refresh-chat');
        $this->dispatch('reload-messages');

        // Clear the search field
        $this->search = '';

        // Dispatch pusher event to update the other participants
        MessageSent::dispatch($newSystemMessage->id, $this->conversation->id);

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
