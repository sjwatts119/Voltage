<?php

namespace App\Livewire;

use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class CreateConversation extends ModalComponent
{
    public $search = '';

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
