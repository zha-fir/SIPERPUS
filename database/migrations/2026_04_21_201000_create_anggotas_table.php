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
            $table->enum('tipe_anggota', ['Siswa', 'Guru', 'Staf'])->default('Siswa');
            $table->string('nomor_identitas')->unique()->comment('NIS untuk Siswa, NIP untuk Guru/Staf');
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('kelas_atau_jabatan')->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('foto_profil')->nullable();
            $table->date('tanggal_daftar');
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->enum('status_anggota', ['aktif', 'tidak_aktif', 'lulus', 'diblokir'])->default('aktif');
            $table->string('barcode')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
