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
        Schema::create('eksemplars', function (Blueprint $table) {
            $table->id('id_eksemplar');
            $table->unsignedBigInteger('id_buku');
            $table->string('kode_eksemplar')->unique();
            $table->enum('status', ['Tersedia', 'Dipinjam', 'Rusak', 'Hilang'])->default('Tersedia');
            $table->timestamps();

            $table->foreign('id_buku')->references('id_buku')->on('buku')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eksemplars');
    }
};
