<?php

namespace App\Livewire;

use App\Models\Conversation;
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
        $this->dispatch('refresh-chat');

        // When System messages are implemented, send one to the conversation saying user has changed the group name
    }

    public function render()
    {
        return view('livewire.chat-info');
    }
}
