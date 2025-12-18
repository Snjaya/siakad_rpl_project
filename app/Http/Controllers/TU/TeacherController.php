<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    public function index()
    {
        // Mengambil data guru beserta akun user-nya
        $teachers = Teacher::with('user')->latest()->get();
        return view('tu.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('tu.teachers.create');
    }

    public function store(Request $request)
    {
        // Validasi Input
        $request->validate([
            'nip' => 'required|string|unique:teachers,nip',
            'nama_guru' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Untuk akun login
            'tanggal_lahir' => 'required|date',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        // Gunakan Transaction Data
        DB::transaction(function () use ($request) {
            // 1. Buat Akun User untuk Guru
            $user = User::create([
                'username' => $request->nip, // Username = NIP
                'email' => $request->email,
                'password' => Hash::make('guru123'), // Password Default
                'role' => 'Guru',
            ]);

            // 2. Buat Data Guru (masuk ke tabel teachers)
            Teacher::create([
                'nip' => $request->nip,
                'id_user' => $user->id, // Foreign Key
                'nama_guru' => $request->nama_guru,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]);
        });

        return redirect()->route('tu.teachers.index')->with('success', 'Data Guru & Akun berhasil ditambahkan!');
    }

    public function edit(Teacher $teacher)
    {
        return view('tu.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'nama_guru' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'nullable|string',
        ]);

        // Update data tabel teachers
        $teacher->update([
            'nama_guru' => $request->nama_guru,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('tu.teachers.index')->with('info', 'Data Guru berhasil diperbarui.');
    }

    public function destroy(Teacher $teacher)
    {
        DB::transaction(function () use ($teacher) {
            // Hapus Akun User terkait (Cascade delete di database sebenarnya sudah menangani ini, tapi kita pastikan di level aplikasi)
            if ($teacher->user) {
                $teacher->user->delete();
            }
            // Hapus Data Guru
            $teacher->delete();
        });

        return redirect()->route('tu.teachers.index')->with('error', 'Data Guru dan Akun Login telah dihapus.');
    }
}
