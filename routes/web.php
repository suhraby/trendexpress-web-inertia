<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileCompleteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WebController::class, 'index'])->name('index');

Route::middleware(['auth', 'profile.complete', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/complete', [ProfileCompleteController::class, 'edit'])
        ->name('profile.complete');

    Route::put('/profile/complete', [ProfileCompleteController::class, 'update'])
        ->name('profile.complete.update');
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
