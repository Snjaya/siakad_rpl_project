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
        $guru = Auth::user()->teacher;

        // Ambil SEMUA jadwal, urutkan berdasarkan Hari (Senin->Sabtu) dan Jam
        $schedules = Schedule::with(['kelas', 'subject'])
            ->where('id_guru', $guru->id)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->orderBy('jam_mulai', 'asc')
            ->get()
            ->groupBy('hari'); // Kelompokkan data per Hari

        return view('guru.schedules.index', compact('schedules'));
    }
}
