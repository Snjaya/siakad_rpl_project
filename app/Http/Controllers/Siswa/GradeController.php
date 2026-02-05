<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Grade;

class GradeController extends Controller
{
    /**
     * Menampilkan daftar nilai milik siswa yang sedang login
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil data siswa berdasarkan user yang login
        $student = Student::where('id_user', $user->id)->firstOrFail();

        // 2. Ambil nilai berdasarkan 'id_siswa' (Sesuai Migration fix_grades_table_columns)
        $grades = Grade::with(['jadwal.subject', 'jadwal.teacher', 'jadwal.kelas'])
            ->where('id_siswa', $student->id)
            ->get();

        return view('Siswa.grades.index', compact('grades', 'student'));
    }
}
