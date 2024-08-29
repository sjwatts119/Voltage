<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_group'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'conversation_users');
    }

    public function messages() : HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function profile() : HasOne {
        return $this->hasOne(ConversationProfile::class);
    }

    protected static function boot() : void {
        parent::boot();

        static::created(function($conversation) {
            $conversation->profile()->create();
        });
    }

    public static function getParticipants($id){
        //retrieve all conversation participants according to the conversation id passed
        return Conversation::find($id)->users;
    }

    public static function getFriendlyName($id, $maxLength): string {
        // Retrieve the conversation along with its participants
        $conversation = Conversation::with('users')->find($id);

        // Remove the authenticated user from the conversation
        $participants = $conversation->users->filter(function($user) {
            return $user->id != auth()->id();
        });

        // If not a group chat, return the name of the other participant
        if (!$conversation->is_group) {
            return $participants->first()->name;
        }

        // Return the conversation name if it exists
        if ($conversation->name) {
            return $conversation->name;
        }

        // If it is just the authenticated user in the conversation, return "Just You"
        if ($participants->count() === 0) {
            return 'Just You';
        }

        // Get participant names as a comma-separated string
        $friendlyName = implode(', ', $participants->pluck('name')->toArray());

        // Limit the string to $maxLength characters, appending "..." if it's longer
        return Str::limit($friendlyName, $maxLength, '...');
    }

    public function getFriendlyLastMessage($maxLength) : string
    {
        // Get the last message in the that isn't a system message
        $lastMessage = $this->messages->where('type', '!=', 'system')->last();

        if(!$lastMessage) {
            return '';
        }

        // Is the message value null? If so, check if there are attachments, we should return a message like X sent y attachments
        if(!$lastMessage->message) {
            $attachmentCount = $lastMessage->attachments->count();
            return $attachmentCount > 0 ? $lastMessage->user->name . ': ' . $attachmentCount . ' attachment' . ($attachmentCount > 1 ? 's' : '') : '';
        }
        else {
            // Return the message as it exists
            $message = $lastMessage->user->name  . ': ' . $lastMessage->message;
        }

        // Limit the string to $maxLength characters, appending "..." if it's longer
        return Str::limit($message, $maxLength, '...');
    }

    public function getUnreadCount() : int
    {
        // Get the unread messages in the conversation
        return $this->messages->reduce(function($carry, $message) {
            return $carry + $message->reads->where('user_id', '=', auth()->id())->whereNull('read_at')->count();
        }, 0);
    }

    public function getFriendlyUnreadCount() : string
    {
        // Get the unread messages in the conversation
        $unreadCount = $this->getUnreadCount();

        // Return an empty string if there are no unread messages
        if ($unreadCount === 0) {
            return '';
        }

        // Return the unread count as a string
        return $unreadCount > 9 ? '9+' : (string) $unreadCount;
    }

}

