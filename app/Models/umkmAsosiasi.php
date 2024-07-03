<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class umkmAsosiasi extends Model
{
    protected $table = 'umkm_asosiasi';

    protected $fillable = [
        'umkm_id',
        'asosiasi_id',
        'tanggal_bergabung',
        'di_terima'
    ];

    // Relasi dengan UMKM
    public function umkm()
    {
        return $this->belongsTo('App\Models\umkm', 'umkm_id');
    }

    // Relasi dengan Asosiasi
    public function asosiasi()
    {
        return $this->belongsTo('App\Models\asosiasi', 'asosiasi_id');
    }
}
