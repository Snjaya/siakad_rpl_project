<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    /**
     * Menampilkan daftar nilai siswa (KHS)
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil data profil siswa yang login
        $student = Student::with('kelas')->where('id_user', $user->id)->first();

        // Jika data siswa tidak ditemukan
        if (!$student) {
            return redirect()->route('siswa.dashboard')->with('error', 'Profil siswa tidak ditemukan.');
        }

        // 2. Ambil data nilai (Grades)
        // Memanggil relasi 'jadwal' dan sub-relasi 'subject' serta 'teacher'
        $grades = Grade::with(['jadwal.subject', 'jadwal.teacher'])
            ->where('id_siswa', $student->id)
            ->get();

        // 3. Tampilkan ke view
        return view('siswa.grades.index', compact('student', 'grades'));
    }
}
