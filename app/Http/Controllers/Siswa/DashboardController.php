<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Grade;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil Data Siswa 
        $student = Student::with('kelas')->where('id_user', $user->id)->first();

        if (!$student) {
            return view('siswa.dashboard', [
                'student' => null,
                'nextSchedule' => null,
                'averageGrade' => 0
            ]);
        }

        // 2. Ambil Jadwal Hari Ini
        $hariIni = \Carbon\Carbon::now()->locale('id')->isoFormat('dddd'); // Senin, Selasa, dst
        $nextSchedule = Schedule::with(['subject', 'teacher'])
            ->where('id_kelas', $student->id_kelas)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // 3. Hitung Rata-rata Nilai (IPK Sederhana)
        $averageGrade = Grade::where('nis_siswa', $student->nis)->avg('nilai_akhir');

        return view('siswa.dashboard', compact('student', 'nextSchedule', 'averageGrade'));
    }
}
