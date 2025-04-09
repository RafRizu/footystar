<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Dashboard - show player stats and actions
    Route::get('/dashboard', [PlayerController::class, 'index'])->name('dashboard');

    // Training
    Route::post('/train', [PlayerController::class, 'train'])->name('player.train');

    // Play Ranked Match
    Route::post('/ranked', [PlayerController::class, 'playRanked'])->name('player.ranked');


    // Rest to recover stamina
    Route::post('/rest', [PlayerController::class, 'rest'])->name('player.rest');
});

require __DIR__.'/auth.php';
