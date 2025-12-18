<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\TU\StudentController;
use App\Http\Controllers\TU\TeacherController;
use App\Http\Controllers\TU\ClassroomController;

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

    // Fitur Kelola Akun User (A.5) 
    Route::resource('users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);

    // Fitur Reset Password (A.4) 
    Route::get('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('admin.users.reset');
    Route::patch('/users/{user}/reset-password', [UserController::class, 'updatePassword'])->name('admin.users.update-password');
});

// Aktor: Tata Usaha (TU)
Route::middleware(['auth', 'role:TU'])->prefix('tu')->group(function () {
    Route::get('/dashboard', function () {
        return view('tu.dashboard');
    })->name('tu.dashboard');

    // Tambahkan Route ini:
    Route::resource('teachers', TeacherController::class)->names([
        'index' => 'tu.teachers.index',
        'create' => 'tu.teachers.create',
        'store' => 'tu.teachers.store',
        'edit' => 'tu.teachers.edit',
        'update' => 'tu.teachers.update',
        'destroy' => 'tu.teachers.destroy',
    ]);

    // Route Resource Data Kelas (D.2 / D.3 Penunjang)
    Route::resource('classrooms', ClassroomController::class)->names([
        'index' => 'tu.classrooms.index',
        'create' => 'tu.classrooms.create',
        'store' => 'tu.classrooms.store',
        'edit' => 'tu.classrooms.edit',
        'update' => 'tu.classrooms.update',
        'destroy' => 'tu.classrooms.destroy',
    ]);

    // Route Resource Data Siswa (D.2)
    Route::resource('students', StudentController::class)->names([
        'index' => 'tu.students.index',
        'create' => 'tu.students.create',
        'store' => 'tu.students.store',
        'edit' => 'tu.students.edit',
        'update' => 'tu.students.update',
        'destroy' => 'tu.students.destroy',
    ]);
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
