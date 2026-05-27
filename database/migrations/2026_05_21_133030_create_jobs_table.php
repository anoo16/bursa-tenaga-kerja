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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
             // Posisi pekerjaan
            $table->string('posisi');

            // Jenis pekerjaan
            $table->string('kategori');

            // Rentang gaji
            $table->string('gaji');

            
            //Menyimpan banyak tanggung jawab
            
            $table->json('tanggung_jawab');

            
            //Menyimpan banyak kualifikasi
            $table->json('kualifikasi');

            /*
            draft = belum dipublikasi
            aktif = lowongan aktif
            ditutup = lowongan ditutup
            */
            $table->enum(
                'status',
                ['buka','tutup']
            )->default('buka');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
