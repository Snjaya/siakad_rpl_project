<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            // Ubah kolom no_hp jadi nullable
            $table->string('no_hp')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            // Kembalikan jadi tidak boleh kosong (jika rollback)
            $table->string('no_hp')->nullable(false)->change();
        });
    }
};
