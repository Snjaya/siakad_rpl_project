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
            $table->id('id_jadwal'); // [cite: 81]
            $table->unsignedBigInteger('id_kelas'); // [cite: 81]
            $table->unsignedBigInteger('id_mapel'); // [cite: 81]
            $table->string('nip_teacher'); // Guru Pengampu [cite: 81]
            $table->string('hari'); // [cite: 81]
            $table->time('jam_mulai'); // [cite: 81]
            $table->time('jam_selesai'); // [cite: 81]
            $table->foreign('id_kelas')->references('id_kelas')->on('classes');
            $table->foreign('id_mapel')->references('id_mapel')->on('subjects');
            $table->foreign('nip_teacher')->references('nip')->on('teachers');
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
