<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil User yang sedang login
        $user = Auth::user();

        // 2. Cari Data Siswa berdasarkan id_user
        // Kita perlu load relasi 'classroom' untuk menampilkan nama kelas
        $student = Student::with('classroom')->where('id_user', $user->id)->first();

        // Jika data siswa belum diinput oleh TU
        if (!$student) {
            return view('siswa.dashboard', [
                'student' => null
            ])->with('error', 'Data diri Anda belum terdaftar di sistem akademik. Hubungi Tata Usaha.');
        }

        return view('siswa.dashboard', compact('student'));
    }
}
