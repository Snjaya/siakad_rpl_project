<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    // Pastikan fillable sesuai dengan nama kolom baru
    protected $fillable = [
        'id_jadwal', // Ganti id_schedule jadi ini
        'id_siswa',  // Ganti id_student jadi ini
        'tugas',
        'uts',
        'uas',
        'nilai_akhir'
    ];

    // Relasi ke Jadwal
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'id_jadwal');
    }

    // Relasi ke Siswa
    public function student()
    {
        return $this->belongsTo(Student::class, 'id_siswa');
    }
}
