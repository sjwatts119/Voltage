<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\Conversation;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class ChatInfo extends ModalComponent
{
    public Conversation $conversation;
    public $editMode = false;
    public $newGroupName = '';

    public $messageCount;

    public function mount()
    {
        $this->newGroupName = $this->conversation->name;
    }

    #[On('refresh-chat-info')]
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

        $this->dispatch('refresh-chat-info');
        $this->dispatch('reload-messages');

        // Dispatch pusher event to update the other participants
        MessageSent::dispatch($newSystemMessage->id, $this->conversation->id);

        // Set the message as being read by the current user
        $newSystemMessage->markAsRead();
    }

    public function render()
    {
        // Message count only includes messages that are not system messages
        $this->messageCount = $this->conversation->messages()->where('type', '!=', 'system')->count();

        return view('livewire.chat-info', [
            'messageCount' => $this->messageCount,
        ]);
    }
}
