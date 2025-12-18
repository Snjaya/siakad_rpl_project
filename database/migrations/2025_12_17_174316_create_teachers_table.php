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
        Schema::create('teachers', function (Blueprint $table) {
            $table->string('nip')->primary(); // [cite: 73]
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); // [cite: 73]
            $table->string('nama_guru'); // [cite: 73]
            $table->date('tanggal_lahir'); // [cite: 73]
            $table->text('alamat'); // [cite: 73]
            $table->string('no_hp'); // [cite: 73]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
