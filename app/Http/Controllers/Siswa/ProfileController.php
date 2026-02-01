<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Student;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Tampilkan Halaman Edit Profil Siswa
     */
    public function edit()
    {
        $user = Auth::user();

        // PERBAIKAN: Gunakan 'kelas' sesuai nama fungsi di Model Student
        $student = Student::with('kelas')->where('id_user', $user->id)->firstOrFail();

        return view('siswa.profile.edit', compact('user', 'student'));
    }

    /**
     * Proses Update Data (Hanya data Non-Resmi)
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $student = Student::where('id_user', $user->id)->firstOrFail();

        // 1. Validasi Input
        $request->validate([
            'no_hp'  => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
            'foto'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        // 2. Update Foto Profil (di tabel users)
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // Simpan foto baru
            $path = $request->file('foto')->store('profile-photos', 'public');

            User::where('id', $user->id)->update(['foto' => $path]);
        }

        // 3. Update Data Kontak Siswa (di tabel students)
        $student->update([
            'no_hp'  => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
