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
        Schema::create('classes', function (Blueprint $table) {
            $table->id('id_kelas'); // [cite: 77]
            $table->string('nama_kelas'); // [cite: 77]
            $table->integer('tingkat'); // [cite: 77]
            $table->string('nip_teacher'); // Wali Kelas [cite: 77]
            $table->foreign('nip_teacher')->references('nip')->on('teachers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
