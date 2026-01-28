<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Schedule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    /**
     * Menampilkan Daftar Siswa (Index)
     */
    public function index(Request $request)
    {
        $query = Student::with(['user', 'kelas']);

        // 1. Filter Pencarian (Nama/NIS)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_siswa', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        // 2. Filter Kelas (Dropdown)
        if ($request->has('id_kelas') && $request->id_kelas != '') {
            $query->where('id_kelas', $request->id_kelas);
        }

        // Ambil Data Siswa (Pagination 10 per halaman)
        $students = $query->orderBy('nama_siswa', 'asc')->paginate(10);

        // 3. Ambil Data Kelas untuk Dropdown Filter di Index
        $classes = Classroom::orderBy('nama_kelas', 'asc')->get();

        return view('tu.students.index', compact('students', 'classes'));
    }

    /**
     * Menampilkan Form Tambah Siswa
     */
    public function create()
    {
        // FIX: Pastikan nama variabel sesuai dengan yang dipanggil di blade (biasanya $classrooms)
        $classrooms = Classroom::orderBy('nama_kelas', 'asc')->get();
        return view('tu.students.create', compact('classrooms'));
    }

    /**
     * Menyimpan Data Siswa Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis'        => 'required|numeric|unique:students,nis',
            'email'      => 'required|email|unique:users,email',
            'id_kelas'   => 'nullable|exists:classes,id',
            'gender'     => 'required|in:L,P',
            'no_hp'      => 'nullable|string|max:15',
            'alamat'     => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // 1. Buat Akun User Login Otomatis
                $user = User::create([
                    'username' => $request->nis, // Menggunakan NIS sebagai username agar unik
                    'email'    => $request->email,
                    'password' => Hash::make('12345678'), // Password default
                    'role'     => 'Siswa',
                ]);

                // 2. Buat Data Siswa
                Student::create([
                    'id_user'       => $user->id,
                    'id_kelas'      => $request->id_kelas,
                    'nis'           => $request->nis,
                    'nama_siswa'    => $request->nama_siswa,
                    'jenis_kelamin' => $request->gender,
                    'no_hp'         => $request->no_hp,
                    'alamat'        => $request->alamat,
                ]);
            });

            return redirect()->route('tu.students.index')->with('success', 'Siswa dan Akun Login berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan Form Edit Siswa
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $classrooms = Classroom::orderBy('nama_kelas', 'asc')->get();

        return view('tu.students.edit', compact('student', 'classrooms'));
    }

    /**
     * Update Data Siswa
     */
    public function update(Request $request, $id)
    {
        $student = Student::with('user')->findOrFail($id);

        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis'        => 'required|numeric|unique:students,nis,' . $student->id,
            'id_kelas'   => 'nullable|exists:classes,id',
            'gender'     => 'required|in:L,P',
            'no_hp'      => 'nullable|string|max:15',
            'alamat'     => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($request, $student) {
                // 1. Update data siswa
                $student->update([
                    'id_kelas'      => $request->id_kelas,
                    'nis'           => $request->nis,
                    'nama_siswa'    => $request->nama_siswa,
                    'jenis_kelamin' => $request->gender,
                    'no_hp'         => $request->no_hp,
                    'alamat'        => $request->alamat,
                ]);

                // 2. Sinkronisasi data ke User (Update username dengan NIS terbaru)
                if ($student->user) {
                    $student->user->update([
                        'username' => $request->nis
                    ]);
                }
            });

            return redirect()->route('tu.students.index')->with('success', 'Data siswa berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus Data Siswa
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        try {
            DB::transaction(function () use ($student) {
                // Hapus User Login-nya dulu
                if ($student->user) {
                    $student->user->delete();
                }
                // Baru hapus data student
                $student->delete();
            });
            return redirect()->route('tu.students.index')->with('success', 'Siswa dan akun login berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data.');
        }
    }

    /**
     * Cetak Laporan Daftar Siswa
     */
    public function print(Request $request)
    {
        $query = Student::with('kelas');
        $namaKelas = "Semua Kelas";

        if ($request->has('id_kelas') && $request->id_kelas != '') {
            $query->where('id_kelas', $request->id_kelas);
            $kelas = Classroom::find($request->id_kelas);
            if ($kelas) {
                $namaKelas = $kelas->nama_kelas . ' (' . $kelas->jurusan . ')';
            }
        }

        $students = $query->orderBy('nama_siswa', 'asc')->get();
        return view('tu.students.print', compact('students', 'namaKelas'));
    }

    /**
     * Halaman Kenaikan Kelas
     */
    public function promotionPage()
    {
        $classes = Classroom::orderBy('tingkat', 'asc')->get();
        return view('tu.students.promotion', compact('classes'));
    }

    /**
     * Proses Kenaikan Kelas Massal
     */
    public function promote(Request $request)
    {
        $request->validate([
            'from_class' => 'required|exists:classes,id',
            'to_class'   => 'required',
        ]);

        $fromClass = Classroom::find($request->from_class);
        $studentCount = Student::where('id_kelas', $request->from_class)->count();

        if ($studentCount == 0) {
            return redirect()->back()->with('error', "Tidak ada siswa di kelas {$fromClass->nama_kelas}.");
        }

        if ($request->to_class === 'lulus') {
            Student::where('id_kelas', $request->from_class)->update(['id_kelas' => null]);
            $msg = "Pembaruan Berhasil! {$studentCount} siswa dari {$fromClass->nama_kelas} kini berstatus Lulus.";
        } else {
            $toClass = Classroom::find($request->to_class);
            Student::where('id_kelas', $request->from_class)->update(['id_kelas' => $request->to_class]);
            $msg = "Kenaikan Berhasil! {$studentCount} siswa dari {$fromClass->nama_kelas} telah dipindah ke {$toClass->nama_kelas}.";
        }

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Cetak Transkrip Nilai Siswa (Semua Mapel)
     */
    public function printAllGrades($id)
    {
        $student = Student::with('kelas')->findOrFail($id);

        $grades = Grade::with(['schedule.subject', 'schedule.teacher'])
            ->where('id_siswa', $id)
            ->get();

        return view('tu.students.print_all_grades', compact('student', 'grades'));
    }
}
