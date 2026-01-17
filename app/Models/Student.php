<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kelas',
        'nis',
        'nama_siswa',
        'jenis_kelamin',
        'email',
        'no_hp',
        'id_user' // Jika ada relasi ke user login
    ];

    /**
     * Relasi ke Kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Classroom::class, 'id_kelas', 'id');
    }

    /**
     * Relasi ke User (Akun Login)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relasi ke Nilai (Grades) - INI YANG KETINGGALAN
     * Menghubungkan tabel students (nis) ke grades (nis_siswa)
     */
    public function grades()
    {
        // hasMany(Model Tujuan, Foreign Key di tabel tujuan, Local Key di tabel ini)
        return $this->hasMany(Grade::class, 'nis_siswa', 'nis');
    }
}
