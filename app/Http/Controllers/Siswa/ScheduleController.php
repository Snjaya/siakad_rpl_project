<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        // 1. Ambil User yang login
        $user = Auth::user();

        // 2. Cari Data Siswa
        $student = Student::where('id_user', $user->id)->first();

        // Cek jika data siswa belum ada
        if (!$student) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data siswa tidak ditemukan.');
        }

        // 3. Ambil Jadwal berdasarkan Kelas Siswa tersebut
        $schedules = Schedule::with(['subject', 'teacher'])
            ->where('id_kelas', $student->id_kelas)
            // Urutkan hari Senin -> Sabtu
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('siswa.schedules.index', compact('schedules', 'student'));
    }
}
