<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = Student::where('id_user', $user->id)->firstOrFail();

        // Ambil Jadwal Kelas Siswa Ini
        $schedules = Schedule::with(['subject', 'teacher'])
            ->where('id_kelas', $student->id_kelas)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('siswa.schedules.index', compact('schedules', 'student'));
    }
}
