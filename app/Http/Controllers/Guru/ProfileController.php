<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Teacher;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Tampilkan Halaman Edit Profil
     */
    public function edit()
    {
        $user = Auth::user();
        // Ambil data guru berdasarkan user yang login
        $teacher = Teacher::where('id_user', $user->id)->firstOrFail();

        return view('guru.profile.edit', compact('user', 'teacher'));
    }

    /**
     * Proses Update Data (Hanya data Non-Resmi)
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $teacher = Teacher::where('id_user', $user->id)->firstOrFail();

        // 1. Validasi Input
        $request->validate([
            'no_hp'  => 'nullable|string|max:15',
            'alamat' => 'nullable|string|max:255',
            'foto'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        // 2. Update Data User (Foto Profil)
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada (dan bukan default)
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // Simpan foto baru
            $path = $request->file('foto')->store('profile-photos', 'public');

            // Update kolom foto di tabel users
            User::where('id', $user->id)->update(['foto' => $path]);
        }

        // 3. Update Data Guru (Alamat & No HP)
        $teacher->update([
            'no_hp'  => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
