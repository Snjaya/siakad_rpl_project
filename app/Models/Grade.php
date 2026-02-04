<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_jadwal',
        'nis_siswa', // Pastikan ini nis_siswa
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
        return $this->belongsTo(Schedule::class, 'id_jadwal');
    }

    /**
     * Relasi ke Siswa
     * Karena foreign key di grades adalah 'nis_siswa' dan merujuk ke 'nis' di tabel students
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'nis_siswa', 'nis');
    }

    // Alias agar kode lama tidak error
    public function schedule() { return $this->jadwal(); }
}
