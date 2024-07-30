<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationProfile extends Model
{
    use HasFactory;

    // belongs to conversation
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
