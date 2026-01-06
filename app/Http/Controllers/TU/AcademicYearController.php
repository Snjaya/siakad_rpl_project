<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function index()
    {
        // Ubah sorting: 'Aktif' (huruf A) akan muncul duluan jika ASCENDING
        $academicYears = AcademicYear::orderBy('status_aktif', 'asc')
            ->orderBy('tahun_ajaran', 'desc')
            ->get();
        return view('tu.academic_years.index', compact('academicYears'));
    }

    public function create()
    {
        return view('tu.academic_years.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        $exists = AcademicYear::where('tahun_ajaran', $request->tahun_ajaran)
            ->where('semester', $request->semester)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Data Tahun Ajaran & Semester tersebut sudah ada!');
        }

        AcademicYear::create([
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
            // PERBAIKAN DI SINI: Gunakan String 'Tidak Aktif'
            'status_aktif' => 'Tidak Aktif',
        ]);

        return redirect()->route('tu.academic_years.index')->with('success', 'Tahun Ajaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $academicYear = AcademicYear::findOrFail($id);
        return view('tu.academic_years.edit', compact('academicYear'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        $academicYear = AcademicYear::findOrFail($id);
        $academicYear->update($request->only('tahun_ajaran', 'semester'));

        return redirect()->route('tu.academic_years.index')->with('info', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $academicYear = AcademicYear::findOrFail($id);

        // PERBAIKAN DI SINI: Cek string 'Aktif'
        if ($academicYear->status_aktif == 'Aktif') {
            return back()->with('error', 'Gagal! Tidak bisa menghapus Tahun Ajaran yang sedang AKTIF.');
        }

        $academicYear->delete();

        return redirect()->route('tu.academic_years.index')->with('error', 'Data berhasil dihapus.');
    }

    public function setActive($id)
    {
        // 1. Non-aktifkan semua (Set ke string 'Tidak Aktif')
        AcademicYear::query()->update(['status_aktif' => 'Tidak Aktif']);

        // 2. Aktifkan yang dipilih (Set ke string 'Aktif')
        $academicYear = AcademicYear::findOrFail($id);
        $academicYear->update(['status_aktif' => 'Aktif']);

        return redirect()->route('tu.academic_years.index')->with('success', 'Tahun Ajaran ' . $academicYear->tahun_ajaran . ' (' . $academicYear->semester . ') sekarang AKTIF.');
    }
}
