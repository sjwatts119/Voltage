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
        'profile_thumb',
        'banner_photo',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // If thumbnail is accessed but not set, return the profile photo
    public function getProfileThumbAttribute($value)
    {
        // If profile_thumb is null or empty, return profile_photo
        if(!$value) {
            return $this->profile_photo;
        } else {
            return $value;
        }
    }
}
