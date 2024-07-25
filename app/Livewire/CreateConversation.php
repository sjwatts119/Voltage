<?php

namespace App\Livewire;

use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class CreateConversation extends ModalComponent
{
    public $search = '';

    public function createConversation($userId) : void
    {
        // Check if a non-group conversation already exists between the two users
        $existingConversation = auth()->user()->conversations()
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->where('is_group', false)
            ->first();

        if($existingConversation) {
            // Fire an event to open the conversation.
            $this->dispatch('conversation.open', $existingConversation->id, false);

            $this->closeModal();
        }

        // Fire an event with target user id to create the conversation.
        $this->dispatch('conversation.create', $userId);
    }

    public function render()
    {
        $results = [];

        if(strlen($this->search) > 0) {
            $results = User::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('username', 'like', '%' . $this->search . '%')
                ->limit(10)
                ->get();
        }

        return view('livewire.create-conversation', [
            'results' => $results,
        ]);
    }
}
