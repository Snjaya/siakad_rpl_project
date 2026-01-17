<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $fillable = [
        'id_kelas',
        'id_mapel',
        'id_guru',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    /**
     * Relasi ke Kelas (Classroom)
     */
    public function kelas()
    {
        // belongsTo(Model, Foreign Key di tabel ini, Primary Key di tabel tujuan)
        return $this->belongsTo(Classroom::class, 'id_kelas', 'id');
    }

    /**
     * Relasi ke Mata Pelajaran (Subject)
     */
    public function subject() // atau mapel() sesuaikan pemanggilan di controller/view
    {
        return $this->belongsTo(Subject::class, 'id_mapel', 'id');
    }

    /**
     * Relasi ke Guru (Teacher)
     */
    public function teacher() // atau guru() sesuaikan pemanggilan di controller/view
    {
        return $this->belongsTo(Teacher::class, 'id_guru', 'id');
    }
}
