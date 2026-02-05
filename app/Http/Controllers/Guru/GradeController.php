<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function indexInput()
    {
        $user = Auth::user();
        $teacher = Teacher::where('id_user', $user->id)->first();

        $schedules = Schedule::with(['kelas', 'subject'])
            ->where('id_guru', $teacher->id)
            ->orderBy('hari', 'desc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('guru.grades.index', compact('schedules'));
    }

    public function create($scheduleId)
    {
        $schedule = Schedule::with(['kelas', 'subject'])->findOrFail($scheduleId);

        $students = Student::where('id_kelas', $schedule->id_kelas)
            ->orderBy('nama_siswa', 'asc')
            ->get();

        if (Grade::where('id_jadwal', $scheduleId)->exists()) {
            return redirect()->route('guru.grades.edit', $scheduleId)
                ->with('info', 'Nilai sudah ada. Dialihkan ke mode Edit.');
        }

        return view('guru.grades.create', compact('schedule', 'students'));
    }

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
                // Pastikan siswa valid
                $student = Student::find($studentId);

                if (!$student) continue;

                $tugas = $data['tugas'] ?? 0;
                $uts   = $data['uts'] ?? 0;
                $uas   = $data['uas'] ?? 0;
                $final = ($tugas * 0.20) + ($uts * 0.30) + ($uas * 0.50);

                Grade::create([
                    'id_jadwal'   => $schedule->id,
                    'id_siswa'    => $student->id, // FIX: Gunakan id_siswa (ID), bukan nis_siswa
                    'tugas'       => $tugas,
                    'uts'         => $uts,
                    'uas'         => $uas,
                    'nilai_akhir' => $final,
                ]);
            }
        });

        return redirect()->route('guru.grades.index')->with('success', 'Nilai berhasil disimpan!');
    }

    public function edit($scheduleId)
    {
        $schedule = Schedule::with(['kelas', 'subject'])->findOrFail($scheduleId);

        $students = Student::where('id_kelas', $schedule->id_kelas)
            ->orderBy('nama_siswa', 'asc')
            ->get();

        // Ambil semua nilai pada jadwal ini
        $gradesData = Grade::where('id_jadwal', $scheduleId)->get();

        // Mapping: Key array menggunakan id_siswa agar cocok dengan loop di View
        $grades = [];
        foreach ($gradesData as $grade) {
            // FIX: Langsung gunakan id_siswa sebagai key, tidak perlu query lookup NIS lagi
            $grades[$grade->id_siswa] = $grade;
        }

        return view('guru.grades.edit', compact('schedule', 'students', 'grades'));
    }

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
                $student = Student::find($studentId);

                if (!$student) continue;

                $tugas = $data['tugas'] ?? 0;
                $uts   = $data['uts'] ?? 0;
                $uas   = $data['uas'] ?? 0;
                $final = ($tugas * 0.20) + ($uts * 0.30) + ($uas * 0.50);

                // FIX: Gunakan updateOrCreate dengan kunci id_jadwal & id_siswa
                Grade::updateOrCreate(
                    [
                        'id_jadwal' => $schedule->id,
                        'id_siswa'  => $student->id, // FIX: Gunakan id_siswa
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

        return redirect()->route('guru.grades.index')->with('success', 'Perubahan nilai berhasil disimpan!');
    }

    public function recapIndex()
    {
        $user = Auth::user();
        $teacher = Teacher::where('id_user', $user->id)->first();

        $schedules = Schedule::with(['kelas', 'subject'])
            ->where('id_guru', $teacher->id)
            ->orderBy('hari', 'desc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('guru.grades.recap', compact('schedules'));
    }

    public function printRecap($scheduleId)
    {
        $user = Auth::user();
        $teacher = Teacher::where('id_user', $user->id)->first();

        $schedule = Schedule::with(['kelas', 'subject'])
            ->where('id', $scheduleId)
            ->where('id_guru', $teacher->id)
            ->firstOrFail();

        $students = Student::where('id_kelas', $schedule->id_kelas)
            ->orderBy('nama_siswa', 'asc')
            ->get();

        // Ambil Grades dan Mapping ke ID Siswa
        $gradesData = Grade::where('id_jadwal', $scheduleId)->get();
        $gradesMap = [];

        foreach ($gradesData as $g) {
            // FIX: Langsung map pakai id_siswa
            $gradesMap[$g->id_siswa] = $g;
        }

        foreach ($students as $student) {
            $student->grade = $gradesMap[$student->id] ?? null;
        }

        return view('guru.grades.print_recap', compact('schedule', 'students', 'teacher'));
    }

    public function print($scheduleId)
    {
        return $this->printRecap($scheduleId);
    }
}
