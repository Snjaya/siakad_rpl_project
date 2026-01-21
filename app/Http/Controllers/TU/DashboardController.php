<?php

namespace App\Http\Controllers\TU;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\AcademicYear;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil Data Statistik
        $totalSiswa = Student::count();
        $totalGuru = Teacher::count();
        $totalKelas = Classroom::count();
        $totalMapel = Subject::count();

        // Ambil Tahun Ajaran Aktif
        $activeYear = AcademicYear::where('status', 'Aktif')->first();

        return view('tu.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'totalMapel',
            'activeYear'
        ));
    }
}
