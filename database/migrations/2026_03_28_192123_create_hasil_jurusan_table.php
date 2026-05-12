<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_jurusan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('jurusan_kuliah_id')->constrained('jurusan_kuliah')->cascadeOnDelete();
            $table->decimal('score', 6, 2)->default(0); // 0.00 – 100.00
            $table->integer('rank')->default(0);
            $table->unique(['siswa_id', 'jurusan_kuliah_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_jurusan');
    }
};
