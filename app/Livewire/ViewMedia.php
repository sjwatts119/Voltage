<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\MessageAttachment;
use LivewireUI\Modal\ModalComponent;

class ViewMedia extends ModalComponent
{
    public Message $message;
    public MessageAttachment $messageAttachment;

    public static function modalMaxWidth(): string
    {
        return 'sm';
    }

    public function render()
    {
        return view('livewire.view-media');
    }
}
