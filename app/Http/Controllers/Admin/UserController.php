<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // Menampilkan daftar user
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    // Tambah Akun -> Warna Hijau (success)
    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'in:Admin,TU,Guru,Siswa'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun baru berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Edit Akun -> Warna Biru (info)
    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:Admin,TU,Guru,Siswa'],
        ]);

        $user->update($request->only('username', 'email', 'role'));

        return redirect()->route('admin.users.index')->with('info', 'Data akun berhasil diperbarui.');
    }

    // Hapus Akun -> Warna Merah (error)
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('warning', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('error', 'Akun telah dihapus dari sistem.');
    }

    public function resetPassword(User $user)
    {
        return view('admin.users.reset', compact('user'));
    }

    // Reset Password -> Warna Kuning (warning)
    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('warning', 'Password user ' . $user->username . ' berhasil direset.');
    }
}
