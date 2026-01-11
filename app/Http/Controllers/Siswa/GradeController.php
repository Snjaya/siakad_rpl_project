<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        // 1. Ambil Siswa yang login
        $user = Auth::user();
        $student = Student::where('id_user', $user->id)->first();

        if (!$student) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan.');
        }

        // 2. Ambil Nilai Siswa tersebut
        // Kita load relasi ke Jadwal -> Mapel & Guru untuk ditampilkan infonya
        $grades = Grade::with(['schedule.subject', 'schedule.teacher'])
            ->where('nis_siswa', $student->nis)
            ->get();

        return view('siswa.grades.index', compact('grades', 'student'));
    }
}
