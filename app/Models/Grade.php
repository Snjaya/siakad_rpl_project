<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'grades';

    protected $fillable = [
        'id_jadwal', // ID Jadwal Pelajaran
        'nis_siswa', // NIS Siswa (bukan ID, sesuai controller tadi)
        'tugas',
        'uts',
        'uas',
        'nilai_akhir'
    ];

    /**
     * Relasi ke Jadwal
     */
    public function jadwal()
    {
        return $this->belongsTo(Schedule::class, 'id_jadwal', 'id');
    }

    /**
     * Relasi ke Siswa
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'nis_siswa', 'nis');
    }
}
