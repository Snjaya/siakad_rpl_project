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

        // Ambil data siswa berdasarkan user yang login
        $student = Student::where('id_user', $user->id)->firstOrFail();

        // Ambil nilai berdasarkan NIS
        $grades = Grade::with(['jadwal.subject', 'jadwal.teacher', 'jadwal.kelas'])
            ->where('nis_siswa', $student->nis)
            ->get();

        // PERBAIKAN: Tambahkan 'student' ke dalam compact agar bisa dibaca di View
        return view('Siswa.grades.index', compact('grades', 'student'));
    }
}
