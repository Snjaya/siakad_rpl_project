<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    // Pastikan fillable sesuai dengan nama kolom yang ada di database
    protected $fillable = [
        'id_jadwal',  // Sesuai update kamu
        'id_siswa',   // Sesuai update kamu
        'tugas',
        'uts',
        'uas',
        'nilai_akhir'
    ];

    /**
     * Relasi ke Jadwal
     * Nama fungsi 'jadwal' agar sinkron dengan $grade->jadwal di file Blade
     */
    public function jadwal()
    {
        // Parameter kedua adalah Foreign Key di tabel grades
        return $this->belongsTo(Schedule::class, 'id_jadwal');
    }

    /**
     * Relasi ke Siswa
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'id_siswa');
    }

    /**
     * Optional: Jika kamu masih ingin menyimpan fungsi dengan nama 'schedule' 
     */
    public function schedule()
    {
        return $this->jadwal();
    }
}
