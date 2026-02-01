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
use App\Http\Controllers\TU\DashboardController as TUDashboardController;

// --- Imports Controller Guru ---
use App\Http\Controllers\Guru\GradeController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\StudentController as GuruStudentController;
use App\Http\Controllers\Guru\ScheduleController as GuruScheduleController;

// --- Imports Controller Siswa ---
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\ScheduleController as SiswaScheduleController;
use App\Http\Controllers\Siswa\GradeController as SiswaGradeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');

/**
 * Logika Pengalihan Dashboard Berdasarkan Role
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

// ============================================================
// Aktor: Admin
// ============================================================
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);

    Route::get('users/{user}/password', [UserController::class, 'editPassword'])->name('admin.users.password');
    Route::put('users/{user}/password', [UserController::class, 'updatePassword'])->name('admin.users.password.update');
});

// ============================================================
// Aktor: Tata Usaha (TU)
// ============================================================
Route::middleware(['auth', 'role:TU'])->prefix('tu')->group(function () {

    Route::get('/dashboard', [TUDashboardController::class, 'index'])->name('tu.dashboard');

    // --- ⚠️ PENTING: ROUTE PRINT WAJIB DI ATAS RESOURCE ---
    Route::get('/teachers/print', [TeacherController::class, 'print'])->name('tu.teachers.print');
    Route::get('/students/print', [StudentController::class, 'print'])->name('tu.students.print');
    Route::get('/schedules/print', [ScheduleController::class, 'print'])->name('tu.schedules.print');

    Route::get('/promotion', [StudentController::class, 'promotionPage'])->name('tu.students.promotion');
    Route::post('/promotion', [StudentController::class, 'promote'])->name('tu.students.promote');

    Route::get('/students/{student}/print-all-grades', [StudentController::class, 'printAllGrades'])->name('tu.students.print_all_grades');
    Route::get('/classrooms/{classroom}/print-grades', [ClassroomController::class, 'printClassGrades'])->name('tu.classrooms.print_grades');

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

// ============================================================
// Aktor: Guru
// ============================================================
Route::middleware(['auth', 'role:Guru'])->prefix('guru')->name('guru.')->group(function () {

    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');

    // 1. JADWAL MENGAJAR (Hanya Melihat Jadwal)
    Route::get('/schedules', [GuruScheduleController::class, 'index'])->name('schedules.index');

    Route::get('/students', [GuruStudentController::class, 'index'])->name('students.index');

    // 2. MANAJEMEN INPUT NILAI (Fitur Terpisah)
    // Halaman List Kelas untuk Input Nilai
    Route::get('/grades/input', [GradeController::class, 'indexInput'])->name('grades.index');

    // Proses Input/Edit Nilai
    Route::get('/grades/{schedule}/input', [GradeController::class, 'create'])->name('grades.create');
    Route::post('/grades/{schedule}/store', [GradeController::class, 'store'])->name('grades.store');
    Route::get('/grades/{schedule}/edit', [GradeController::class, 'edit'])->name('grades.edit');
    Route::put('/grades/{schedule}/update', [GradeController::class, 'update'])->name('grades.update');
    Route::get('/grades/{schedule}/print', [GradeController::class, 'print'])->name('grades.print');

    // 3. REKAP NILAI (Fitur Cetak)
    Route::get('/recap-grades', [GradeController::class, 'recapIndex'])->name('grades.recap_index');
    Route::get('/grades/recap/{schedule}', [GradeController::class, 'printRecap'])->name('grades.print_recap');

    // === FITUR B.3: UPDATE PROFIL ===
    Route::get('/profile/edit', [App\Http\Controllers\Guru\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [App\Http\Controllers\Guru\ProfileController::class, 'update'])->name('profile.update');
});

// ============================================================
// Aktor: Siswa
// ============================================================
Route::middleware(['auth', 'role:Siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-schedule', [SiswaScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/my-grades', [SiswaGradeController::class, 'index'])->name('grades.index');

    Route::get('/profile/edit', [App\Http\Controllers\Siswa\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [App\Http\Controllers\Siswa\ProfileController::class, 'update'])->name('profile.update');
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
