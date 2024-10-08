<?php

namespace App\Livewire;

use App\Models\Conversation;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use App\Traits\SendsMessage;

class MessageAttachment extends ModalComponent
{
    use WithFileUploads;
    use SendsMessage;

    public Conversation $activeConversation;
    public $attachments = [];
    public $newAttachments = [];
    public $messageInput;

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

    public function sendMessage() : void
    {
        try {
            // Validate the attachments array
            $this->validate([
                'attachments.*' => 'required|file|max:10240', // 10MB max
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Stop the send button spinner
            $this->dispatch('attachment-message-loading-finished');

            return;
        }

        // Send message with SendsMessage Trait
        $this->createMessage($this->activeConversation, $this->messageInput, $this->attachments);

        $this->dispatch('attachment-message-loading-finished');

        // Dispatch the message sent event
        $this->dispatch('reload-messages');

        // Close the modal
        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.message-attachment');
    }
}

