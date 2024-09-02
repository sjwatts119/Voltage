<?php

namespace App\Traits;

use App\Events\MessageSent;
use App\Models\Conversation;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\PngEncoder;
use Intervention\Image\ImageManager;

trait SendsMessage {
    public function createMessage(Conversation $conversation, $messageInput, $attachments = null) {

        $newMessage = $conversation->messages()->create([
            'user_id' => auth()->id(),
            'message' => $messageInput,
        ]);

        if($attachments) {
            // Loop through each attachment
            foreach ($this->attachments as $attachment) {
                // Store the attachment under subdirectory of the message id
                $attachment->store('attachments/' . $newMessage->id, 'public');

                // Create a thumbnail for images
                if (str_contains($attachment->getMimeType(), 'image')) {

                    // Create an instance of the image manager
                    $manager = new ImageManager(new Driver());

                    // Read image from file system
                    $image = $manager->read(storage_path('app/public/attachments/' . $newMessage->id . '/' . $attachment->hashName()));

                    // Resize the image to 300px height while maintaining the aspect ratio
                    $image->scale(height: 300);

                    // If it's not a gif, encode to png
                    if(!str_contains($attachment->getMimeType(), 'gif')) {
                        $image->encode(new PngEncoder());
                    }

                    // Save the thumbnail
                    $image->save(storage_path('app/public/attachments/' . $newMessage->id . '/thumbnail-' . $attachment->hashName()));
                }

                // Create the message attachment in the db
                $newMessage->attachments()->create([
                    'original_filename' => $attachment->getClientOriginalName(),
                    'attachment_path' => $attachment->hashName(),
                    'type' => $attachment->getMimeType(),
                ]);
            }
        }

        // Mark the message as read for the sender
        $newMessage->markAsRead();

        // Broadcast the message without including the message contents for security
        MessageSent::dispatch($newMessage->id, $newMessage->conversation_id);
    }
}
