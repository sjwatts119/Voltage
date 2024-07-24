<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'dashboard')
    ->middleware(['auth'])
    ->name('dashboard');



require __DIR__.'/auth.php';
