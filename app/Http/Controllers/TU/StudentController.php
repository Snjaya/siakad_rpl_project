<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Models\Classroom; // Pastikan Model Kelas di-import
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

        // 3. Ambil Data Kelas untuk Dropdown Filter (INI YANG SEBELUMNYA KURANG)
        $classes = Classroom::orderBy('nama_kelas', 'asc')->get();

        return view('tu.students.index', compact('students', 'classes'));
    }

    /**
     * Menampilkan Form Tambah Siswa
     */
    public function create()
    {
        // Ambil user dengan role Siswa yang belum punya data student (Opsional, jika sistemnya link manual)
        // Atau biarkan kosong jika create siswa otomatis create user
        $classes = Classroom::orderBy('nama_kelas', 'asc')->get();
        return view('tu.students.create', compact('classes'));
    }

    /**
     * Menyimpan Data Siswa Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis'        => 'required|numeric|unique:students,nis',
            'email'      => 'required|email|unique:users,email', // Email untuk akun login
            'id_kelas'   => 'nullable|exists:classes,id',
            'gender'     => 'required|in:L,P',
            'no_hp'      => 'nullable|string|max:15',
            'alamat'     => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat Akun User Login Otomatis
            $user = User::create([
                'username' => $request->nama_siswa, // Username default nama siswa
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
    }

    /**
     * Menampilkan Form Edit Siswa
     */
    public function edit($id)
    {
        $student = Student::with('user')->findOrFail($id);
        $classes = Classroom::orderBy('nama_kelas', 'asc')->get();
        return view('tu.students.edit', compact('student', 'classes'));
    }

    /**
     * Update Data Siswa
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'nis'        => 'required|numeric|unique:students,nis,' . $student->id,
            'id_kelas'   => 'nullable|exists:classes,id',
            'gender'     => 'required|in:L,P',
            'no_hp'      => 'nullable|string|max:15',
            'alamat'     => 'nullable|string',
        ]);

        $student->update([
            'id_kelas'      => $request->id_kelas,
            'nis'           => $request->nis,
            'nama_siswa'    => $request->nama_siswa,
            'jenis_kelamin' => $request->gender,
            'no_hp'         => $request->no_hp,
            'alamat'        => $request->alamat,
        ]);

        // Update nama di user juga agar sinkron
        if ($student->user) {
            $student->user->update(['username' => $request->nama_siswa]);
        }

        return redirect()->route('tu.students.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    /**
     * Hapus Data Siswa
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        // Hapus User Login-nya juga (Cascade Delete biasanya menghandle ini, tapi manual lebih aman)
        if ($student->user) {
            $student->user->delete();
        }

        // Hapus datanya (Jika foreign key on delete cascade, user dihapus student ikut terhapus)
        // Tapi jika relasinya terbalik, kita hapus student-nya.
        $student->delete();

        return redirect()->route('tu.students.index')->with('success', 'Siswa berhasil dihapus.');
    }

    // ==========================================
    // FITUR CETAK (D.8)
    // ==========================================

    /**
     * Cetak Laporan Data Siswa (PDF/Print)
     */
    public function print(Request $request)
    {
        $query = Student::with('kelas');
        $namaKelas = "Semua Kelas";

        // Filter jika user memilih kelas tertentu
        if ($request->has('id_kelas') && $request->id_kelas != '') {
            $query->where('id_kelas', $request->id_kelas);

            // Ambil nama kelas untuk judul laporan
            $kelas = Classroom::find($request->id_kelas);
            if ($kelas) {
                $namaKelas = $kelas->nama_kelas . ' (' . $kelas->jurusan . ')';
            }
        }

        $students = $query->orderBy('nama_siswa', 'asc')->get();

        return view('tu.students.print', compact('students', 'namaKelas'));
    }

    public function promotionPage()
    {
        $classes = Classroom::orderBy('tingkat', 'asc')->get();
        return view('tu.students.promotion', compact('classes'));
    }

    public function promote(Request $request)
    {
        $request->validate([
            'from_class' => 'required|exists:classes,id',
            'to_class' => 'required',
        ]);

        // Cari data kelas asal
        $fromClass = \App\Models\Classroom::find($request->from_class);
        // Hitung jumlah siswa
        $studentCount = \App\Models\Student::where('id_kelas', $request->from_class)->count();

        if ($studentCount == 0) {
            return redirect()->back()->with('error', "Tidak ada siswa di kelas {$fromClass->nama_kelas}.");
        }

        if ($request->to_class === 'lulus') {
            \App\Models\Student::where('id_kelas', $request->from_class)->update(['id_kelas' => null]);
            $msg = "Pembaruan Berhasil! {$studentCount} siswa dari {$fromClass->nama_kelas} kini berstatus Lulus.";
        } else {
            $toClass = \App\Models\Classroom::find($request->to_class);
            \App\Models\Student::where('id_kelas', $request->from_class)->update(['id_kelas' => $request->to_class]);
            $msg = "Kenaikan Berhasil! {$studentCount} siswa dari {$fromClass->nama_kelas} telah dipindah ke {$toClass->nama_kelas}.";
        }

        return redirect()->back()->with('success', $msg);
    }

    public function printAllGrades($id)
    {
        // 1. Ambil data siswa beserta kelasnya
        $student = Student::with('kelas')->findOrFail($id);

        // 2. Ambil semua nilai siswa ini, hubungkan ke jadwal -> mapel -> guru
        $grades = \App\Models\Grade::with(['schedule.subject', 'schedule.teacher'])
            ->where('id_siswa', $id)
            ->get();

        // 3. Kelompokkan nilai berdasarkan tahun ajaran (opsional tapi bagus untuk kerapihan)
        return view('tu.students.print_all_grades', compact('student', 'grades'));
    }
}
