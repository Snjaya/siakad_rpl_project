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
    public function index()
    {
        // Ambil data siswa + kelasnya + akunnya
        $students = Student::with(['classroom', 'user'])->latest()->get();
        return view('tu.students.index', compact('students'));
    }

    public function create()
    {
        // Ambil daftar kelas untuk dropdown
        $classrooms = Classroom::orderBy('tingkat')->orderBy('nama_kelas')->get();
        return view('tu.students.create', compact('classrooms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|numeric|unique:students,nis',
            'nama_siswa' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'tanggal_lahir' => 'required|date',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'nullable|string',
            'id_kelas' => 'required|exists:classes,id_kelas', // Wajib pilih kelas
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat Akun Siswa (Username = NIS, Password Default = siswa123)
            $user = User::create([
                'username' => $request->nis,
                'email' => $request->email,
                'password' => Hash::make('siswa123'),
                'role' => 'Siswa',
            ]);

            // 2. Buat Data Siswa
            Student::create([
                'nis' => $request->nis,
                'id_user' => $user->id,
                'nama_siswa' => $request->nama_siswa,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
                'id_kelas' => $request->id_kelas,
            ]);
        });

        return redirect()->route('tu.students.index')->with('success', 'Siswa berhasil didaftarkan & dibuatkan akun!');
    }

    public function edit(Student $student)
    {
        $classrooms = Classroom::orderBy('tingkat')->orderBy('nama_kelas')->get();
        return view('tu.students.edit', compact('student', 'classrooms'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'nullable|string',
            'id_kelas' => 'required|exists:classes,id_kelas',
        ]);

        $student->update([
            'nama_siswa' => $request->nama_siswa,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'id_kelas' => $request->id_kelas,
        ]);

        return redirect()->route('tu.students.index')->with('info', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $student)
    {
        DB::transaction(function () use ($student) {
            if ($student->user) {
                $student->user->delete();
            }
            $student->delete();
        });

        return redirect()->route('tu.students.index')->with('error', 'Data siswa & akun telah dihapus.');
    }
}
