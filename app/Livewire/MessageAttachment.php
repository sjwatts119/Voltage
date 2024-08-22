<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class MessageAttachment extends ModalComponent
{
    use WithFileUploads;

    public $attachments = [];
    public $newAttachments = [];

    // This method is called when files are uploaded
    public function updatedNewAttachments() : void
    {
        // Loop through each new attachment
        foreach ($this->newAttachments as $newAttachment) {
            // Add the stored files to the attachments array
            $this->attachments[] = $newAttachment;
        }

        // Clear the new attachments after processing
        $this->reset('newAttachments');
    }

    public function removeAttachment($index) : void
    {
        // Remove the attachment from the attachments array
        unset($this->attachments[$index]);
    }

    public function render()
    {
        return view('livewire.message-attachment');
    }
}

