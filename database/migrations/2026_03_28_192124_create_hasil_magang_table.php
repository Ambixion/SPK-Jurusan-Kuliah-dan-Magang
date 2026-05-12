<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_magang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswa')->cascadeOnDelete();
            $table->foreignId('tempat_magang_id')->constrained('tempat_magang')->cascadeOnDelete();
            $table->decimal('score', 6, 2)->default(0); // 0.00 – 100.00
            $table->integer('rank')->default(0);
            $table->unique(['siswa_id', 'tempat_magang_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_magang');
    }
};
