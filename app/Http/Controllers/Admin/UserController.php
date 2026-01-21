<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // 1. Mulai Query (kecuali diri sendiri)
        $query = User::where('id', '!=', Auth::id());

        // 2. Logika Search (Jika ada input 'search')
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 3. Sorting & Pagination (10 per halaman)
        $users = $query->orderBy('role', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString(); // Agar search tidak hilang saat ganti halaman

        return view('admin.users.index', compact('users'));
    }

    // ... Method create, store, edit, update, destroy TETAP SAMA seperti sebelumnya ...
    // (Tidak perlu diubah, copy paste bagian index saja cukup)

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:Admin,TU,Guru,Siswa'],
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:Admin,TU,Guru,Siswa'],
        ]);

        $data = [
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => ['confirmed', Rules\Password::defaults()]]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if ($user->id == Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }

    /**
     * Tampilkan Form Reset Password
     */
    public function editPassword(User $user)
    {
        return view('admin.users.password', compact('user'));
    }

    /**
     * Proses Update Password
     */
    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Password untuk user ' . $user->username . ' berhasil direset!');
    }
}
