<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <--- JANGAN LUPA TAMBAHKAN INI

return new class extends Migration
{
    public function up()
    {
        // 1. KOSONGKAN DATA LAMA DULU (PENTING!)
        // Ini akan menghapus semua data nilai test sebelumnya agar tidak error
        DB::table('grades')->truncate();

        Schema::table('grades', function (Blueprint $table) {
            // 2. Hapus kolom lama (Bahasa Inggris) jika ada
            if (Schema::hasColumn('grades', 'id_schedule')) {
                // Kita perlu drop foreign key-nya dulu jika ada, untuk menghindari error
                // Coba drop constraint dengan nama umum, pakai try catch biar aman
                try {
                    $table->dropForeign(['id_schedule']);
                } catch (\Exception $e) {
                }
                $table->dropColumn('id_schedule');
            }

            if (Schema::hasColumn('grades', 'id_student')) {
                try {
                    $table->dropForeign(['id_student']);
                } catch (\Exception $e) {
                }
                $table->dropColumn('id_student');
            }

            // 3. Tambahkan kolom baru (Bahasa Indonesia)
            if (!Schema::hasColumn('grades', 'id_jadwal')) {
                $table->foreignId('id_jadwal')->after('id')->constrained('schedules')->onDelete('cascade');
            }
            if (!Schema::hasColumn('grades', 'id_siswa')) {
                $table->foreignId('id_siswa')->after('id_jadwal')->constrained('students')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            // Hapus kolom baru jika rollback
            if (Schema::hasColumn('grades', 'id_jadwal')) {
                $table->dropForeign(['id_jadwal']);
                $table->dropColumn('id_jadwal');
            }
            if (Schema::hasColumn('grades', 'id_siswa')) {
                $table->dropForeign(['id_siswa']);
                $table->dropColumn('id_siswa');
            }
        });
    }
};
