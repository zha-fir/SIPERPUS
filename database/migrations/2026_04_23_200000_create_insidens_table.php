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
        Schema::create('insidens', function (Blueprint $table) {
            $table->id('id_insiden');
            $table->string('kode_tiket')->unique();
            $table->string('pelapor_nama');
            $table->string('pelapor_email')->nullable();
            $table->enum('pelapor_tipe', ['Siswa', 'Guru', 'Staf', 'Umum'])->default('Siswa');
            $table->enum('kategori', ['Kerusakan Fasilitas', 'Kendala Sistem', 'Usulan Buku', 'Kehilangan Buku', 'Kehilangan Kartu', 'Lainnya'])->default('Lainnya');
            $table->enum('prioritas', ['Rendah', 'Sedang', 'Tinggi', 'Kritis'])->default('Sedang');
            $table->string('judul_insiden');
            $table->text('deskripsi');
            $table->string('lampiran')->nullable();
            $table->enum('status', ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'])->default('Menunggu');
            $table->text('tanggapan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insidens');
    }
};
