<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    /**
     * Tampilkan daftar tahun ajaran
     */
    public function index()
    {
        // Urutkan: Yang Aktif paling atas, lalu berdasarkan tahun terbaru
        $academicYears = AcademicYear::orderBy('status', 'asc') // 'Aktif' (A) < 'Tidak Aktif' (T)
            ->orderBy('tahun_ajaran', 'desc')
            ->paginate(10);

        return view('tu.academic_years.index', compact('academicYears'));
    }

    /**
     * Form tambah
     */
    public function create()
    {
        return view('tu.academic_years.create');
    }

    /**
     * Simpan data baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string', // Contoh: 2025/2026
            'semester'     => 'required|in:Ganjil,Genap',
            'status'       => 'required|in:Aktif,Tidak Aktif',
        ]);

        // Jika user memilih 'Aktif', maka yang lain harus jadi 'Tidak Aktif'
        if ($request->status == 'Aktif') {
            AcademicYear::where('status', 'Aktif')->update(['status' => 'Tidak Aktif']);
        }

        AcademicYear::create($request->all());

        return redirect()->route('tu.academic_years.index')
            ->with('success', 'Tahun Ajaran berhasil ditambahkan.');
    }

    /**
     * Form edit
     */
    public function edit(AcademicYear $academicYear)
    {
        return view('tu.academic_years.edit', compact('academicYear'));
    }

    /**
     * Update data
     */
    public function update(Request $request, AcademicYear $academicYear)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string',
            'semester'     => 'required|in:Ganjil,Genap',
            'status'       => 'required|in:Aktif,Tidak Aktif',
        ]);

        // Logic switch aktif
        if ($request->status == 'Aktif') {
            AcademicYear::where('id', '!=', $academicYear->id)
                ->where('status', 'Aktif')
                ->update(['status' => 'Tidak Aktif']);
        }

        $academicYear->update($request->all());

        return redirect()->route('tu.academic_years.index')
            ->with('info', 'Tahun Ajaran berhasil diperbarui.');
    }

    /**
     * Set Aktif via Tombol Cepat
     */
    public function setActive($id)
    {
        // Nonaktifkan semua dulu
        AcademicYear::query()->update(['status' => 'Tidak Aktif']);

        // Aktifkan yang dipilih
        AcademicYear::where('id', $id)->update(['status' => 'Aktif']);

        return redirect()->back()->with('success', 'Tahun Ajaran Aktif berhasil diubah!');
    }

    /**
     * Hapus data
     */
    public function destroy(AcademicYear $academicYear)
    {
        if ($academicYear->status == 'Aktif') {
            return redirect()->back()->with('error', 'Tahun Ajaran yang sedang AKTIF tidak boleh dihapus!');
        }

        $academicYear->delete();
        return redirect()->route('tu.academic_years.index')
            ->with('error', 'Data berhasil dihapus.');
    }
}
