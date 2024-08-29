<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\MessageAttachment;
use LivewireUI\Modal\ModalComponent;

class ViewMedia extends ModalComponent
{
    public Message $message;
    public MessageAttachment $messageAttachment;
    public $currentImageIndex = 0;

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function nextImage()
    {
        $this->currentImageIndex++;
        if ($this->currentImageIndex >= $this->message->attachments->count()) {
            $this->currentImageIndex = 0;
        }
    }

    public function previousImage()
    {
        $this->currentImageIndex--;
        if ($this->currentImageIndex < 0) {
            $this->currentImageIndex = $this->message->attachments->count() - 1;
        }
    }

    public function render()
    {
        return view('livewire.view-media');
    }
}
