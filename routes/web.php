<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Group untuk Admin 
    Route::middleware(['role:Admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });

    // Group untuk TU [cite: 47]
    Route::middleware(['role:TU'])->prefix('tu')->group(function () {
        Route::get('/dashboard', [TUController::class, 'index'])->name('tu.dashboard');
    });
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
