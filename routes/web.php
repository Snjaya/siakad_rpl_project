<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Logika Pengalihan Dashboard Berdasarkan Role
 * Diarahkan ke rute spesifik aktor setelah login berhasil.
 */
Route::get('/dashboard', function () {
    $role = Auth::user()->role;

    return match ($role) {
        'Admin' => redirect()->route('admin.dashboard'),
        'TU'    => redirect()->route('tu.dashboard'),
        'Guru'  => redirect()->route('guru.dashboard'),
        'Siswa' => redirect()->route('siswa.dashboard'),
        default => redirect('/'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * Route Grouping Berdasarkan Role
 * Menggunakan Middleware RoleManager untuk otorisasi akses.
 */

// Aktor: Admin
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Aktor: Tata Usaha (TU)
Route::middleware(['auth', 'role:TU'])->prefix('tu')->group(function () {
    Route::get('/dashboard', function () {
        return view('tu.dashboard');
    })->name('tu.dashboard');
});

// Aktor: Guru
Route::middleware(['auth', 'role:Guru'])->prefix('guru')->group(function () {
    Route::get('/dashboard', function () {
        return view('guru.dashboard');
    })->name('guru.dashboard');
});

// Aktor: Siswa
Route::middleware(['auth', 'role:Siswa'])->prefix('siswa')->group(function () {
    Route::get('/dashboard', function () {
        return view('siswa.dashboard');
    })->name('siswa.dashboard');
});

/**
 * Fungsionalitas Profil (Wajib untuk mengatasi RouteNotFoundException)
 * Digunakan oleh navigasi Breeze untuk menu 'Profile'.
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
