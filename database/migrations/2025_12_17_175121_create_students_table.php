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
        Schema::create('students', function (Blueprint $table) {
            $table->string('nis')->primary(); // [cite: 70]
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); // [cite: 70]
            $table->string('nama_siswa'); // [cite: 70]
            $table->date('tanggal_lahir'); // [cite: 70]
            $table->text('alamat'); // [cite: 71]
            $table->string('no_hp'); // [cite: 71]
            $table->unsignedBigInteger('id_kelas'); // [cite: 71]
            $table->foreign('id_kelas')->references('id_kelas')->on('classes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
