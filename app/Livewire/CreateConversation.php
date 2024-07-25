<?php

namespace App\Livewire;

use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class CreateConversation extends ModalComponent
{
    public $search = '';
    public $chatType;

    public function mount() : void
    {
        $this->chatType = 'start';
    }

    public function selectChatType($type)
    {
        $this->chatType = $type;
    }

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

            // Exclude the current user from the results
            $results = $results->filter(function ($user) {
                return $user->id !== auth()->id();
            });
        }

        return view('livewire.create-conversation', [
            'results' => $results,
        ]);
    }
}
