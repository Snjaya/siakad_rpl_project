<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';
    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'id_kelas',
        'id_mapel',
        'nip_teacher', // PERBAIKAN: Gunakan nip_teacher
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'id_kelas', 'id_kelas');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'id_mapel', 'id_mapel');
    }

    public function teacher()
    {
        // PERBAIKAN: Relasi ke kolom nip_teacher
        return $this->belongsTo(Teacher::class, 'nip_teacher', 'nip');
    }
}
