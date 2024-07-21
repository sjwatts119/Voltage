<?php

namespace App\Livewire;

use Livewire\Component;

class SideListConversation extends Component
{
    public $conversation;
    public $activeConversationID = null;

    public function loadConversation($id) : void
    {
        //we need to fire an event to the chat livewire component to load the conversation
        $this->dispatch('loadConversation', $id);

        //we should change the active conversation id so an active state is added to the conversation in the list

    }

    public function setActiveConversation($id) : void
    {
        //we should change the active conversation id so an active state is added to the conversation in the list
    }

    public function mount($conversation)
    {
        $this->conversation = $conversation;
    }

    public function render()
    {
        return view('livewire.side-list-conversation');
    }
}
