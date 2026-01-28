<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('grades', function (Blueprint $table) {
            // LANGSUNG HAPUS KOLOMNYA (Tanpa dropForeign)
            // Karena error sebelumnya menandakan foreign key-nya sudah hilang

            if (Schema::hasColumn('grades', 'nis_siswa')) {
                $table->dropColumn('nis_siswa');
            }

            // Bersih-bersih kolom sisa lain (jika ada)
            if (Schema::hasColumn('grades', 'nis')) {
                $table->dropColumn('nis');
            }
        });
    }

    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            // Kembalikan kolom jika rollback
            if (!Schema::hasColumn('grades', 'nis_siswa')) {
                $table->string('nis_siswa')->nullable();
            }
        });
    }
};
