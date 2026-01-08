<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id('id_nilai');

            // Menghubungkan nilai ke Jadwal (agar tahu Mapel, Guru, dan Kelasnya siapa)
            $table->unsignedBigInteger('id_jadwal');

            // Menghubungkan ke Siswa
            $table->string('nis_siswa'); // Pastikan tipe data sama dengan kolom 'nis' di tabel students

            // Kolom Rincian Nilai
            $table->double('tugas')->default(0);
            $table->double('uts')->default(0);
            $table->double('uas')->default(0);
            $table->double('nilai_akhir')->default(0);

            $table->timestamps();

            // Foreign Keys
            $table->foreign('id_jadwal')->references('id_jadwal')->on('schedules')->onDelete('cascade');
            $table->foreign('nis_siswa')->references('nis')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
