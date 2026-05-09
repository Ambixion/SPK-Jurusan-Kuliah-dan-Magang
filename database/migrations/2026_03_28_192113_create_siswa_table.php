<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('jurusan_smk_id')->nullable()->constrained('jurusan_smk')->nullOnDelete();
            $table->string('nisn', 20)->nullable()->unique();
            $table->string('kelas')->nullable();
            $table->integer('semester')->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->text('alamat')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
