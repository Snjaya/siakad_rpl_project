<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'teachers';
    protected $fillable = [
        'id_user',
        'nip',
        'nama_guru',
        'email',
        'no_hp',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat'
    ];

    // Relasi ke User (menggunakan 'id_user')
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
