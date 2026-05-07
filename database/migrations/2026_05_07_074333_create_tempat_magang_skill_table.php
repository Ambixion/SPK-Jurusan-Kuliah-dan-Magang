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
        Schema::create('tempat_magang_skill', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tempat_magang_id')->constrained('tempat_magang')->onDelete('cascade');
            $table->foreignId('skill_id')->constrained('skill')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tempat_magang_skill');
    }
};
