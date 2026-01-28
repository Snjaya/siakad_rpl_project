<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Schedule;
use App\Models\Classroom;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil Data Guru Login
        $guru = Auth::user()->teacher;

        // 2. Cari Kelas apa saja yang diajar oleh Guru ini
        // Mengambil id_kelas unik dari tabel schedules
        $classIds = Schedule::where('id_guru', $guru->id)
            ->pluck('id_kelas')
            ->unique();

        // 3. Ambil Data Kelas untuk Filter Dropdown
        $classes = Classroom::whereIn('id', $classIds)->get();

        // 4. Query Data Siswa
        $query = Student::with('kelas')
            ->whereIn('id_kelas', $classIds);

        // Filter: Jika Guru memilih kelas tertentu di dropdown
        if ($request->has('id_kelas') && $request->id_kelas != '') {
            $query->where('id_kelas', $request->id_kelas);
        }

        // Ambil data (Pagination biar rapi)
        $students = $query->orderBy('nama_siswa', 'asc')->paginate(10);

        return view('guru.students.index', compact('students', 'classes'));
    }
}
