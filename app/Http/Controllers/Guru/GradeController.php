<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher; // Tambahan: Import Model Teacher
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // Tambahan: Import Facade Auth

class GradeController extends Controller
{
    /**
     * Halaman Daftar Kelas Khusus untuk Menu INPUT NILAI
     */
    public function indexInput()
    {
        $user = Auth::user();
        $teacher = Teacher::where('id_user', $user->id)->first();

        // Ambil jadwal mengajar
        $schedules = Schedule::with(['kelas', 'subject'])
            ->where('id_guru', $teacher->id)
            ->orderBy('hari', 'desc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('guru.grades.index', compact('schedules'));
    }

    /**
     * Menampilkan Form Input Nilai (Mode: Tambah Baru)
     */
    public function create($scheduleId)
    {
        // Pastikan relasi 'kelas' dan 'subject' dimuat
        $schedule = Schedule::with(['kelas', 'subject'])->findOrFail($scheduleId);

        $students = Student::where('id_kelas', $schedule->id_kelas)
            ->orderBy('nama_siswa', 'asc')
            ->get();

        // Cek apakah nilai sudah ada untuk jadwal ini
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

                // RUMUS: 20% Tugas + 30% UTS + 50% UAS
                $final = ($tugas * 0.20) + ($uts * 0.30) + ($uas * 0.50);

                Grade::create([
                    'id_jadwal'   => $schedule->id,
                    'id_siswa'    => $studentId,
                    'tugas'       => $tugas,
                    'uts'         => $uts,
                    'uas'         => $uas,
                    'nilai_akhir' => $final,
                ]);
            }
        });

        return redirect()->route('guru.grades.index') // Redirect kembali ke daftar input nilai
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

        return redirect()->route('guru.grades.index') // Redirect kembali ke daftar input nilai
            ->with('success', 'Perubahan nilai berhasil disimpan!');
    }

    /**
     * Halaman Utama Rekap Nilai (Menampilkan Daftar Kelas dengan Kartu Emerald)
     */
    public function recapIndex()
    {
        $user = Auth::user();
        $teacher = Teacher::where('id_user', $user->id)->first();

        // Ambil jadwal mengajar guru ini
        $schedules = Schedule::with(['kelas', 'subject'])
            ->where('id_guru', $teacher->id)
            ->orderBy('hari', 'desc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('guru.grades.recap', compact('schedules'));
    }

    /**
     * Proses Cetak Laporan PDF
     */
    /**
     * Proses Cetak Laporan PDF
     */
    public function printRecap($scheduleId)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $teacher = \App\Models\Teacher::where('id_user', $user->id)->first();

        // 1. Ambil Jadwal
        $schedule = \App\Models\Schedule::with(['kelas', 'subject'])
            ->where('id', $scheduleId)
            ->where('id_guru', $teacher->id)
            ->firstOrFail();

        // 2. Ambil Siswa di Kelas tersebut
        $students = \App\Models\Student::where('id_kelas', $schedule->id_kelas)
            ->orderBy('nama_siswa', 'asc')
            ->get();

        // 3. Ambil Nilai secara terpisah untuk menghindari error relasi yang kompleks
        // Kita ambil semua nilai di jadwal ini, lalu mapping berdasarkan id_siswa
        $grades = \App\Models\Grade::where('id_jadwal', $scheduleId)
            ->get()
            ->keyBy('id_siswa'); // Kunci array dengan id_siswa agar mudah diakses

        // 4. Masukkan data nilai ke dalam object student (manual injection)
        foreach ($students as $student) {
            $student->grade = $grades->get($student->id); // Ambil nilai dari collection $grades
        }

        return view('guru.grades.print_recap', compact('schedule', 'students', 'teacher'));
    }

    /**
     * Alias untuk fungsi printRecap agar tidak error pada route lama
     */
    public function print($scheduleId)
    {
        // Langsung arahkan ke fungsi printRecap yang sudah kita buat sebelumnya
        return $this->printRecap($scheduleId);
    }
}
