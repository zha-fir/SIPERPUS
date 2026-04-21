<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
    protected $guarded = [];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'id_anggota', 'id_anggota');
    }

    public function pengunjungs()
    {
        return $this->hasMany(Pengunjung::class, 'id_anggota', 'id_anggota');
    }
}
