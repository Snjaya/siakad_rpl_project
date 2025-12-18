<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    // Menghubungkan ke tabel 'classes'
    protected $table = 'classes';

    // Primary Key sesuai migrasi
    protected $primaryKey = 'id_kelas';

    protected $fillable = [
        'nama_kelas',   // Contoh: X RPL 1
        'tingkat',      // Contoh: 10, 11, 12
        'nip_teacher',  // Foreign Key Wali Kelas
    ];

    // Relasi: Kelas milik satu Wali Kelas (Teacher)
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'nip_teacher', 'nip');
    }

    // Relasi: Kelas punya banyak Siswa (Nanti dipakai)
    public function students()
    {
        return $this->hasMany(Student::class, 'id_kelas', 'id_kelas');
    }
}
