<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Fix kolom score di hasil_magang & hasil_jurusan.
 * decimal(5,3) hanya bisa simpan max 99.999 → error saat score = 100.
 * Ubah ke decimal(6,2) → bisa simpan 0.00 sampai 9999.99.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hasil_magang', function (Blueprint $table) {
            $table->decimal('score', 6, 2)->change();
        });

        Schema::table('hasil_jurusan', function (Blueprint $table) {
            $table->decimal('score', 6, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('hasil_magang', function (Blueprint $table) {
            $table->decimal('score', 5, 3)->change();
        });

        Schema::table('hasil_jurusan', function (Blueprint $table) {
            $table->decimal('score', 5, 3)->change();
        });
    }
};
