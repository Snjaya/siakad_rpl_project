<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $table = 'academic_years';
    protected $primaryKey = 'id_tahun'; // Sesuai SKPL

    protected $fillable = [
        'tahun_ajaran', // Contoh: 2024/2025
        'semester',     // Ganjil / Genap
        'status_aktif', // 1 (Aktif) atau 0 (Tidak)
    ];
}
