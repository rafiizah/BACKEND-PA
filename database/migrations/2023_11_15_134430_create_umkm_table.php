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
        Schema::create('umkm', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemilik', 100);
            $table->string('nomor_pemilik', 13);
            $table->string('alamat_pemilik', 100);
            $table->string('nama_usaha', 100);
            $table->string('alamat_usaha', 100);
            $table->string('domisili_usaha', 50);
            $table->string('kodePos_usaha');
            $table->string('email_usaha', 100);
            $table->string('tahunBerdiri_usaha');
            $table->string('jenisbadan_usaha', 100);
            $table->string('kategori_usaha', 100);
            $table->string('image');
            $table->text('deskripsi_usaha');
            $table->string('legalitas_usaha');
            $table->foreignId('user_id')->constrained('users')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm');
    }
};
