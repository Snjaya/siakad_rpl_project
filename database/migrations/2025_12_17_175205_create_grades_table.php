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
            $table->id();

            // PERBAIKAN DI SINI:
            // Menghubungkan 'id_jadwal' ke tabel 'schedules' (kolom id)
            $table->foreignId('id_jadwal')->constrained('schedules')->onDelete('cascade');

            // Untuk siswa, kita gunakan NIS sebagai referensi (karena di seeder pakai NIS)
            // Pastikan kolom 'nis' di tabel 'students' bersifat unique/index
            $table->string('nis_siswa');
            $table->foreign('nis_siswa')->references('nis')->on('students')->onDelete('cascade');

            // Kolom Nilai
            $table->integer('tugas')->default(0);
            $table->integer('uts')->default(0);
            $table->integer('uas')->default(0);
            $table->float('nilai_akhir')->nullable(); // Boleh kosong dulu (dihitung nanti)

            $table->timestamps();
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
