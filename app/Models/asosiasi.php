<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\user;

class asosiasi extends Model
{
    use HasFactory;
    protected $table = 'asosiasi';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'user_id', 'namalengkap_asosiasi', 'namasingkat_asosiasi', 'alamat_asosiasi', 'domisili_asosiasi', 'email_asosiasi', 'nomor_wa_asosiasi', 'website_asosiasi', 'nama_pimpinan_asosiasi', 'tahun_berdiri_asosiasi', 'jenis_bidang_asosiasi', 'jumlah_anggota_umkm', 'legalitas_asosiasi', 'image',];

    public function user()
    {
        return $this->belongsTo(user::class, 'user_id');
    }
}
