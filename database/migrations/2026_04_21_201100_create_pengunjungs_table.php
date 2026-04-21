<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengunjung', function (Blueprint $table) {
            $table->id('id_pengunjung');
            $table->unsignedBigInteger('id_anggota')->nullable();
            $table->string('nama_pengunjung')->nullable();
            $table->string('instansi')->nullable();
            $table->enum('tipe', ['anggota', 'umum']);
            $table->date('tanggal_kunjungan');
            $table->time('jam_masuk');
            $table->timestamps();

            $table->foreign('id_anggota')->references('id_anggota')->on('anggota')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengunjung');
    }
};
