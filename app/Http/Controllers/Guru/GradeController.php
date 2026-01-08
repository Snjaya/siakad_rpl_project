<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    // Menampilkan Form Input Nilai per Jadwal
    public function create($schedule_id)
    {
        $schedule = Schedule::with(['classroom', 'subject'])->findOrFail($schedule_id);

        $students = Student::where('id_kelas', $schedule->id_kelas)
            ->orderBy('nama_siswa')
            ->get();

        $existingGrades = Grade::where('id_jadwal', $schedule_id)
            ->get()
            ->keyBy('nis_siswa');

        return view('guru.grades.create', compact('schedule', 'students', 'existingGrades'));
    }

    // Menyimpan Nilai
    public function store(Request $request, $schedule_id)
    {
        $request->validate([
            'grades' => 'required|array',
        ]);

        DB::transaction(function () use ($request, $schedule_id) {
            foreach ($request->grades as $nis => $data) {
                // Pastikan input angka, jika kosong anggap 0
                $tugas = $data['tugas'] ?? 0;
                $uts = $data['uts'] ?? 0;
                $uas = $data['uas'] ?? 0;

                // Rumus Rata-rata
                $akhir = ($tugas + $uts + $uas) / 3;

                Grade::updateOrCreate(
                    [
                        'id_jadwal' => $schedule_id,
                        'nis_siswa' => $nis,
                    ],
                    [
                        'tugas' => $tugas,
                        'uts' => $uts,
                        'uas' => $uas,
                        'nilai_akhir' => $akhir
                    ]
                );
            }
        });

        // Redirect kembali ke halaman input (back) bukan ke dashboard
        return redirect()->back()->with('success', 'Nilai siswa berhasil disimpan!');
    }
}
