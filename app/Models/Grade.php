<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'grades';
    protected $primaryKey = 'id_nilai'; // Sesuaikan dengan migration (biasanya id atau id_nilai)

    protected $fillable = [
        'id_jadwal', // Link ke jadwal (Mapel + Kelas + Guru)
        'nis_siswa', // Link ke siswa
        'tugas',
        'uts',
        'uas',
        'nilai_akhir', // (Opsional) Bisa hitung otomatis: (Tugas+UTS+UAS)/3
    ];

    // Relasi ke Jadwal
    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'id_jadwal', 'id_jadwal');
    }

    // Relasi ke Siswa
    public function student()
    {
        return $this->belongsTo(Student::class, 'nis_siswa', 'nis');
    }
}
