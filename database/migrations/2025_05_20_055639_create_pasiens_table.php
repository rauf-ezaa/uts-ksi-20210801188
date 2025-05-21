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
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('no_rekam_medis')->unique(); // nomor rekam medis
            $table->date('tanggal_lahir');
            $table->text('alamat')->nullable();

            $table->text('diagnosa')->nullable();
            $table->text('riwayat')->nullable();
            $table->string('kontak_darurat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
