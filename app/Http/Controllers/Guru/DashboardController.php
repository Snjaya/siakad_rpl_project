<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use App\Models\Schedule;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil User yang sedang login
        $user = Auth::user();

        // 2. Cari Data Guru berdasarkan ID User
        $teacher = Teacher::where('id_user', $user->id)->first();

        // Cek jika data guru tidak ditemukan (misal akun admin iseng masuk)
        if (!$teacher) {
            return view('guru.dashboard', [
                'schedules' => collect([]),
                'teacherName' => $user->username
            ]);
        }

        // 3. Ambil Jadwal Mengajar Guru Tersebut
        $schedules = Schedule::with(['kelas', 'subject'])
            ->where('id_guru', $teacher->id)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('guru.dashboard', [
            'schedules' => $schedules,
            'teacherName' => $teacher->nama_guru
        ]);
    }
}
