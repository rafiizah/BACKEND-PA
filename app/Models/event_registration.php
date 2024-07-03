<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class event_registration extends Model
{
    protected $table = 'event_registration';

    protected $fillable = ['umkm_id', 'event_id', 'date', 'status'];

    // Relasi dengan UMKM
    public function umkm()
    {
        return $this->belongsTo('App\Models\umkm', 'umkm_id');
    }

    // Relasi dengan Event
    public function event()
    {
        return $this->belongsTo('App\Models\event', 'event_id');
    }
}
