<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $user = Auth::user(); // Get the currently authenticated user
    $conversations = $user->conversations; // Get the user's conversations

    return view('dashboard', ['conversations' => $conversations]); // Pass the conversations to the view
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
