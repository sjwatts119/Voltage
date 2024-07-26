<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'message',
        'conversation_id',
        'created_at',
        'updated_at',
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reads()
    {
        return $this->hasMany(MessageRead::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function createMessageReads() : void
    {
        $conversation = $this->conversation;
        $participants = $conversation->users;

        foreach ($participants as $user) {
            $this->reads()->create([
                'user_id' => $user->id,
                'read_at' => null,
            ]);
        }
    }

    protected static function boot() : void
    {
        parent::boot();

        static::created(function ($message) {
            $message->createMessageReads();
        });
    }

    public function isRead() : bool
    {
        return $this->reads()->where('user_id', Auth::id())->first()->read_at !== null;
    }

    public function markAsRead() : void
    {
        // We need to mark the message as being read by the authenticated user
        $read = $this->reads->where('user_id', Auth::id())->first();

        $read->read_at = now();

        $read->save();
    }
}

