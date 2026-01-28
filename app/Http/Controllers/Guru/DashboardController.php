<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Grade;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Cek apakah data guru ada
        if (!$user->teacher) {
            return view('guru.dashboard', [
                'error' => 'Data Guru belum terhubung dengan akun ini.',
                'schedules' => collect([]),
                'stats' => []
            ]);
        }

        $guru = $user->teacher;

        // 1. Tentukan Hari Ini (Format Indonesia: Senin, Selasa, dst)
        Carbon::setLocale('id');
        $hariIni = Carbon::now()->translatedFormat('l'); // Senin, Selasa...
        $tanggalIni = Carbon::now()->translatedFormat('d F Y');

        // 2. Ambil Jadwal KHUSUS HARI INI
        $jadwalHariIni = Schedule::with(['kelas', 'subject'])
            ->where('id_guru', $guru->id)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // 3. Hitung Statistik Ringkas untuk Cards
        $totalKelas = Schedule::where('id_guru', $guru->id)->distinct('id_kelas')->count('id_kelas');
        $totalJam = Schedule::where('id_guru', $guru->id)->count(); // Asumsi 1 row = 1 sesi

        // Hitung total siswa yang diajar (dari semua kelas)
        $kelasIds = Schedule::where('id_guru', $guru->id)->pluck('id_kelas');
        $totalSiswa = Student::whereIn('id_kelas', $kelasIds)->count();

        return view('guru.dashboard', compact(
            'guru',
            'jadwalHariIni',
            'hariIni',
            'tanggalIni',
            'totalKelas',
            'totalJam',
            'totalSiswa'
        ));
    }
}
