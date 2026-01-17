<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Menampilkan daftar mata pelajaran
     */
    public function index()
    {
        // Gunakan paginate() agar $subjects->links() di view berfungsi
        $subjects = Subject::orderBy('nama_mapel', 'asc')->paginate(10);
        return view('tu.subjects.index', compact('subjects'));
    }

    /**
     * Form tambah mapel
     */
    public function create()
    {
        return view('tu.subjects.create');
    }

    /**
     * Simpan mapel baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:subjects,nama_mapel',
            'kkm'        => 'required|integer|min:0|max:100',
        ]);

        Subject::create($request->all());

        return redirect()->route('tu.subjects.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    /**
     * Form edit mapel
     */
    public function edit(Subject $subject)
    {
        return view('tu.subjects.edit', compact('subject'));
    }

    /**
     * Update mapel
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255|unique:subjects,nama_mapel,' . $subject->id,
            'kkm'        => 'required|integer|min:0|max:100',
        ]);

        $subject->update($request->all());

        return redirect()->route('tu.subjects.index')
            ->with('info', 'Mata pelajaran berhasil diperbarui.');
    }

    /**
     * Hapus mapel
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('tu.subjects.index')
            ->with('error', 'Mata pelajaran dihapus.');
    }
}
