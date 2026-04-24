<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eksemplar extends Model
{
    protected $table = 'eksemplars';
    protected $primaryKey = 'id_eksemplar';
    protected $guarded = [];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }

    public function detailPeminjamans()
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_eksemplar', 'id_eksemplar');
    }
}
