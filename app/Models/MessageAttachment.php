<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class MessageAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'message_id',
        'original_filename',
        'attachment_path',
        'type',
    ];

    public function message() : BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    public function getFileSize() : string
    {
        $unformatted = Storage::size("public/attachments/" . $this->message->id . "/" . $this->attachment_path);

        // Convert the bytes to a human readable format
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        for ($i = 0; $unformatted > 1024; $i++) {
            $unformatted /= 1024;
        }

        return round($unformatted, 2) . $units[$i];
    }

    public function getFileExtension() : string
    {
        if(!$extension = pathinfo($this->attachment_path, PATHINFO_EXTENSION))
        {
            $extension = "File";
        }

        return $extension;
    }
}
