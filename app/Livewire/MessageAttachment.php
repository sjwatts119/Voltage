<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\Message;
use Livewire\Component;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class MessageAttachment extends ModalComponent
{
    use WithFileUploads;

    public $conversationId;
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
        // Validate the attachments array
        $this->validate([
            'attachments.*' => 'file|max:10240', // 10MB max
        ]);

        // Create the message
        $message = Message::create([
            'user_id' => auth()->id(),
            'message' => $this->messageInput,
            'type' => 'user',
            'conversation_id' => $this->conversationId,
        ]);

        // Loop through each attachment
        foreach ($this->attachments as $attachment) {
            // Store the attachment
            $attachment->store('attachments', 'public');

            // Create the message attachment
            $message->attachments()->create([
                'attachment_path' => $attachment->hashName(),
                'type' => $attachment->getMimeType(),
            ]);
        }

        // Mark the message as read for the sender
        $message->markAsRead();

        // Broadcast the message without including the message contents for security
        MessageSent::dispatch($message->id, $message->conversation_id);

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

