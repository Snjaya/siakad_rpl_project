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
            $table->id('id_nilai'); // [cite: 83]
            $table->string('nis'); // [cite: 83]
            $table->unsignedBigInteger('id_mapel'); // [cite: 83]
            $table->string('nip_teacher'); // [cite: 83]
            $table->unsignedBigInteger('id_tahun'); // [cite: 83]
            $table->integer('nilai_angka'); // [cite: 83]
            $table->foreign('nis')->references('nis')->on('students');
            $table->foreign('id_mapel')->references('id_mapel')->on('subjects');
            $table->foreign('nip_teacher')->references('nip')->on('teachers');
            $table->foreign('id_tahun')->references('id_tahun')->on('academic_years');
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
