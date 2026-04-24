<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    protected $guarded = [];

    public function eksemplars()
    {
        return $this->hasMany(Eksemplar::class, 'id_buku', 'id_buku');
    }
}
