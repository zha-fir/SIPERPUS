<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id('id_buku');
            $table->string('kode_buku')->unique()->comment('Barcode/Item Code');
            $table->string('isbn_issn')->nullable();
            $table->string('judul_buku');
            $table->string('edisi')->nullable();
            $table->string('penulis');
            $table->string('penerbit');
            $table->year('tahun_terbit');
            $table->string('tempat_terbit')->nullable();
            $table->string('klasifikasi_ddc')->nullable()->comment('Contoh: 800, 004');
            $table->string('deskripsi_fisik')->nullable()->comment('Contoh: ix, 200 hlm.; 21 cm');
            $table->string('lokasi_rak')->nullable();
            $table->string('gambar_cover')->nullable();
            $table->integer('jumlah_total')->default(0);
            $table->integer('jumlah_tersedia')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
