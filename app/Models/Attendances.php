<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendances extends Model
{
    protected $fillable = ['user_id', 'clock_in', 'clock_out'];
}
