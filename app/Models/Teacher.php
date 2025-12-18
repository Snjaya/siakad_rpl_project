<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'teachers';

    // Primary Key adalah 'nip' (bukan id)
    protected $primaryKey = 'nip';
    public $incrementing = false; // Karena NIP bukan auto-increment
    protected $keyType = 'string';

    protected $fillable = [
        'nip',
        'id_user', // Sesuai migration: foreignId('id_user')
        'nama_guru',
        'tanggal_lahir',
        'alamat',
        'no_hp',
    ];

    // Relasi ke User (menggunakan 'id_user')
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
