<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

// --- Imports Controller Admin ---
use App\Http\Controllers\Admin\UserController;

// --- Imports Controller TU ---
use App\Http\Controllers\TU\StudentController;
use App\Http\Controllers\TU\SubjectController;
use App\Http\Controllers\TU\TeacherController;
use App\Http\Controllers\TU\ScheduleController;
use App\Http\Controllers\TU\ClassroomController;
use App\Http\Controllers\TU\AcademicYearController;
// Import Controller Dashboard TU yang baru
use App\Http\Controllers\TU\DashboardController as TUDashboardController;

// --- Imports Controller Guru ---
use App\Http\Controllers\Guru\GradeController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;

// --- Imports Controller Siswa ---
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\ScheduleController as SiswaScheduleController;
use App\Http\Controllers\Siswa\GradeController as SiswaGradeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Redirect root URL (/) langsung ke halaman Login
Route::redirect('/', '/login');

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
        default => redirect('/login'),
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

    // Fitur Kelola Akun User
    Route::resource('users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);

    // Fitur Reset Password
    Route::get('users/{user}/password', [UserController::class, 'editPassword'])->name('admin.users.password');
    Route::put('users/{user}/password', [UserController::class, 'updatePassword'])->name('admin.users.password.update');
});

// Aktor: Tata Usaha (TU)
Route::middleware(['auth', 'role:TU'])->prefix('tu')->group(function () {

    // --- PERBAIKAN DI SINI ---
    // Menggunakan Controller Class, BUKAN function() {...}
    Route::get('/dashboard', [TUDashboardController::class, 'index'])->name('tu.dashboard');
    // -------------------------

    // Data Guru
    Route::resource('teachers', TeacherController::class)->names([
        'index' => 'tu.teachers.index',
        'create' => 'tu.teachers.create',
        'store' => 'tu.teachers.store',
        'edit' => 'tu.teachers.edit',
        'update' => 'tu.teachers.update',
        'destroy' => 'tu.teachers.destroy',
    ]);

    // Data Kelas
    Route::resource('classrooms', ClassroomController::class)->names([
        'index' => 'tu.classrooms.index',
        'create' => 'tu.classrooms.create',
        'store' => 'tu.classrooms.store',
        'edit' => 'tu.classrooms.edit',
        'update' => 'tu.classrooms.update',
        'destroy' => 'tu.classrooms.destroy',
    ]);

    // Data Siswa
    Route::resource('students', StudentController::class)->names([
        'index' => 'tu.students.index',
        'create' => 'tu.students.create',
        'store' => 'tu.students.store',
        'edit' => 'tu.students.edit',
        'update' => 'tu.students.update',
        'destroy' => 'tu.students.destroy',
    ]);

    // Mata Pelajaran
    Route::resource('subjects', SubjectController::class)->names('tu.subjects');

    // Tahun Ajaran
    Route::resource('academic-years', AcademicYearController::class)->names('tu.academic_years');
    Route::patch('academic-years/{id}/active', [AcademicYearController::class, 'setActive'])->name('tu.academic_years.active');

    // Jadwal Pelajaran
    Route::resource('schedules', ScheduleController::class)->names([
        'index' => 'tu.schedules.index',
        'create' => 'tu.schedules.create',
        'store' => 'tu.schedules.store',
        'edit' => 'tu.schedules.edit',
        'update' => 'tu.schedules.update',
        'destroy' => 'tu.schedules.destroy',
    ]);
});

// Aktor: Guru
Route::middleware(['auth', 'role:Guru'])->prefix('guru')->group(function () {
    // Dashboard Guru
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('guru.dashboard');

    // Route Input Nilai
    Route::get('/grades/{schedule}/input', [GradeController::class, 'create'])->name('guru.grades.create');
    Route::post('/grades/{schedule}/store', [GradeController::class, 'store'])->name('guru.grades.store');
});

// Aktor: Siswa
Route::middleware(['auth', 'role:Siswa'])->prefix('siswa')->group(function () {
    // Dashboard Siswa
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('siswa.dashboard');

    // Route Jadwal Siswa
    Route::get('/my-schedule', [SiswaScheduleController::class, 'index'])->name('siswa.schedules.index');

    // Route Nilai Siswa
    Route::get('/my-grades', [SiswaGradeController::class, 'index'])->name('siswa.grades.index');
});

/**
 * Fungsionalitas Profil
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
