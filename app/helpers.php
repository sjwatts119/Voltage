<?php

use Illuminate\Support\Str;

if (!function_exists('makeLinksClickable')) {
    function makeLinksClickable($text)
    {
        // Convert URLs into clickable links
        $text = preg_replace(
            '#(https?://[^\s]+)#',
            '<a href="$1" target="_blank" rel="noopener noreferrer" class="text-blue-500 hover:underline">$1</a>',
            e($text)
        );

        return Blade::render($text);
    }
}
