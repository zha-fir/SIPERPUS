<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota', function (Blueprint $table) {
            $table->id('id_anggota');
            $table->string('nis')->unique();
            $table->string('nama');
            $table->string('kelas');
            $table->enum('status', ['aktif', 'tidak_aktif', 'ditangguhkan'])->default('aktif');
            $table->string('barcode')->unique();
            $table->date('tanggal_daftar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
