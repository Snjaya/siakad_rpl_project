<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Grade;

class GradeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = Student::where('id_user', $user->id)->firstOrFail();

        // Ambil Nilai Siswa Ini
        $grades = Grade::with(['jadwal.subject', 'jadwal.teacher'])
            ->where('nis_siswa', $student->nis)
            ->get();

        return view('siswa.grades.index', compact('grades', 'student'));
    }
}
