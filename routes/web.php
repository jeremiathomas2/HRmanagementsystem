<?php

use Illuminate\Support\Facades\Route;

// Public routes (no authentication required)
Route::get('/login', function () {
    return view('login');
})->name('login');

// Redirect root to login
Route::get('/', function () {
    return redirect('/login');
});

// Protected routes (authentication required)
Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('app');
    });
    
    Route::get('/{any?}', function () {
        return view('app');
    })->where('any', '^(?!login|dashboard).*');
});
