<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $teacher = \App\Models\Teacher::where('id_user', $user->id)->first();

        // Pastikan ini mengambil get(), BUKAN groupBy()
        $schedules = \App\Models\Schedule::with(['kelas', 'subject'])
            ->where('id_guru', $teacher->id)
            // Urutkan manual agar hari Senin muncul duluan (opsional)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('guru.schedules.index', compact('schedules'));
    }
}
