<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\user;

class umkm extends Model
{
    use HasFactory;
    protected $table = 'umkm';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nama_pemilik', 'nomor_pemilik', 'alamat_pemilik', 'user_id', 'nama_usaha', 'alamat_usaha', 'domisili_usaha', 'kodePos_usaha', 'email_usaha', 'tahunBerdiri_usaha', 'jenisbadan_usaha', 'kategori_usaha', 'image', 'deskripsi_usaha', 'legalitas_usaha'];

    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }

    public function event_registration()
    {
        return $this->hasMany('App\Models\event_registration', 'id_umkm');
    }
}