<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\Message;
use Intervention\Image\Encoders\JpegEncoder;
use Intervention\Image\Encoders\PngEncoder;
use Livewire\Component;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
            'message' => "",
            'type' => 'user',
            'conversation_id' => $this->conversationId,
        ]);

        // Loop through each attachment
        foreach ($this->attachments as $attachment) {
            // Store the attachment under subdirectory of the message id
            $attachment->storeAs('public/attachments/' . $message->id, $attachment->hashName());

            // Create a thumbnail for images
            if (str_contains($attachment->getMimeType(), 'image')) {
                // Create an instance of the image manager
                $manager = new ImageManager(new Driver());

                // Read image from file system
                $image = $manager->read(storage_path('app/public/attachments/' . $message->id . '/' . $attachment->hashName()));

                // Resize the image to 300px height while maintaining the aspect ratio
                $image->scale(height: 300);

                // Encode to png format
                $encoded = $image->encode(new PngEncoder());

                // Save the thumbnail
                $encoded->save(storage_path('app/public/attachments/' . $message->id . '/thumbnail-' . $attachment->hashName()));
            }

            // Create the message attachment in the db
            $message->attachments()->create([
                'original_filename' => $attachment->getClientOriginalName(),
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

