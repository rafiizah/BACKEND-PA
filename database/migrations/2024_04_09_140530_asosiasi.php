<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asosiasi', function (Blueprint $table) {
            $table->id();
            $table->string('namalengkap_asosiasi', 100);
            $table->string('namasingkat_asosiasi', 13);
            $table->string('alamat_asosiasi', 100);
            $table->string('domisili_asosiasi', 100);
            $table->string('email_asosiasi', 100);
            $table->string('nomor_wa_asosiasi', 100);
            $table->string('website_asosiasi', 50);
            $table->string('nama_pimpinan_asosiasi');
            $table->string('tahun_berdiri_asosiasi', 100);
            $table->string('jenis_bidang_asosiasi');
            $table->string('jumlah_anggota_umkm', 100);
            $table->string('legalitas_asosiasi', 100);
            $table->string('image');
            $table->foreignId('user_id')->constrained('users')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asosiasi');
    }
};
