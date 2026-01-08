<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil User yang sedang login
        $user = Auth::user();

        // 2. Cari Data Guru berdasarkan id_user
        $teacher = Teacher::where('id_user', $user->id)->first();

        // Jika data guru tidak ditemukan (misal akun dibuat dari Admin tapi belum diinput di TU)
        if (!$teacher) {
            return view('guru.dashboard', [
                'schedules' => collect([]), // PERBAIKAN: Gunakan collect([]) agar tetap dianggap Collection
                'teacherName' => $user->username
            ])->with('error', 'Data profil guru tidak ditemukan. Mohon hubungi Tata Usaha untuk melengkapi data Anda.');
        }

        // 3. Ambil Jadwal KHUSUS untuk guru ini
        $schedules = Schedule::with(['classroom', 'subject'])
            ->where('nip_teacher', $teacher->nip)
            // Urutkan hari: Senin s/d Sabtu
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('guru.dashboard', [
            'schedules' => $schedules,
            'teacherName' => $teacher->nama_guru
        ]);
    }
}
