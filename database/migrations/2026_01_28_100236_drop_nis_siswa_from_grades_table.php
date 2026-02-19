<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. COBA HAPUS FOREIGN KEY (grades_nis_siswa_foreign)
        try {
            Schema::table('grades', function (Blueprint $table) {
                $table->dropForeign(['nis_siswa']);
            });
        } catch (\Throwable $e) {
            // Biarkan lanjut jika foreign key tidak ditemukan
        }

        // 2. COBA HAPUS INDEX (grades_nis_siswa_index)
        // Ini langkah yang sering bikin error, kita pisah dan bungkus agar aman
        try {
            Schema::table('grades', function (Blueprint $table) {
                $table->dropIndex(['nis_siswa']);
            });
        } catch (\Throwable $e) {
            // Biarkan lanjut jika index tidak ditemukan (Fix error 1091)
        }

        // 3. BARU HAPUS KOLOMNYA
        Schema::table('grades', function (Blueprint $table) {
            if (Schema::hasColumn('grades', 'nis_siswa')) {
                $table->dropColumn('nis_siswa');
            }

            // Bersih-bersih kolom sisa lain 'nis' (jika ada)
            if (Schema::hasColumn('grades', 'nis')) {
                $table->dropColumn('nis');
            }
        });
    }

    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            if (!Schema::hasColumn('grades', 'nis_siswa')) {
                $table->string('nis_siswa')->nullable();
            }
        });
    }
};
