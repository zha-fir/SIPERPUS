<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insiden extends Model
{
    use HasFactory;

    protected $table = 'insidens';
    protected $primaryKey = 'id_insiden';
    protected $guarded = [];

    // Helper to get status color
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'Menunggu' => 'amber',
            'Diproses' => 'blue',
            'Selesai' => 'emerald',
            'Ditolak' => 'rose',
            default => 'slate',
        };
    }

    // Helper to get priority color
    public function getPrioritasColorAttribute()
    {
        return match($this->prioritas) {
            'Kritis' => 'rose',
            'Tinggi' => 'orange',
            'Sedang' => 'blue',
            'Rendah' => 'slate',
            default => 'slate',
        };
    }
}
