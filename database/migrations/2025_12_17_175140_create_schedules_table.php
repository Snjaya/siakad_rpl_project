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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();

            // Perbaikan Foreign Keys:
            // Menghubungkan 'id_kelas' ke tabel 'classes' (kolom id)
            $table->foreignId('id_kelas')->constrained('classes')->onDelete('cascade');

            // Menghubungkan 'id_mapel' ke tabel 'subjects' (kolom id)
            $table->foreignId('id_mapel')->constrained('subjects')->onDelete('cascade');

            // Menghubungkan 'id_guru' ke tabel 'teachers' (kolom id)
            $table->foreignId('id_guru')->constrained('teachers')->onDelete('cascade');

            $table->string('hari');       // Senin, Selasa, dst
            $table->time('jam_mulai');
            $table->time('jam_selesai');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
