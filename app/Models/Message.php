<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'message',
        'conversation_id',
        'created_at',
        'updated_at',
        'id',
    ];
}
