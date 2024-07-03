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
        Schema::create('umkm_asosiasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('umkm_id')->constrained('umkm')->nullable()->onDelete('cascade');
            $table->foreignId('asosiasi_id')->constrained('asosiasi')->nullable()->onDelete('cascade');;
            $table->date('tanggal_bergabung')->nullable();
            $table->boolean('di_terima')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};