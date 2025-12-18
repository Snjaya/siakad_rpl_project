<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    // Menghubungkan ke tabel 'students'
    protected $table = 'students';

    // Primary Key adalah 'nis' (bukan id auto increment)
    protected $primaryKey = 'nis';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nis',
        'id_user',      // Foreign Key ke tabel users
        'nama_siswa',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'id_kelas',     // Foreign Key ke tabel classes
    ];

    // Relasi: Siswa memiliki satu User Akun
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi: Siswa masuk dalam satu Kelas
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'id_kelas', 'id_kelas');
    }
}
