<?php

use Illuminate\Support\Str;

if (!function_exists('makeLinksClickable')) {
    function makeLinksClickable($text) : string
    {
        return Str::of($text)->replaceMatches(
            '/(https?:\/\/[^\s]+)/',
            '<a href="$1" target="_blank" class="text-blue-500 hover:underline">$1</a>'
        );
    }
}
