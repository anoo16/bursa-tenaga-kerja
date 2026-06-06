<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            // Tipe pekerjaan (dipisah dari kategori/bidang industri)

            // Gaji dalam angka untuk filter range
            $table->unsignedBigInteger('gaji_min_angka')->nullable()->after('gaji');
            $table->unsignedBigInteger('gaji_max_angka')->nullable()->after('gaji_min_angka');
        });
    }

    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn(['gaji_min_angka', 'gaji_max_angka']);
        });
    }
};