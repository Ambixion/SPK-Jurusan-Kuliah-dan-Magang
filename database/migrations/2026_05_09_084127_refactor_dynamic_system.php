<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah tabel bidang (master bidang keahlian)
        Schema::create('bidang', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('deskripsi')->nullable();
            $table->timestamps();
        });

        // 2. Pivot: jurusan_smk <-> bidang
        Schema::create('jurusan_smk_bidang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurusan_smk_id')->constrained('jurusan_smk')->cascadeOnDelete();
            $table->foreignId('bidang_id')->constrained('bidang')->cascadeOnDelete();
            $table->timestamps();
        });

        // 3. Pivot: bidang <-> skill
        Schema::create('bidang_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bidang_id')->constrained('bidang')->cascadeOnDelete();
            $table->foreignId('skill_id')->constrained('skill')->cascadeOnDelete();
            $table->timestamps();
        });

        // 4. Pivot: jurusan_kuliah <-> bidang
        Schema::create('jurusan_kuliah_bidang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurusan_kuliah_id')->constrained('jurusan_kuliah')->cascadeOnDelete();
            $table->foreignId('bidang_id')->constrained('bidang')->cascadeOnDelete();
            $table->timestamps();
        });

        // 5. Pivot: tempat_magang <-> bidang
        Schema::create('tempat_magang_bidang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tempat_magang_id')->constrained('tempat_magang')->cascadeOnDelete();
            $table->foreignId('bidang_id')->constrained('bidang')->cascadeOnDelete();
            $table->timestamps();
        });

        // 6. Update tabel kuisoner: tambah relasi ke jurusan_kuliah, bidang, kriteria
        Schema::table('kuisoner', function (Blueprint $table) {
            $table->foreignId('jurusan_kuliah_id')
                  ->nullable()
                  ->after('type')
                  ->constrained('jurusan_kuliah')
                  ->nullOnDelete();

            $table->foreignId('bidang_id')
                  ->nullable()
                  ->after('jurusan_kuliah_id')
                  ->constrained('bidang')
                  ->nullOnDelete();

            $table->foreignId('kriteria_id')
                  ->nullable()
                  ->after('bidang_id')
                  ->constrained('kriteria')
                  ->nullOnDelete();

            $table->integer('urutan')->default(0)->after('kriteria_id');
        });

        // NOTE: Kolom kelas, semester, no_telp, alamat sudah ada di create_siswa_table
        // Tidak perlu alter table siswa di sini lagi.
    }

    public function down(): void
    {
        Schema::table('kuisoner', function (Blueprint $table) {
            $table->dropConstrainedForeignId('jurusan_kuliah_id');
            $table->dropConstrainedForeignId('bidang_id');
            $table->dropConstrainedForeignId('kriteria_id');
            $table->dropColumn('urutan');
        });

        Schema::dropIfExists('tempat_magang_bidang');
        Schema::dropIfExists('jurusan_kuliah_bidang');
        Schema::dropIfExists('bidang_skill');
        Schema::dropIfExists('jurusan_smk_bidang');
        Schema::dropIfExists('bidang');
    }
};
