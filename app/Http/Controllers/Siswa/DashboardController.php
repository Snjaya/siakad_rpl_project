<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\Classroom;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $student = \App\Models\Student::with('kelas')->where('id_user', $user->id)->first();

        if (!$student) {
            return view('siswa.dashboard', ['student' => null]);
        }

        // PAKSA ke bahasa Indonesia agar cocok dengan tampilan di menu Jadwal Pelajaran
        // Gunakan Carbon untuk mendapatkan nama hari dalam bahasa Indonesia
        $todayIndo = \Carbon\Carbon::now()->locale('id')->isoFormat('dddd');

        // Debug sederhana: Jika ingin memastikan, Anda bisa un-comment baris di bawah ini
        // return $todayIndo; 

        $nextSchedule = \App\Models\Schedule::with(['subject', 'teacher'])
            ->where('id_kelas', $student->id_kelas)
            ->where('hari', $todayIndo) // Pastikan ini mencari "Rabu", bukan "Wednesday"
            ->orderBy('jam_mulai', 'asc')
            ->get();

        $averageGrade = \App\Models\Grade::where('id_siswa', $student->id)->avg('nilai_akhir') ?? 0;

        return view('siswa.dashboard', compact('student', 'nextSchedule', 'averageGrade'));
    }
}
