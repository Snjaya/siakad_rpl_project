<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Menampilkan daftar siswa
     */
    public function index()
    {
        // Eager Loading 'kelas' (sesuai nama fungsi di Model Student)
        // Mengurutkan berdasarkan nama siswa
        $students = Student::with('kelas')
            ->orderBy('nama_siswa', 'asc')
            ->paginate(10);

        return view('tu.students.index', compact('students'));
    }

    /**
     * Menampilkan form tambah siswa
     */
    public function create()
    {
        // Ambil semua data kelas untuk dropdown
        $classrooms = Classroom::orderBy('nama_kelas', 'asc')->get();
        return view('tu.students.create', compact('classrooms'));
    }

    /**
     * Menyimpan data siswa baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis'           => 'required|numeric|unique:students,nis',
            'nama_siswa'    => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'tanggal_lahir' => 'required|date',
            'no_hp'         => 'required|string|max:15',
            'alamat'        => 'nullable|string',
            'id_kelas'      => 'required|exists:classes,id',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat Akun User untuk Login
            $user = User::create([
                'username' => $request->nis, // Login pakai NIS
                'email'    => $request->email,
                'password' => Hash::make('siswa123'), // Password Default
                'role'     => 'Siswa',
            ]);

            // 2. Buat Data Profil Siswa
            Student::create([
                'id_user'       => $user->id, // Sambungkan ke User yang baru dibuat
                'id_kelas'      => $request->id_kelas,
                'nis'           => $request->nis,
                'nama_siswa'    => $request->nama_siswa,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_hp'         => $request->no_hp,
                'alamat'        => $request->alamat,
                // Field lain (tempat_lahir, jenis_kelamin) bisa ditambahkan jika formnya ada
            ]);
        });

        return redirect()->route('tu.students.index')
            ->with('success', 'Siswa berhasil didaftarkan & akun dibuat (Password: siswa123).');
    }

    /**
     * Menampilkan form edit siswa
     */
    public function edit(Student $student)
    {
        // Ambil data kelas untuk dropdown saat edit
        $classrooms = Classroom::orderBy('nama_kelas', 'asc')->get();

        return view('tu.students.edit', compact('student', 'classrooms'));
    }

    /**
     * Memperbarui data siswa
     */
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nama_siswa'    => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'no_hp'         => 'required|string|max:15',
            'alamat'        => 'nullable|string',
            'id_kelas'      => 'required|exists:classes,id',
        ]);

        // Update data tabel students
        $student->update([
            'nama_siswa'    => $request->nama_siswa,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_hp'         => $request->no_hp,
            'alamat'        => $request->alamat,
            'id_kelas'      => $request->id_kelas,
        ]);

        return redirect()->route('tu.students.index')
            ->with('info', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Menghapus data siswa dan akun loginnya
     */
    public function destroy(Student $student)
    {
        DB::transaction(function () use ($student) {
            // Hapus akun User-nya dulu (Relasi Parent)
            if ($student->user) {
                $student->user->delete();
            }

            // Hapus data Siswa (Relasi Child)
            $student->delete();
        });

        return redirect()->route('tu.students.index')
            ->with('error', 'Data siswa & akun telah dihapus permanen.');
    }
}
