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
    /**
     * Menampilkan daftar guru
     */
    public function index()
    {
        $teachers = Teacher::orderBy('nama_guru', 'asc')->paginate(10);

        return view('tu.teachers.index', compact('teachers'));
    }

    /**
     * Menampilkan form tambah guru
     */
    public function create()
    {
        return view('tu.teachers.create');
    }

    /**
     * Menyimpan data guru baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip'           => 'required|numeric|unique:teachers,nip',
            'nama_guru'     => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'no_hp'         => 'required|string|max:15',
            'tempat_lahir'  => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat'        => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat Akun Login (User)
            $user = User::create([
                'username' => $request->nip, // Username pakai NIP
                'email'    => $request->email,
                'password' => Hash::make('guru123'), // Default Password
                'role'     => 'Guru',
            ]);

            // 2. Buat Data Biodata Guru
            Teacher::create([
                'id_user'       => $user->id,
                'nip'           => $request->nip,
                'nama_guru'     => $request->nama_guru,
                'email'         => $request->email, // Simpan email juga di tabel guru untuk kemudahan
                'no_hp'         => $request->no_hp,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat'        => $request->alamat,
            ]);
        });

        return redirect()->route('tu.teachers.index')
            ->with('success', 'Data Guru berhasil ditambahkan (Password: guru123).');
    }

    /**
     * Menampilkan form edit guru
     */
    public function edit(Teacher $teacher)
    {
        return view('tu.teachers.edit', compact('teacher'));
    }

    /**
     * Memperbarui data guru
     */
    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'nama_guru'     => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $teacher->user->id, // Abaikan email milik sendiri
            'no_hp'         => 'required|string|max:15',
            'tempat_lahir'  => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'alamat'        => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $teacher) {
            // 1. Update Akun Login (Email)
            if ($teacher->user) {
                $teacher->user->update([
                    'email' => $request->email
                ]);
            }

            // 2. Update Data Guru
            $teacher->update([
                'nama_guru'     => $request->nama_guru,
                'email'         => $request->email,
                'no_hp'         => $request->no_hp,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat'        => $request->alamat,
            ]);
        });

        return redirect()->route('tu.teachers.index')
            ->with('info', 'Data guru berhasil diperbarui.');
    }

    /**
     * Menghapus data guru
     */
    public function destroy(Teacher $teacher)
    {
        DB::transaction(function () use ($teacher) {
            if ($teacher->user) {
                $teacher->user->delete();
            }
            $teacher->delete();
        });

        return redirect()->route('tu.teachers.index')
            ->with('error', 'Data guru & akun login telah dihapus.');
    }

    public function print()
    {
        // Ambil semua data guru, urutkan nama
        $teachers = Teacher::orderBy('nama_guru', 'asc')->get();

        // Return ke View Khusus Cetak
        return view('tu.teachers.print', compact('teachers'));
    }
}
