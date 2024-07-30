<?php

namespace App\Livewire;

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

        // Close the modal
        $this->dispatch('closeModal');
    }

    public function render()
    {
        $results = [];

        if(strlen($this->search) > 0) {
            $results = User::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('username', 'like', '%' . $this->search . '%')
                ->limit(10)
                ->get();

            // Exclude the current user and existing participants from the results
            $results = $results->filter(function ($user) {
                return $user->id !== auth()->id() && !$this->conversation->users->contains($user->id);
            });

        }

        return view('livewire.manage-conversation-users', [
            'results' => $results
        ]);
    }
}
