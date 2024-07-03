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
        Schema::create('event', function (Blueprint $table) {
            $table->id();
            $table->string('nama_event', 100);
            $table->date('date')->nullable();
            $table->string('time')->nullable();
            $table->string('location')->nullable();
            $table->string('description')->nullable();
            $table->string('image');
            // $table->foreignId('umkm_id')->constrained('umkm')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event');
    }
};