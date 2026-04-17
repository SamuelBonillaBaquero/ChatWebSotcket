<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

Route::get('/chat',[ChatController::class,'ViewChat'])->name('chat.view')->middleware('auth');
Route::post('/chat',[ChatController::class,'createMessage'])->name('chat.create')->middleware('auth');

require __DIR__.'/settings.php';
