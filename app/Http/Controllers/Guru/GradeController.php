<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    /**
     * Menampilkan Form Input Nilai (Mode: Tambah Baru)
     */
    public function create($scheduleId)
    {
        $schedule = Schedule::with(['kelas', 'subject'])->findOrFail($scheduleId);

        $students = Student::where('id_kelas', $schedule->id_kelas)
            ->orderBy('nama_siswa', 'asc')
            ->get();

        // Cek apakah nilai sudah ada
        $existingGrade = Grade::where('id_jadwal', $scheduleId)->exists();
        if ($existingGrade) {
            return redirect()->route('guru.grades.edit', $scheduleId)
                ->with('info', 'Nilai sudah ada. Dialihkan ke mode Edit.');
        }

        return view('guru.grades.create', compact('schedule', 'students'));
    }

    /**
     * Menyimpan Nilai Baru (Store)
     */
    public function store(Request $request, $scheduleId)
    {
        $schedule = Schedule::findOrFail($scheduleId);

        $request->validate([
            'grades' => 'required|array',
            'grades.*.tugas' => 'nullable|numeric|min:0|max:100',
            'grades.*.uts'   => 'nullable|numeric|min:0|max:100',
            'grades.*.uas'   => 'nullable|numeric|min:0|max:100',
        ]);

        DB::transaction(function () use ($request, $schedule) {
            foreach ($request->grades as $studentId => $data) {
                $tugas = $data['tugas'] ?? 0;
                $uts   = $data['uts'] ?? 0;
                $uas   = $data['uas'] ?? 0;

                // RUMUS BARU: 20% Tugas + 30% UTS + 50% UAS
                $final = ($tugas * 0.20) + ($uts * 0.30) + ($uas * 0.50);

                Grade::create([
                    'id_jadwal' => $schedule->id,
                    'id_siswa'  => $studentId,
                    'tugas'     => $tugas,
                    'uts'       => $uts,
                    'uas'       => $uas,
                    'nilai_akhir' => $final,
                ]);
            }
        });

        return redirect()->route('guru.dashboard')
            ->with('success', 'Nilai berhasil disimpan!');
    }

    /**
     * Menampilkan Form Edit Nilai
     */
    public function edit($scheduleId)
    {
        $schedule = Schedule::with(['kelas', 'subject'])->findOrFail($scheduleId);

        $students = Student::where('id_kelas', $schedule->id_kelas)
            ->orderBy('nama_siswa', 'asc')
            ->get();

        $grades = Grade::where('id_jadwal', $scheduleId)
            ->get()
            ->keyBy('id_siswa');

        return view('guru.grades.edit', compact('schedule', 'students', 'grades'));
    }

    /**
     * Menyimpan Perubahan Nilai (Update)
     */
    public function update(Request $request, $scheduleId)
    {
        $schedule = Schedule::findOrFail($scheduleId);

        $request->validate([
            'grades' => 'required|array',
            'grades.*.tugas' => 'nullable|numeric|min:0|max:100',
            'grades.*.uts'   => 'nullable|numeric|min:0|max:100',
            'grades.*.uas'   => 'nullable|numeric|min:0|max:100',
        ]);

        DB::transaction(function () use ($request, $schedule) {
            foreach ($request->grades as $studentId => $data) {
                $tugas = $data['tugas'] ?? 0;
                $uts   = $data['uts'] ?? 0;
                $uas   = $data['uas'] ?? 0;

                // RUMUS BARU: 20% Tugas + 30% UTS + 50% UAS
                $final = ($tugas * 0.20) + ($uts * 0.30) + ($uas * 0.50);

                Grade::updateOrCreate(
                    [
                        'id_jadwal' => $schedule->id,
                        'id_siswa'  => $studentId,
                    ],
                    [
                        'tugas'       => $tugas,
                        'uts'         => $uts,
                        'uas'         => $uas,
                        'nilai_akhir' => $final,
                    ]
                );
            }
        });

        return redirect()->route('guru.dashboard')
            ->with('success', 'Perubahan nilai berhasil disimpan!');
    }

    public function print($scheduleId)
    {
        // 1. Ambil Data Jadwal, Kelas, Mapel, Guru
        $schedule = Schedule::with(['kelas', 'subject', 'teacher'])->findOrFail($scheduleId);

        // 2. Ambil Siswa
        $students = Student::where('id_kelas', $schedule->id_kelas)
            ->orderBy('nama_siswa', 'asc')
            ->get();

        // 3. Ambil Nilai
        $grades = Grade::where('id_jadwal', $scheduleId)
            ->get()
            ->keyBy('id_siswa');

        // 4. Return ke View Khusus Cetak
        return view('guru.grades.print', compact('schedule', 'students', 'grades'));
    }
}
