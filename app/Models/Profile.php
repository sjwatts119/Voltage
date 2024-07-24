<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'pronouns',
        'bio',
        'profile_photo',
        'banner_photo',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
