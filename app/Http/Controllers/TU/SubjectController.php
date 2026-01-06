<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::orderBy('nama_mapel')->get();
        return view('tu.subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('tu.subjects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:100',
            'kkm' => 'required|integer|min:0|max:100',
        ]);

        Subject::create($request->all());
        return redirect()->route('tu.subjects.index')->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        return view('tu.subjects.edit', compact('subject'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:100',
            'kkm' => 'required|integer|min:0|max:100',
        ]);

        Subject::findOrFail($id)->update($request->all());
        return redirect()->route('tu.subjects.index')->with('info', 'Mata Pelajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Subject::findOrFail($id)->delete();
        return redirect()->route('tu.subjects.index')->with('error', 'Mata Pelajaran dihapus.');
    }
}
