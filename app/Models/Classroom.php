<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    // Nama tabel di database (jamak)
    protected $table = 'classes';

    protected $fillable = [
        'nama_kelas',
        'jurusan',
        'tingkat',
        'nip_teacher',
    ];

    /**
     * Relasi: Satu Kelas memiliki banyak Siswa
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'id_kelas', 'id');
    }

    /**
     * Relasi: Satu Kelas memiliki satu Wali Kelas (Guru)
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'nip_teacher', 'nip');
    }
}
