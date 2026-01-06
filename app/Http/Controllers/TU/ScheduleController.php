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
    public function index(Request $request)
    {
        $query = Schedule::with(['classroom', 'subject', 'teacher'])
            ->orderBy('hari', 'desc')
            ->orderBy('jam_mulai', 'asc');

        if ($request->has('kelas') && $request->kelas != '') {
            $query->where('id_kelas', $request->kelas);
        }

        $schedules = $query->get();
        $classrooms = Classroom::orderBy('nama_kelas')->get();

        return view('tu.schedules.index', compact('schedules', 'classrooms'));
    }

    public function create()
    {
        $classrooms = Classroom::orderBy('nama_kelas')->get();
        $subjects = Subject::orderBy('nama_mapel')->get();
        $teachers = Teacher::orderBy('nama_guru')->get();

        return view('tu.schedules.create', compact('classrooms', 'subjects', 'teachers'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Input (Gunakan nip_teacher)
        $request->validate([
            'id_kelas' => 'required|exists:classes,id_kelas',
            'id_mapel' => 'required|exists:subjects,id_mapel',
            'nip_teacher' => 'required|exists:teachers,nip', // PERBAIKAN
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        // 2. Cek Bentrok Jadwal (Gunakan nip_teacher)
        $bentrok = Schedule::where('nip_teacher', $request->nip_teacher) // PERBAIKAN
            ->where('hari', $request->hari)
            ->where(function ($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai]);
            })->exists();

        if ($bentrok) {
            return back()->with('error', 'Gagal! Guru tersebut sudah ada jadwal di jam yang sama.');
        }

        Schedule::create($request->all());

        return redirect()->route('tu.schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $classrooms = Classroom::orderBy('nama_kelas')->get();
        $subjects = Subject::orderBy('nama_mapel')->get();
        $teachers = Teacher::orderBy('nama_guru')->get();

        return view('tu.schedules.edit', compact('schedule', 'classrooms', 'subjects', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kelas' => 'required',
            'id_mapel' => 'required',
            'nip_teacher' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->all());

        return redirect()->route('tu.schedules.index')->with('info', 'Jadwal diperbarui.');
    }

    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();
        return redirect()->route('tu.schedules.index')->with('error', 'Jadwal dihapus.');
    }
}
