<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Teacher;
use Illuminate\Http\Request;

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
}
