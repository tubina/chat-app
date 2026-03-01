<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/home', function () {
    return Inertia::render('Home');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/************************* CHAT *************************/

Route::get('/dashboard', [ChatController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/dashboard/{userId}', [ChatController::class, 'index'])->name('chat.index');
Route::get('/chat/{userId}', [ChatController::class, 'openChat'])->name('chat.open')->middleware('auth');
Route::post('/chat/{userId}', [ChatController::class, 'send'])->name('chat.send')->middleware('auth');


require __DIR__.'/auth.php';
