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
        Schema::table('detail_peminjaman', function (Blueprint $table) {
            $table->dropForeign(['id_buku']);
            $table->dropColumn('id_buku');
            $table->unsignedBigInteger('id_eksemplar')->after('id_peminjaman');
            $table->foreign('id_eksemplar')->references('id_eksemplar')->on('eksemplars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detail_peminjaman', function (Blueprint $table) {
            $table->dropForeign(['id_eksemplar']);
            $table->dropColumn('id_eksemplar');
            $table->unsignedBigInteger('id_buku')->after('id_peminjaman');
            $table->foreign('id_buku')->references('id_buku')->on('buku')->onDelete('cascade');
        });
    }
};
