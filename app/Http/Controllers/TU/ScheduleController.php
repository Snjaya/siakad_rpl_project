<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Tampilkan Daftar Jadwal
     */
    public function index()
    {
        // 1. Ambil Data Jadwal
        $schedules = Schedule::with(['kelas', 'subject', 'teacher'])
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai', 'asc')
            ->paginate(10);

        // 2. Ambil Data Kelas (INI YANG KURANG SEBELUMNYA)
        $classrooms = Classroom::orderBy('nama_kelas')->get();

        // 3. Kirim $schedules DAN $classrooms ke View
        return view('tu.schedules.index', compact('schedules', 'classrooms'));
    }

    /**
     * Form Tambah
     */
    public function create()
    {
        // Ambil data pendukung untuk dropdown
        $classrooms = Classroom::orderBy('nama_kelas')->get();
        $subjects   = Subject::orderBy('nama_mapel')->get();
        $teachers   = Teacher::orderBy('nama_guru')->get();

        return view('tu.schedules.create', compact('classrooms', 'subjects', 'teachers'));
    }

    /**
     * Simpan Jadwal
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kelas'    => 'required|exists:classes,id',
            'id_mapel'    => 'required|exists:subjects,id',
            'id_guru'     => 'required|exists:teachers,id',
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        Schedule::create($request->all());

        return redirect()->route('tu.schedules.index')
            ->with('success', 'Jadwal pelajaran berhasil ditambahkan.');
    }

    /**
     * Form Edit
     */
    public function edit(Schedule $schedule)
    {
        $classrooms = Classroom::orderBy('nama_kelas')->get();
        $subjects   = Subject::orderBy('nama_mapel')->get();
        $teachers   = Teacher::orderBy('nama_guru')->get();

        return view('tu.schedules.edit', compact('schedule', 'classrooms', 'subjects', 'teachers'));
    }

    /**
     * Update Jadwal
     */
    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'id_kelas'    => 'required|exists:classes,id',
            'id_mapel'    => 'required|exists:subjects,id',
            'id_guru'     => 'required|exists:teachers,id',
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        $schedule->update($request->all());

        return redirect()->route('tu.schedules.index')
            ->with('info', 'Jadwal pelajaran berhasil diperbarui.');
    }

    /**
     * Hapus Jadwal
     */
    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('tu.schedules.index')
            ->with('error', 'Jadwal berhasil dihapus.');
    }
}
