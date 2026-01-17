<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher; // <--- Pastikan import ini ada
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    /**
     * Tampilkan Form Input Nilai per Kelas
     */
    public function create($schedule_id)
    {
        // 1. Ambil Data Jadwal
        $schedule = Schedule::with(['kelas', 'subject', 'teacher'])->findOrFail($schedule_id);

        // 2. Ambil Data Guru yang sedang login (Metode Aman)
        $user = Auth::user();
        $teacher = Teacher::where('id_user', $user->id)->first();

        // Cek apakah akun ini benar-benar guru
        if (!$teacher) {
            return abort(403, 'Akun Anda tidak terdaftar sebagai Guru.');
        }

        // 3. Validasi: Pastikan Guru yang login adalah pemilik jadwal ini
        // (Mencegah guru A menginput nilai pelajaran guru B)
        if ($schedule->id_guru !== $teacher->id) {
            return abort(403, 'Anda tidak memiliki hak akses untuk menginput nilai di jadwal ini.');
        }

        // 4. Ambil Siswa di Kelas tersebut beserta Nilai (jika sudah ada)
        $students = Student::where('id_kelas', $schedule->id_kelas)
            ->with(['grades' => function ($query) use ($schedule_id) {
                $query->where('id_jadwal', $schedule_id);
            }])
            ->orderBy('nama_siswa')
            ->get();

        return view('guru.grades.create', compact('schedule', 'students'));
    }

    /**
     * Simpan Nilai (Bulk Update/Create)
     */
    public function store(Request $request, $schedule_id)
    {
        // Validasi input array
        $request->validate([
            'grades' => 'required|array',
            'grades.*.tugas' => 'nullable|numeric|min:0|max:100',
            'grades.*.uts'   => 'nullable|numeric|min:0|max:100',
            'grades.*.uas'   => 'nullable|numeric|min:0|max:100',
        ]);

        DB::transaction(function () use ($request, $schedule_id) {
            foreach ($request->grades as $student_id => $data) {

                // Ambil nilai, jika kosong anggap 0
                $tugas = $data['tugas'] ?? 0;
                $uts   = $data['uts'] ?? 0;
                $uas   = $data['uas'] ?? 0;

                // Rumus Nilai Akhir: 30% Tugas + 30% UTS + 40% UAS
                $nilai_akhir = ($tugas * 0.3) + ($uts * 0.3) + ($uas * 0.4);

                // Simpan ke database
                Grade::updateOrCreate(
                    [
                        'id_jadwal' => $schedule_id,
                        'nis_siswa' => $data['nis'] // Kunci pencarian (NIS)
                    ],
                    [
                        'tugas'       => $tugas,
                        'uts'         => $uts,
                        'uas'         => $uas,
                        'nilai_akhir' => $nilai_akhir
                    ]
                );
            }
        });

        return redirect()->route('guru.dashboard')->with('success', 'Nilai berhasil disimpan!');
    }
}
