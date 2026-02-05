<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\Classroom;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil data siswa berdasarkan user login
        $student = Student::where('id_user', $user->id)->firstOrFail();

        // Setup Waktu Lokal Indonesia
        Carbon::setLocale('id');
        $now = Carbon::now();
        $hariIni = $now->isoFormat('dddd'); // Contoh: Senin, Selasa
        $jamSekarang = $now->format('H:i:s');

        // 1. Ambil Jadwal Hari Ini
        $todaysSchedules = Schedule::with(['subject', 'teacher', 'kelas'])
            ->where('id_kelas', $student->id_kelas)
            ->where('hari', $hariIni)
            ->orderBy('jam_mulai', 'asc')
            ->get();

        // 2. Logika Mencari 'Next Schedule' (Jadwal Berikutnya)
        $nextSchedule = null;

        // Cek dulu apakah ada jadwal hari ini yang belum lewat jamnya
        $nextSchedule = $todaysSchedules->filter(function ($jadwal) use ($jamSekarang) {
            return $jadwal->jam_mulai > $jamSekarang;
        })->first();

        // Jika hari ini sudah tidak ada jadwal, cari jadwal di hari-hari berikutnya
        if (!$nextSchedule) {
            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
            $currentDayIndex = array_search($hariIni, $days);

            // Loop max 6 hari ke depan
            if ($currentDayIndex !== false) {
                for ($i = 1; $i <= 6; $i++) {
                    $nextDayIndex = ($currentDayIndex + $i) % 7;
                    $nextDayName = $days[$nextDayIndex];

                    // Cari jadwal paling pagi di hari tersebut
                    $upcoming = Schedule::with(['subject', 'teacher', 'kelas'])
                        ->where('id_kelas', $student->id_kelas)
                        ->where('hari', $nextDayName)
                        ->orderBy('jam_mulai', 'asc')
                        ->first();

                    if ($upcoming) {
                        $nextSchedule = $upcoming;
                        // Kita tambahkan atribut tambahan biar bisa dipakai di View kalau mau
                        $nextSchedule->day_name = $nextDayName;
                        $nextSchedule->is_tomorrow = ($i === 1);
                        break; // Stop looping kalau sudah ketemu jadwal terdekat
                    }
                }
            }
        }

        // 3. Rata-rata Nilai (FIX: Menggunakan 'id_siswa' sesuai struktur database terbaru)
        // Sebelumnya error karena mencari 'student_id' atau 'nis_siswa'
        $averageGrade = Grade::where('id_siswa', $student->id)->avg('nilai_akhir');

        // Jika belum ada nilai, set ke 0 agar tidak error di view
        if (is_null($averageGrade)) {
            $averageGrade = 0;
        }

        // 4. Informasi Kelas
        $classroom = Classroom::find($student->id_kelas);

        // Kirim semua variabel ke View
        return view('Siswa.dashboard', compact(
            'student',
            'todaysSchedules',
            'nextSchedule',
            'averageGrade',
            'classroom'
        ));
    }
}
