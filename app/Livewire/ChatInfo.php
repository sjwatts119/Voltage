<?php

namespace App\Livewire;

use App\Models\Conversation;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class ChatInfo extends ModalComponent
{
    public Conversation $conversation;
    public $editMode = false;
    public $newGroupName = '';

    public function mount()
    {
        $this->newGroupName = $this->conversation->name;
    }

    #[On('refresh-chat')]
    public function refresh() : void
    {
        $this->dispatch('$refresh');
    }

    public function toggleEditMode()
    {
        $this->editMode = !$this->editMode;
        if (!$this->editMode) {
            $this->newGroupName = $this->conversation->name;
        }
    }

    public function saveGroupName()
    {
        $this->validate([
            'newGroupName' => 'required|string|max:100',
        ]);

        $this->conversation->name = $this->newGroupName;
        $this->conversation->save();

        $this->editMode = false;

        // Create a new message to notify the group of the name change
        $newSystemMessage = $this->conversation->messages()->create([
            'user_id' => null,
            'type' => 'system',
            'message' => 'Conversation name changed to ' . $this->newGroupName,
        ]);

        $this->dispatch('refresh-chat');
        $this->dispatch('reload-messages');

        // Set the message as being read by the current user
        $newSystemMessage->markAsRead();
    }

    public function render()
    {
        return view('livewire.chat-info');
    }
}
