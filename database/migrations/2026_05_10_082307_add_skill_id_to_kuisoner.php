<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambah kolom skill_id ke tabel kuisoner agar soal bisa dikaitkan ke skill tertentu.
 * Soal PKL dengan skill_id = muncul khusus jika siswa punya skill itu.
 * Soal dengan skill_id NULL = soal global (muncul untuk semua).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kuisoner', function (Blueprint $table) {
            if (!Schema::hasColumn('kuisoner', 'skill_id')) {
                $table->foreignId('skill_id')
                      ->nullable()
                      ->after('bidang_id')
                      ->constrained('skill')
                      ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('kuisoner', function (Blueprint $table) {
            if (Schema::hasColumn('kuisoner', 'skill_id')) {
                $table->dropConstrainedForeignId('skill_id');
            }
        });
    }
};
