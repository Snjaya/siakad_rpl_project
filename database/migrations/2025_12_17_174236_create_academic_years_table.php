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
        Schema::create('academic_years', function (Blueprint $table) {
            $table->id('id_tahun'); // [cite: 87]
            $table->string('tahun_ajaran'); // Contoh: 2024/2025 [cite: 87]
            $table->enum('semester', ['Ganjil', 'Genap']); // [cite: 87]
            $table->enum('status_aktif', ['Aktif', 'Tidak Aktif']); // [cite: 87]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahun_ajarans');
    }
};
