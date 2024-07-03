<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    protected $table = 'event';
    protected $fillable = ['nama_event', 'date', 'time', 'location', 'description', 'image',];

    public function event_registration()
    {
        return $this->hasMany('App\Models\event_registration', 'id_event');
    }
}