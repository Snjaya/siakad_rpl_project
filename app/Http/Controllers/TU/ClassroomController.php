<?php

namespace App\Http\Controllers\TU;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClassroomController extends Controller
{
    public function index(Request $request)
    {
        $query = Classroom::with('teacher');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_kelas', 'like', "%{$search}%")
                ->orWhere('jurusan', 'like', "%{$search}%");
        }

        $classrooms = $query->orderBy('tingkat', 'asc')->orderBy('nama_kelas', 'asc')->get();
        return view('tu.classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        // Ambil data guru untuk dropdown Wali Kelas
        // Hanya ambil NIP dan Nama agar lebih ringan
        $teachers = Teacher::select('nip', 'nama_guru')->get();
        return view('tu.classrooms.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'tingkat' => 'required|integer|in:10,11,12',
            'nip_teacher' => 'required|exists:teachers,nip', // Pastikan NIP ada di tabel guru
        ]);

        Classroom::create($request->all());

        return redirect()->route('tu.classrooms.index')->with('success', 'Kelas baru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $classroom = Classroom::findOrFail($id);
        $teachers = Teacher::select('nip', 'nama_guru')->get();
        return view('tu.classrooms.edit', compact('classroom', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'tingkat' => 'required|integer|in:10,11,12',
            'nip_teacher' => 'required|exists:teachers,nip',
        ]);

        $classroom = Classroom::findOrFail($id);
        $classroom->update($request->all());

        return redirect()->route('tu.classrooms.index')->with('info', 'Data kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $classroom = Classroom::findOrFail($id);

        if ($classroom->students()->count() > 0) {
            return back()->with('error', 'Gagal hapus! Kelas ini masih memiliki siswa.');
        }

        $classroom->delete();

        return redirect()->route('tu.classrooms.index')->with('error', 'Data kelas berhasil dihapus.');
    }

    public function printClassGrades($id)
    {
        // 1. Ambil data kelas
        $classroom = \App\Models\Classroom::findOrFail($id);

        // 2. Ambil data siswa di kelas tersebut
        $students = \App\Models\Student::where('id_kelas', $id)
            ->orderBy('nama_siswa', 'asc')
            ->get();

        // 3. Ambil ID para siswa tersebut untuk mengambil nilai mereka
        $studentIds = $students->pluck('id');

        // 4. Ambil semua nilai milik siswa di kelas ini
        // Kita panggil manual agar tidak error "nis_siswa"
        $grades = \App\Models\Grade::with(['schedule.subject'])
            ->whereIn('id_siswa', $studentIds)
            ->get();

        // 5. Ambil daftar mata pelajaran unik untuk Header Tabel
        $subjects = \App\Models\Schedule::where('id_kelas', $id)
            ->with('subject')
            ->get()
            ->pluck('subject.nama_mapel', 'subject.id')
            ->unique();

        return view('tu.classrooms.print_grades', compact('classroom', 'students', 'grades', 'subjects'));
    }
}
